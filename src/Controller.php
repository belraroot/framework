<?php

namespace Codecomodo;

use Core\View;

class Controller
{
    public function view($template, $data)
    {
        View::render($template, $data);
    }
}
