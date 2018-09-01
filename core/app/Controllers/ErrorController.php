<?php
namespace App\Controllers;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use League\Plates\Engine;

/**
 * Handles all requests error
 *
 */
class ErrorController extends Controller
{
    private $view;
    private $request;

    /**
     * ErrorController, constructed by the container
     *
     * @param Engine $view
     */
    public function __construct(Engine $view)
    {
        $this->view = $view;
        $this->request  = Request::createFromGlobals();
    }

    /**
     * 404 page
     *
     * @return Response
     */
    public function page404()
    {
        $response = new Response($this->view->render('/errors/404'), Response::HTTP_NOT_FOUND);
        if ($response instanceof Response) {
            // Send the generated response back to the user
            $response
                    ->prepare($this->request)
                    ->send();
        }
    }

    /**
     * 405 page
     *
     * @return Response
     */
    public function page405()
    {
        $response = new Response($this->view->render('/errors/405'), Response::HTTP_METHOD_NOT_ALLOWED);
        if ($response instanceof Response) {
            // Send the generated response back to the user
            $response
                    ->prepare($this->request)
                    ->send();
        }
    }

    /**
     * 500 page
     *
     * @return Response
     */
    public function page500($message)
    {
        $response = new Response($this->view->render('/errors/500', ['message' => $message]));
        if ($response instanceof Response) {
            // Send the generated response back to the user
            $response
                    ->prepare($this->request)
                    ->send();
        }
    }
}
