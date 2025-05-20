<?php
// public/index.php

// 1) Show all errors in dev
ini_set('display_errors', '1');
error_reporting(E_ALL);

// 2) Autoload all App\ classes
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;

// 3) Boot the router
$router = new Router();

// 4) Define just your MVC routes
$router->get('/', 'UrlController@landing');
// e.g. $router->post('/shorten', 'UrlController@shorten');

// 5) Dispatch the request
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
