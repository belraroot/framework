<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Repository\Exception;

use Calculus\Database\Fluent\Exception\ORMException;
use Calculus\Database\Fluent\Exception\RepositoryException;

final class InvalidFindByCall extends ORMException implements RepositoryException
{
    public static function fromInverseSideUsage(
        string $entityName,
        string $associationFieldName
    ): self {
        return new self(
            "You cannot search for the association field '" . $entityName . '#' . $associationFieldName . "', " .
            'because it is the inverse side of an association. Find methods only work on owning side associations.'
        );
    }
}
