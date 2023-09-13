<?php

namespace Codecomodo\Support;

use Symfony\Component\Dotenv\Dotenv;
use function Codecomodo\parse_flare;

define('BASE_URL', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_SCHEME).'://'.parse_url($_SERVER['REQUEST_URI'], PHP_URL_HOST), '/'));

if (!function_exists('env')) {
    function env($var)
    {
        $dotenv = new Dotenv();

        $dotenv->parse($var);
    }
}

if (!function_exists('esc')) {
    function esc($string)
    {
        return \Symfony\Component\VarDumper\Dumper\esc($string);
    }
}

if (!function_exists('view')) {
    function view($template, $data = [])
    {
        global $data;

        return parse_flare($template);
    }
}