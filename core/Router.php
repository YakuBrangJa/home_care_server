<?php

class Router
{
    protected static $routes = [];
    protected static $prefix = ''; // Stores current group prefix

    private static function addRoute($route, $controller, $action, $method)
    {
        // Apply prefix if set
        $route = self::$prefix . '/' . trim($route, '/');

        // Convert dynamic route (e.g., /user/:id) into regex (e.g., /user/([^/]+))
        $routePattern = preg_replace('/:\w+/', '([^/]+)', $route);
        self::$routes[$method][$routePattern] = [
            'controller' => $controller,
            'action' => $action,
            'params' => []
        ];

        // Extract parameter names (e.g., ":id" -> "id")
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

    public static function group($prefix, $callback)
    {
        // Store previous prefix and update it
        $previousPrefix = self::$prefix;
        self::$prefix = rtrim($previousPrefix . '/' . trim($prefix, '/'), '/');

        // Execute the callback function to add routes
        $callback();

        // Restore previous prefix after execution
        self::$prefix = $previousPrefix;
    }

    public static function dispatch()
    {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $method = $_SERVER['REQUEST_METHOD'];

        if (!isset(self::$routes[$method])) {
            http_response_code(405); // Method Not Allowed
            echo json_encode([
                'status' => false,
                'message' => 'Method not allowed'
            ]);
            return;
        }

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

        // If no route is matched, return 404 response
        http_response_code(404);
        echo json_encode([
            'status' => false,
            'message' => 'Route not found'
        ]);
    }

    // public static function dispatch()
    // {
    //     $uri = strtok($_SERVER['REQUEST_URI'], '?');
    //     $method = $_SERVER['REQUEST_METHOD'];

    //     foreach (self::$routes[$method] as $routePattern => $routeData) {
    //         if (preg_match("#^" . $routePattern . "$#", $uri, $matches)) {
    //             array_shift($matches); // Remove full match

    //             $controller = new $routeData['controller']();
    //             $action = $routeData['action'];

    //             // Pass extracted parameters to controller method
    //             call_user_func_array([$controller, $action], $matches);
    //             return;
    //         }
    //     }

    //     throw new \Exception("No route found for URI: $uri");
    // }
}