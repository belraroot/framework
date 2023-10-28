<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Mapping;

/**
 * @Annotation
 * @Target("ANNOTATION")
 */
final class NamedQuery implements MappingAttribute
{
    /** @var string */
    public $name;

    /** @var string */
    public $query;
}
