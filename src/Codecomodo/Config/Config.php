<?php

namespace Codecomodo\Config;

function config($name, $var = [])
{
    require BASE_URL . '/config/' . $name . '.php';
}