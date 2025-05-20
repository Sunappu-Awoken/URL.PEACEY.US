<?php
namespace App\Core;

class Router
{
    protected $routes = [];

    public function get($path, $handler)
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function dispatch($uri, $method)
    {
        $path = parse_url($uri, PHP_URL_PATH);
        if (!isset($this->routes[$method][$path])) {
            http_response_code(404);
            echo "Page not found";
            return;
        }

        list($controller, $action) = explode('@', $this->routes[$method][$path]);
        $controller = "App\\Controllers\\{$controller}";
        $obj = new $controller;
        call_user_func_array([$obj, $action], []);
    }
}