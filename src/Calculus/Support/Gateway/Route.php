<?php

namespace Calculus\Support\Gateway;

use Calculus\Routing\Router;

class Route extends Router
{
    public static function get(string $path, string $controller, string $method)
    {
        return parent::get($path, $controller, $method); // TODO: Change the autogenerated stub
    }

    public static function post(string $path, string $controller, string $method)
    {
        return parent::post($path, $controller, $method); // TODO: Change the autogenerated stub
    }

    public static function put(string $path, string $controller, string $method)
    {
        return parent::put($path, $controller, $method); // TODO: Change the autogenerated stub
    }

    public static function delete(string $path, string $controller, string $method)
    {
        return parent::delete($path, $controller, $method); // TODO: Change the autogenerated stub
    }

    public static function dispatch(string $path, string $controller, string $method)
    {
        return parent::dispatch($path, $controller, $method); // TODO: Change the autogenerated stub
    }
}