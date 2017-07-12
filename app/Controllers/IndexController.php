<?php
namespace App\Controllers;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use League\Plates\Engine;

/**
 * Handles all requests to /.
 *
 * @author Michael Meyer <michael@meyer.io>
 */
class IndexController
{
    /** @var Twig_Environment */
    private $view;

    /**
     * IndexController, constructed by the container
     *
     * @param Twig_Environment $twig
     */
    public function __construct(Engine $view)
    {
        $this->view = $view;
    }

    /**
     * Index page
     *
     * @return Response
     */
    public function index()
    {
        return new Response($this->view->render('index', ['name' => 'Jonathan']));
    }

    /**
     * Login page
     *
     * @return Response
     */
    public function login()
    {
        return new Response($this->view->render('login'));
    }

    /**
     * Register page
     *
     * @return Response
     */
    public function register()
    {
        return new Response($this->view->render('register'));
    }

    /**
     * Throw an exception (for testing the error handler)
     *
     * @throws Exception
     */
    public function exception()
    {
        throw new Exception('Test exception');
    }
}
