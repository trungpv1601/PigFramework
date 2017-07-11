<?php
namespace App\Controllers;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

/**
 * Handles all requests to /.
 *
 * @author Michael Meyer <michael@meyer.io>
 */
class IndexController
{
    /** @var Twig_Environment */
    private $twig;

    /**
     * IndexController, constructed by the container
     *
     * @param Twig_Environment $twig
     */
    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Index page
     *
     * @return Response
     */
    public function index()
    {
        return new Response($this->twig->render('pages/index.html.twig'));
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
