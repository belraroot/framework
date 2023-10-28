<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Mapping;

use Attribute;

/**
 * @Annotation
 * @Target("CLASS")
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class Embeddable implements MappingAttribute
{
}
