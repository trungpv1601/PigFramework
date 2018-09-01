<?php

return [
    ['GET', '/', ['App\Controllers\IndexController', 'index', AUTH]],
    ['GET', '/exception', ['App\Controllers\IndexController', 'exception']],

    ['GET', '/login', ['App\Controllers\AuthController', 'login']],
    ['POST', '/login', ['App\Controllers\AuthController', 'loginPOST']],
    ['POST', '/logout', ['App\Controllers\AuthController', 'logout']],
    ['GET', '/register', ['App\Controllers\AuthController', 'register']],

    //User
    ['GET', '/users', ['App\Controllers\UserController', 'index', AUTH, AUTH_ADMIN]],
    ['GET', '/users/store', ['App\Controllers\UserController', 'store', AUTH, AUTH_ADMIN]],
    ['POST', '/users/store', ['App\Controllers\UserController', 'storePost', AUTH, AUTH_ADMIN]],
    ['GET', '/users/{id:\d+}', ['App\Controllers\UserController', 'update', AUTH, AUTH_ADMIN]],
    ['POST', '/users/{id:\d+}', ['App\Controllers\UserController', 'updatePost', AUTH, AUTH_ADMIN]],
    ['POST', '/users/{id:\d+}/delete', ['App\Controllers\UserController', 'delete', AUTH, AUTH_ADMIN]],

    // Website
    ['GET', '/websites', ['App\Controllers\WebsiteController', 'index', AUTH]],
    ['GET', '/websites/store', ['App\Controllers\WebsiteController', 'store', AUTH]],
    ['POST', '/websites/store', ['App\Controllers\WebsiteController', 'storePost', AUTH]],
    ['GET', '/websites/{id:\d+}', ['App\Controllers\WebsiteController', 'update', AUTH]],
    ['POST', '/websites/{id:\d+}', ['App\Controllers\WebsiteController', 'updatePost', AUTH]],
    ['POST', '/websites/{id:\d+}/delete', ['App\Controllers\WebsiteController', 'delete', AUTH]],
];
