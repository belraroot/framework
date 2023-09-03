<?php

function env($var)
{
    parse_ini_file('.env')[$var];
}