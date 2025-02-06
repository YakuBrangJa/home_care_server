<?php

class Router
{
    protected static $routes = [];

    private static function addRoute($route, $controller, $action, $method)
    {
        self::$routes[$method][$route] = ['controller' => $controller, 'action' => $action];
    }

    public static function get($route, $controller, $action)
    {
        self::addRoute($route, $controller, $action, "GET");
    }

    public static function post($route, $controller, $action)
    {
        self::addRoute($route, $controller, $action, "POST");
    }

    

    public static function dispatch()
    {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $method = $_SERVER['REQUEST_METHOD'];

        // Check if the route exists for the current method
        if (array_key_exists($uri, self::$routes[$method])) {
            $controller = self::$routes[$method][$uri]['controller'];
            $action = self::$routes[$method][$uri]['action'];

            $controller = new $controller();
            $controller->$action();
        } else {
            throw new \Exception("No route found for URI: $uri");
        }
    }
}