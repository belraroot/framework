<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Tools\Console;

use Calculus\Database\Fluent\EntityManagerInterface;

interface EntityManagerProvider
{
    public function getDefaultManager(): EntityManagerInterface;

    public function getManager(string $name): EntityManagerInterface;
}
