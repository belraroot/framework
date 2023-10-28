<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Exception;

use function sprintf;

/** @deprecated No replacement planned. */
final class UnknownEntityNamespace extends ORMException implements ConfigurationException
{
    public static function fromNamespaceAlias(string $entityNamespaceAlias): self
    {
        return new self(sprintf(
            'Unknown Entity namespace alias "%s"',
            $entityNamespaceAlias
        ));
    }
}
