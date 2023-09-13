<?php

namespace Codecomodo;

class View
{
    public static function render($template, $data = [])
    {
        global $data;

        return parse_flare($template);
    }
}