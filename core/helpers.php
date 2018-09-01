<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

const AUTH= 'AUTH';
const AUTH_ADMIN= 'AUTH_ADMIN';

function url($url)
{
    return getenv('APP_URL') . $url;
}

function isActiveMenu($urlArray)
{
    foreach ($urlArray as $url) {
        if ($url !== '/' && strpos(strtok($_SERVER['REQUEST_URI'], '?'), $url) !== false) {
            return true;
        }

        if (strtok($_SERVER['REQUEST_URI'], '?') === $url) {
            return true;
        }
    }
    return false;
}

function hasErrors($errors, $key)
{
    return $errors != null && $errors->has($key);
}

function lastUrl($defaultUrl)
{
    $request = Request::createFromGlobals();
    if ($request->request->has('previous')) {
        return $request->request->get('previous');
    }
    return $request->headers->get('referer') ? $request->headers->get('referer') : url($defaultUrl);
}

function request()
{
    return Request::createFromGlobals();
}

/**
 * CSRF
 */
function csrf_token()
{
    $session = new Session();
    if(!$session->has('csrf_token')){
        $session->set('csrf_token', md5(openssl_random_pseudo_bytes(32)));
    }
    return $session->get('csrf_token');
}

function is_csrf_token()
{
    $session = new Session();
    $request = Request::createFromGlobals();
    if($request->request->get('csrf_token') === $session->get('csrf_token')){
        $session->remove('csrf_token');
        return TRUE;
    }else{
        return FALSE;
    }
}
/**
 * ./ CSRF
 */

function auth()
{
    $session = new Session();
    if($session->has('user')){
        return $session->get('user');
    }
    return false;
}

function is_admin()
{
    $session = new Session();
    if($session->has('user') && $session->get('user')->is_admin){
        return true;
    }
    return false;
}