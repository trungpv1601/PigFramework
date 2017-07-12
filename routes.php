<?php

return [
    ['GET', '/', ['App\Controllers\IndexController', 'index']],
    ['GET', '/exception', ['App\Controllers\IndexController', 'exception']],
    ['GET', '/login', ['App\Controllers\IndexController', 'login']],
    ['GET', '/register', ['App\Controllers\IndexController', 'register']],
];
