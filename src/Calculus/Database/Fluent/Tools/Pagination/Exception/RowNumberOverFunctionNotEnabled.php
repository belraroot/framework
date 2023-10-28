<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Tools\Pagination\Exception;

use Calculus\Database\Fluent\Exception\ORMException;

final class RowNumberOverFunctionNotEnabled extends ORMException
{
    public static function create(): self
    {
        return new self('The RowNumberOverFunction is not intended for, nor is it enabled for use in DQL.');
    }
}
