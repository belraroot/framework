<?php

namespace Core;

function env($var)
{
    parse_ini_file('.env')[$var];
}