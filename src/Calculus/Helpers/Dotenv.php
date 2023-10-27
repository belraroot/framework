<?php

namespace Calculus\Helpers;

class Dotenv
{
    public function env($key)
    {
        return $_ENV[$key];
    }
}