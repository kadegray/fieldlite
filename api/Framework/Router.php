<?php

namespace Framework;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Router
{
    public static $routes = [];
    protected static $request;

    public static function route()
    {
        self::$request = new Request();

        $firstSegment = explode('/', self::$request->requestUri);
        array_shift($firstSegment);
        array_shift($firstSegment);
        $firstSegment = array_first($firstSegment);

        if (!$firstSegment) {
            new Response(null, 404);
        }

        if (Str::plural($firstSegment) === $firstSegment) {
            self::processIndexRoute($firstSegment);
        }

        if (Str::singular($firstSegment) === $firstSegment) {
            foreach (self::$routes as $route) {
                self::processRoute($firstSegment, $route);
            }
        }

        new Response(null, 404);
    }

    protected static function processRoute($firstSegment, $route)
    {
        list(
            $requestMethod,
            $resourceName,
            $controller,
            $controllerMethod
        ) = $route;

        if ($requestMethod != self::$request->method) {
            return;
        }

        if ($resourceName !== $firstSegment) {
            return;
        }

        if (!class_exists($controller)) {
            return;
        }

        $controller = new $controller;
        if (!$controller) {
            return;
        }

        if (!method_exists($controller, $controllerMethod)) {
            return;
        }

        $requestClass = Request::getRequestClassByModel($resourceName);
        $responseData = $controller->$controllerMethod(
            (new $requestClass),
            ...self::$request->modelsBasedOnRestUri
        );

        new Response($responseData);
    }

    protected static function processIndexRoute($firstSegment)
    {
        if (self::$request->method !== 'get') {
            return;
        }

        $foundRoute = Arr::where(self::$routes, function ($route, $key) use ($firstSegment) {
            list(
                $requestMethod,
                $resourceName,
                $controller,
                $controllerMethod
            ) = $route;

            return $requestMethod === 'get'
                && $controllerMethod === 'index'
                && $resourceName === $firstSegment;
        });

        if (!count($foundRoute)) {
            return;
        }

        $foundRoute = array_first($foundRoute);

        self::processRoute($firstSegment, $foundRoute);
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

        self::$routes[] = [$requestMethod, $resourceName, $controller, $controllerMethod];
    }

    public static function method()
    {
        return;
    }

    public static function resource($resourceName, $controller)
    {
        foreach ([
            'get' => 'show',
            'post' => 'create',
            'put' => 'update',
            'delete' => 'delete'
        ] as $requestMethod => $controllerMethod) {
            self::$requestMethod($resourceName, $controller, $controllerMethod);
        }

        $plural = Str::plural($resourceName);

        self::get($plural, $controller, 'index');
    }
}
