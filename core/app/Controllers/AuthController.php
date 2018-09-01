<?php
namespace App\Controllers;

use Symfony\Component\HttpFoundation\Session\Session;
use League\Plates\Engine;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Rakit\Validation\Validator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Models\User;


class AuthController extends Controller
{
    private $view;
    private $request;
    private $rule = [];
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
        $this->rules = [
            'username' => 'required',
            'password' => 'required'
        ];
        $this->session = $session;
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
     * POST Login Page
     */
    public function loginPOST()
    {
        if(is_csrf_token()){
            $params = $this->request->request->all();
            
            $validator = new Validator();

            // make it
            $validation = $validator->make($params, $this->rules);

            // then validate
            $validation->validate();

            if ($validation->fails()) {
                // handling errors
                $errors = $validation->errors();
                return new Response($this->view->render('login', ['errors' => $errors, 'request' => $this->request]));
            } else {
                // validation passes
                $user = $this->validAuth($params['username'], $params['password']);
                if(!$user){
                    $username = 'Wrong username & password.';
                    return new Response($this->view->render('login', ['username' => $username, 'request' => $this->request]));
                }

                $this->session->set('user', $user);
                return new RedirectResponse(url('/'));
            }
        } else {
            return new RedirectResponse(lastUrl('/'));
        }
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

    public function logout()
    {
        if(is_csrf_token()){
            $this->session->remove('user');
            return new RedirectResponse(url('/login'));
        }else{
            return new RedirectResponse(url('/'));
        }
    }

    private function validAuth($username, $password)
    {
        $user = User::where('username', $username)->where('password', md5($password))->first();
        if($user){
            return $user;
        }
        return false;
    }
}