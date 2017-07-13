<?php
namespace App\Controllers;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use League\Plates\Engine;
use Medoo\Medoo;

/**
 * Handles all requests to /.
 *
 * @author Michael Meyer <michael@meyer.io>
 */
class IndexController
{
    private $view;
    private $database;

    /**
     * IndexController, constructed by the container
     *
     * @param Engine $view
     */
    public function __construct(Engine $view, Medoo $database)
    {
        $this->view = $view;
        $this->database = $database;
    }

    /**
     * Index page
     *
     * @return Response
     */
    public function index()
    {
        return new Response($this->view->render('index'));
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
