<?php

namespace Calculus\Routing;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Router
{
    private static RouteCollection $routes;
    public $routeName;

    public function name(string $name)
    {
        $this->routeName = $name;
    }

    public static function get(string $path, string $controller, string $method)
    {
        $route = new Route($path, [
            '_controller' => $controller . '::' . $method,
        ]);
        $route_name = str_replace(['/', '{', '}', '.', '::'], ['', '', '', '_'], $path);
        self::$routes->add($route_name, $route);

        $router = new self();
        $router->name($route_name);

        return $router;
    }

    public static function post(string $path, string $controller, string $method)
    {
        $route = new Route($path, [
            '_controller' => $controller . '::' . $method,
        ], [], [], '', [], ['POST']);
        $route_name = str_replace(['/', '{', '}', '.', '::'], ['', '', '', '_'], $path);
        self::$routes->add($route_name, $route);

        $router = new self();
        $router->name($route_name);

        return $router;
    }

    public static function put(string $path, string $controller, string $method)
    {
        $route = new Route($path, [
            '_controller' => $controller . '::' . $method,
        ], [], [], '', [], ['PUT']);
        $route_name = str_replace(['/', '{', '}', '.', '::'], ['', '', '', '_'], $path);
        self::$routes->add($route_name, $route);

        $router = new self();
        $router->name($route_name);

        return $router;
    }

    public static function delete(string $path, string $controller, string $method)
    {
        $route = new Route($path, [
            '_controller' => $controller . '::' . $method,
        ], [], [], '', [], ['DELETE']);
        $route_name = str_replace(['/', '{', '}', '.', '::'], ['', '', '', '_'], $path);
        self::$routes->add($route_name, $route);

        $router = new self();
        $router->name($route_name);

        return $router;
    }

    public static function dispatch(string $path, string $controller, string $method)
    {
        $route = new Route($path, [
            '_controller' => $controller . '::' . $method,
        ]);
        $route_name = str_replace(['/', '{', '}', '.', '::'], ['', '', '', '_'], $path);
        self::$routes->add($route_name, $route);

        $router = new self();
        $router->name($route_name);

        return $router;
    }
}