<?php

use FastRoute\Dispatcher;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

require_once __DIR__ . '/../vendor/autoload.php';


/*
 * Request instance (use this instead of $_GET, $_POST, etc).
 */
$request = Request::createFromGlobals();


/*
 * Container setup
 * http://container.thephpleague.com/
 */
$container = new Container();
// Native PHP template http://platesphp.com/
$container
    ->add('League\Plates\Engine', new \League\Plates\Engine(__DIR__ . "/../views"));    
$container
    ->delegate(
        // Auto-wiring based on constructor typehints.
        // http://container.thephpleague.com/auto-wiring
        new ReflectionContainer()
    );
// Get Container App\Controllers\ErrorController
$errorController = $container->get('App\Controllers\ErrorController'); 

/*
 * Dotenv initialization
 * https://github.com/vlucas/phpdotenv
 */
if (file_exists(__DIR__ . '/../.env') !== true) {
    Response::create('Missing .env file (please copy .env.example).', Response::HTTP_INTERNAL_SERVER_ERROR)
        ->prepare($request)
        ->send();
    return;
}
$dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();


/*
 * Error handler
 * https://github.com/filp/whoops
 */
$whoops = new Run;
if (getenv('APP_DEBUG') === 'true') {
    $whoops->pushHandler(
        new PrettyPageHandler()
    );
} else {
    $whoops->pushHandler(
        // Using the pretty error handler in production is likely a bad idea.
        // Instead respond with a generic error message.
        function () use ($errorController) {
            // Response::create('An internal server error has occurred.', Response::HTTP_INTERNAL_SERVER_ERROR)
            //     ->prepare($request)
            //     ->send();
            $errorController->page500('An internal server error has occurred.');
        }
    );
}
$whoops->register();


/*
 * Database
 * https://medoo.in/api/new
 */
$container
    ->add('Medoo\Medoo')
    ->withArgument([
        'database_type' => getenv('DB_CONNECTION') ? getenv('DB_CONNECTION') : 'mysql',
        'server' => getenv('DB_HOST') ? getenv('DB_HOST') : 'localhost',
        'port' => getenv('DB_PORT') ? getenv('DB_PORT') : 3306,
        'database_name' => getenv('DB_DATABASE') ? getenv('DB_DATABASE') : 'name',
        'username' => getenv('DB_USERNAME') ? getenv('DB_USERNAME') : 'your_username',
        'password' => getenv('DB_PASSWORD') ? getenv('DB_PASSWORD') : ''
    ]);   

/*
 * Routes
 * https://github.com/nikic/FastRoute
 */
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $routes = require __DIR__ . '/../routes.php';
    foreach ($routes as $route) {
        $r->addRoute($route[0], $route[1], $route[2]);
    }
});


/*
 * Dispatch
 */
$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());
switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        // No matching route was found.

        $errorController->page404();
        // Response::create("404 Not Found", Response::HTTP_NOT_FOUND)
        //     ->prepare($request)
        //     ->send();
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        // A matching route was found, but the wrong HTTP method was used.

        $errorController->page405();
        // Response::create("405 Method Not Allowed", Response::HTTP_METHOD_NOT_ALLOWED)
        //     ->prepare($request)
        //     ->send();
        break;
    case Dispatcher::FOUND:
        // Fully qualified class name of the controller
        $fqcn = $routeInfo[1][0];
        // Controller method responsible for handling the request
        $routeMethod = $routeInfo[1][1];
        // Route parameters (ex. /products/{category}/{id})
        $routeParams = $routeInfo[2];

        // Obtain an instance of route's controller
        // Resolves constructor dependencies using the container
        $controller = $container->get($fqcn);

        // Generate a response by invoking the appropriate route method in the controller
        $response = $controller->$routeMethod($routeParams);
        if ($response instanceof Response) {
            // Send the generated response back to the user
            $response
                ->prepare($request)
                ->send();
        }
        break;
    default:
        // According to the dispatch(..) method's documentation this shouldn't happen.
        // But it's here anyways just to cover all of our bases.
        $errorController->page500('Received unexpected response from dispatcher');
        return;
}