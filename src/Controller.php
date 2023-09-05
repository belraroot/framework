<?php

namespace Codecomodo;

use Codecomodo\Core\View;

class Controller
{
    public function view($template, $data)
    {
        View::render($template, $data);
    }
}
