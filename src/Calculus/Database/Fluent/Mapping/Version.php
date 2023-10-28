<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Mapping;

use Attribute;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class Version implements MappingAttribute
{
}
