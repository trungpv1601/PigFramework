<?php

return [
    ['GET', '/', ['App\Controllers\IndexController', 'index']],
    ['GET', '/exception', ['App\Controllers\IndexController', 'exception']],
    ['GET', '/greet/{name}', ['App\Controllers\GreetController', 'greet']],
];
