<?php

namespace Codecomodo\Core;

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class Route
{
    protected $route_name;

    function name($name)
    {
        $this->route_name = $name;
    }

    static function get($path, $controller)
    {
        $router = new RouteCollection();

        $router->add($this->route_name, new Route($path, array(
            '_controller' => $controller,
        ), array(), array(), '', array(), array('GET')));
    }

    static function post($path, $controller)
    {
        $router = new RouteCollection();

        $router->add($this->route_name, new Route($path, array(
            '_controller' => $controller,
        ), array(), array(), '', array(), array('POST')));
    }

    static function put($path, $controller)
    {
        $router = new RouteCollection();

        $router->add($this->route_name, new Route($path, array(
            '_controller' => $controller,
        ), array(), array(), '', array(), array('PUT')));
    }

    static function delete($path, $controller)
    {
        $router = new RouteCollection();

        $router->add($this->route_name, new Route($path, array(
            '_controller' => $controller,
        ), array(), array(), '', array(), array('DELETE')));
    }
}