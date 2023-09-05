<?php

namespace Codecomodo\Core;

function env($var)
{
    parse_ini_file('.env')[$var];
}