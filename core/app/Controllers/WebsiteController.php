<?php
namespace App\Controllers;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use League\Plates\Engine;
use App\Models\Website;
use Symfony\Component\HttpFoundation\Request;
use Rakit\Validation\Validator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Validation\UniqueRule;
use JasonGrimes\Paginator;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Handles all requests to /websites
 *
 */
class WebsiteController extends Controller
{
    private $view;
    private $request;
    private $rules = [];
    private $session;

    /**
     * WebsiteController, constructed by the container
     *
     * @param Engine $view
     */
    public function __construct(Engine $view, Session $session)
    {
        $this->view = $view;
        $this->request = Request::createFromGlobals();
        $this->rules = [
            'name' => 'required',
            'link' => 'required|unique:websites,link'
        ];
        $this->session = $session;
    }

    /**
     * Index page
     *
     * @return Response
     */
    public function index()
    {
        $itemsPerPage = 10;
        $currentPage = $this->request->query->has('page') ? $this->request->query->get('page') : 1;
        $websites = Website::offset(($currentPage - 1) * $itemsPerPage)->limit($itemsPerPage);
        $urlPattern = '/websites?page=(:num)';

        // Filter
        if($this->request->query->has('name')){
            $name = $this->request->query->get('name');
            $totalItems = Website::where('name', 'like', '%' . $name . '%');
            $websites = $websites->where('name', 'like', '%' . $name . '%');
            $urlPattern = $urlPattern . '&name=' . $name;
        }

        if($this->request->query->has('link')){
            $link = $this->request->query->get('link');
            $totalItems = $totalItems->where('link', 'like', '%' . $link . '%');
            $websites = $websites->where('link', 'like', '%' . $link . '%');
            $urlPattern = $urlPattern . '&link=' . $link;
        }

        if(!isset($totalItems)){
            $totalItems = Website::count();
        }else{
            $totalItems = $totalItems->count();
        }
        $websites = $websites->orderBy('id', 'desc')->get();

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);

        return new Response($this->view->render('websites/index', ['request' => $this->request, 'websites' => $websites, 'paginator' => $paginator, 'itemsPerPage' => $itemsPerPage]));
    }

    /**
     * Add page
     *
     * @return Response
     */
    public function store()
    {
        // $faker = \Faker\Factory::create();
        // $this->request->request->set('name', $faker->name);
        // $this->request->request->set('link', $faker->domainName);
        // $this->request->request->set('xpath', $faker->name);
        return new Response($this->view->render('websites/store', ['request' => $this->request]));
    }

    /**
     * POST Add page
     */
    public function storePost()
    {
        if(is_csrf_token()){
            $params = $this->request->request->all();
            
            $validator = new Validator;
            $validator->addValidator('unique', new UniqueRule());

            // make it
            $validation = $validator->make($params, $this->rules);

            // then validate
            $validation->validate();

            if ($validation->fails()) {
                // handling errors
                $errors = $validation->errors();
                return new Response($this->view->render('websites/store', ['errors' => $errors, 'request' => $this->request]));
            } else {
                // validation passes
                $website = new Website();
                $website->name = $params['name'];
                $website->link = $params['link'];
                $website->xpath = $params['xpath'];
                $website->save();

                return new RedirectResponse(url('/websites'));
            }
        } else {
            return new RedirectResponse(lastUrl('/'));
        }
    }

    /**
     * Update page
     *
     * @return Response
     */
    public function update($id)
    {
        $website = Website::find($id)->first();
        return new Response($this->view->render('websites/update', ['website' => $website]));
    }

    /**
     * POST Update page
     */
    public function updatePost($id)
    {
        if(is_csrf_token()){
            $website = Website::find($id)->first();
            $params = $this->request->request->all();
            
            $validator = new Validator;
            $validator->addValidator('unique', new UniqueRule());

            $this->rules['link'] = 'required|unique:websites,link,' . $website->link;
            
            // make it
            $validation = $validator->make($params, $this->rules);

            // then validate
            $validation->validate();

            if ($validation->fails()) {
                // handling errors
                $errors = $validation->errors();
                return new Response($this->view->render('websites/update', ['errors' => $errors, 'website' => $website]));
            } else {
                // validation passes
                $website->name = $params['name'];
                $website->link = $params['link'];
                $website->xpath = $params['xpath'];
                $website->save();

                return new RedirectResponse($params['previous']);
            }
        } else {
            return new RedirectResponse(lastUrl('/'));
        }
    }

    /**
     * POST Delete
     */
    public function delete($id)
    {
        if(is_csrf_token()){
            $website = Website::find($id)->first();
            if($website->cookies()->count() > 0) {
                return new RedirectResponse(lastUrl('/'));        
            }
            $website = Website::destroy($id);
        }
        return new RedirectResponse(lastUrl('/'));
    }
}
