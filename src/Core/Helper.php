<?php

const BASE_URL = $_ENV['APP_URL'];

function view($file, $data = [])
{
    $GLOBALS[$data];

    include_once BASE_URL . '/app/Views/' . $file . '.php';
}