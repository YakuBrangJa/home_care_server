<?php

class Router
{
    protected static $routes = [];

    private static function addRoute($route, $controller, $action, $method)
    {
        // Convert dynamic route (e.g., /user/:id) into regex (e.g., /user/(\w+))
        $routePattern = preg_replace('/:\w+/', '([^/]+)', $route);
        self::$routes[$method][$routePattern] = [
            'controller' => $controller,
            'action' => $action,
            'params' => [] // To store parameter names
        ];

        // Extract parameter names (e.g., ":id" -> "id") and store them
        preg_match_all('/:(\w+)/', $route, $paramNames);
        self::$routes[$method][$routePattern]['params'] = $paramNames[1];
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

        foreach (self::$routes[$method] as $routePattern => $routeData) {
            if (preg_match("#^" . $routePattern . "$#", $uri, $matches)) {
                array_shift($matches); // Remove full match

                $controller = new $routeData['controller']();
                $action = $routeData['action'];

                // Pass extracted parameters to controller method
                call_user_func_array([$controller, $action], $matches);
                return;
            }
        }

        throw new \Exception("No route found for URI: $uri");
    }
}