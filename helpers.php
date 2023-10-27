<?php

function env($key)
{
    $class = new Calculus\Helpers\Dotenv();
    return $class->env($key);
}