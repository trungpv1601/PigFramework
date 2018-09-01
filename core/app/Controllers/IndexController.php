<?php
namespace App\Controllers;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use League\Plates\Engine;
use App\Models\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Handles all requests to /.
 *
 */
class IndexController extends Controller
{
    private $view;
    private $request;
    private $session;

    /**
     * IndexController, constructed by the container
     *
     * @param Engine $view
     */
    public function __construct(Engine $view, Session $session)
    {
        $this->view = $view;
        $this->request = Request::createFromGlobals();
        $this->session = $session;
    }

    /**
     * Index page
     *
     * @return Response
     */
    public function index()
    {
        return new Response($this->view->render('index', ['request' => $this->request]));
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
