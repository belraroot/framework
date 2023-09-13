<?php

namespace Codecomodo\Routing;

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Route
{
    protected $route_name;

    protected RoutingConfigurator $route;

    public function get($path, $controller = [])
    {   
        $this->route->add($this->route_name, $path)
        ->controller($controller)
        ->methods(['GET']);

        return $this;
    }

    public function post($path, $controller = [])
    {
        $this->route->add($this->route_name, $path)
        ->controller($controller)
        ->methods(['POST']);

        return $this;
    }

    public function put($path, $controller = [])
    {
        $this->route->add($this->route_name, $path)
        ->controller($controller)
        ->methods(['PUT']);

        return $this;
    }

    public function delete($path, $controller = [])
    {
        $this->route->add($this->route_name, $path)
        ->controller($controller)
        ->methods(['DELETE']);

        return $this;
    }

    public function name($name)
    {
        $this->route_name = $name;
    }
}