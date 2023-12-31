<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Exception;

final class MissingMappingDriverImplementation extends ORMException implements ManagerException
{
    public static function create(): self
    {
        return new self(
            "It's a requirement to specify a Metadata Driver and pass it " .
            'to Doctrine\\ORM\\Configuration::setMetadataDriverImpl().'
        );
    }
}
