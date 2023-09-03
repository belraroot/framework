<?php

const BASE_URL = env('APP_URL');

function view($file, $data = [])
{
    $GLOBALS[$data];

    include_once BASE_URL . '/app/Views/' . $file . '.php';
}