<?php

namespace Codecomodo\Core;

define('BASE_URL', env('APP_URL'));

class View
{
    static function render($template, $data = [])
    {
        $content = file_get_contents($template);

        foreach ($data as $key => $value) {
            $content = str_replace("{{ $key }}", $value, $content);
        }

        return $content;
    }
}