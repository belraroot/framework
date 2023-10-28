<?php

namespace Calculus\Exception;

use RuntimeException;

class MultipleItemsFoundException extends RuntimeException
{

    public $count;


    public function __construct($count, $code = 0, $previous = null)
    {
        $this->count = $count;

        parent::__construct("$count items were found.", $code, $previous);
    }


    public function getCount()
    {
        return $this->count;
    }
}