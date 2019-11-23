<?php

namespace Framework;

use Response;

class Router
{
    public static $routes = [];
    protected static $request;

    public static function route()
    {
        self::$request = new Request();

        foreach(self::$routes as $route) {

            list(
                $requestMethod,
                $controller,
                $controllerMethod
            ) = $route;

            if ($requestMethod != self::$request->method) {
                continue;
            }

            if (!class_exists($controller)) {
                continue;
            }

            $controller = new $controller;
            if (!$controller) {
                continue;
            }

            if (!method_exists($controller, $controllerMethod)) {
                continue;
            }

            $responseData = $controller->$controllerMethod(
                self::$request,
                ...array_values(self::$request->modelsBasedOnRestUri)
            );

            new Response($responseData);
        }
    }

    public static function __callStatic(
        string $requestMethod,
        array $arguments
    ) {
        if (!in_array($requestMethod, [
            'get',
            'post',
            'put',
            'delete'
        ])) {
            return;
        }

        list($resourceName, $controller, $controllerMethod) = $arguments;

        self::$routes[] = [$requestMethod, $controller, $controllerMethod];
    }

    public static function method()
    {
        return ;
    }

    public static function resource($resourceName, $controller)
    {
        foreach([
            'get' => 'index',
            'post' => 'create',
            'put' => 'update',
            'delete' => 'delete'
        ] as $requestMethod => $controllerMethod) {
            self::$requestMethod($resourceName, $controller, $controllerMethod);
        }
    }

}
