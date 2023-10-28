<?php

namespace Calculus\Support\Traits;

trait Tappable
{
    public function tap($callback = null)
    {
        return tap($this, $callback);
    }
}