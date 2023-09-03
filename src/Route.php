<?php

namespace Codecomodo;

class Route
{
    static function get($route, $path_to_include, $method_to_call)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            route($route, $path_to_include, $method_to_call);
        }
    }
    static function post($route, $path_to_include, $method_to_call)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            route($route, $path_to_include, $method_to_call);
        }
    }
    static function put($route, $path_to_include, $method_to_call)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            route($route, $path_to_include, $method_to_call);
        }
    }
    static function patch($route, $path_to_include, $method_to_call)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
            route($route, $path_to_include, $method_to_call);
        }
    }
    static function delete($route, $path_to_include, $method_to_call)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            route($route, $path_to_include, $method_to_call);
        }
    }
    static function any($route, $path_to_include, $method_to_call)
    {
        route($route, $path_to_include, $method_to_call);
    }
    static function out($text)
    {
        echo htmlspecialchars($text);
    }

    static function set_csrf()
    {
        session_start();
        if (!isset($_SESSION["csrf"])) {
            $_SESSION["csrf"] = bin2hex(random_bytes(50));
        }
        echo '<input type="hidden" name="csrf" value="' . $_SESSION["csrf"] . '">';
    }

    static function is_csrf_valid()
    {
        session_start();
        if (!isset($_SESSION['csrf']) || !isset($_POST['csrf'])) {
            return false;
        }
        if ($_SESSION['csrf'] != $_POST['csrf']) {
            return false;
        }
        return true;
    }
}