<?php

namespace Calculus\Support;

interface CanBeEscapedWhenCastToString
{
    public function escapeWhenCastingToString($escape = true);
}