<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Mapping;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class NamedQueries implements MappingAttribute
{
    /** @var array<\Calculus\Database\Fluent\Mapping\NamedQuery> */
    public $value;
}
