<?php
namespace App\Controllers;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use League\Plates\Engine;
use App\Models\User;
use Symfony\Component\HttpFoundation\Request;
use Rakit\Validation\Validator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Validation\UniqueRule;
use JasonGrimes\Paginator;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Handles all requests to /users
 *
 */
class UserController extends Controller
{
    private $view;
    private $request;
    private $rules = [];
    private $session;

    /**
     * UserController, constructed by the container
     *
     * @param Engine $view
     */
    public function __construct(Engine $view, Session $session)
    {
        $this->view = $view;
        $this->request = Request::createFromGlobals();
        $this->rules = [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required'
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
        $users = User::offset(($currentPage - 1) * $itemsPerPage)->limit($itemsPerPage);
        $urlPattern = '/users?page=(:num)';

        // Filter
        if($this->request->query->has('name')){
            $name = $this->request->query->get('name');
            $totalItems = User::where('name', 'like', '%' . $name . '%');
            $users = $users->where('name', 'like', '%' . $name . '%');
            $urlPattern = $urlPattern . '&name=' . $name;
        }

        if($this->request->query->has('username')){
            $username = $this->request->query->get('username');
            $totalItems = $totalItems->where('username', 'like', '%' . $username . '%');
            $users = $users->where('username', 'like', '%' . $username . '%');
            $urlPattern = $urlPattern . '&username=' . $username;
        }

        if($this->request->query->has('is_admin') && $this->request->query->get('is_admin') != -1){
            $is_admin = $this->request->query->get('is_admin');
            $totalItems = $totalItems->where('is_admin', $is_admin);
            $users = $users->where('is_admin', $is_admin);
            $urlPattern = $urlPattern . '&is_admin=' . $is_admin;
        }

        if(!isset($totalItems)){
            $totalItems = User::count();
        }else{
            $totalItems = $totalItems->count();
        }
        $users = $users->orderBy('id', 'desc')->get();

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);

        return new Response($this->view->render('users/index', ['request' => $this->request, 'users' => $users, 'paginator' => $paginator, 'itemsPerPage' => $itemsPerPage]));
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
        // $this->request->request->set('username', $faker->username);
        // $this->request->request->set('password', $faker->password);
        return new Response($this->view->render('users/store', ['request' => $this->request]));
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
                return new Response($this->view->render('users/store', ['errors' => $errors, 'request' => $this->request]));
            } else {
                // validation passes
                $user = new User();
                $user->name = $params['name'];
                $user->username = $params['username'];
                $user->password = md5($params['password']);
                $user->is_admin = $this->request->request->has('is_admin') ? true : false;
                $user->save();

                return new RedirectResponse(url('/users'));
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
        $user = User::find($id)->first();
        return new Response($this->view->render('users/update', ['user' => $user]));
    }

    /**
     * POST Update page
     */
    public function updatePost($id)
    {
        if(is_csrf_token()){
            $user = User::find($id)->first();
            $params = $this->request->request->all();
            
            $validator = new Validator;
            $validator->addValidator('unique', new UniqueRule());

            $this->rules['username'] = 'required|unique:users,username,' . $user->username;
            $this->rules['old_password'] = 'required';
            $this->rules['password'] = '';
            
            // make it
            $validation = $validator->make($params, $this->rules);

            // then validate
            $validation->validate();

            if ($validation->fails()) {
                // handling errors
                $errors = $validation->errors();
                return new Response($this->view->render('users/update', ['errors' => $errors, 'user' => $user]));
            } else {
                // validation passes
                if($user->password === md5($params['old_password'])){
                    $user->name = $params['name'];
                    $user->username = $params['username'];
                    $user->password = md5($params['password']);
                    $user->is_admin = $this->request->request->has('is_admin') ? true : false;
                    $user->save();

                    return new RedirectResponse($params['previous']);
                }
                $old_password = 'Please enter correct old password.';

                return new Response($this->view->render('users/update', ['old_password' => $old_password, 'user' => $user]));
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
            $user = User::destroy($id);
        }
        return new RedirectResponse(lastUrl('/'));
    }
}
