<?php
namespace App\Controllers;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

/**
 * Handles all requests error /.
 *
 */
class ErrorController
{
    /** @var Twig_Environment */
    private $view;

    /**
     * ErrorController, constructed by the container
     *
     * @param Twig_Environment $view
     */
    public function __construct(Twig_Environment $view)
    {
        $this->view = $view;
    }

    /**
     * 404 page
     *
     * @return Response
     */
    public function page404()
    {
        return new Response($this->view->render('errors/404.html.twig'));
    }

    /**
     * Throw an exception (for testing the error handler)
     *
     * @throws Exception
     */
    public function page405()
    {
        return new Response($this->view->render('errors/405.html.twig'));
    }
}
