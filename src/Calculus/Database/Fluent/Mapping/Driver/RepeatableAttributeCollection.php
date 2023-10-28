<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Mapping\Driver;

use ArrayObject;
use Calculus\Database\Fluent\Mapping\Annotation;

/**
 * @template-extends ArrayObject<int, T>
 * @template T of Annotation
 */
final class RepeatableAttributeCollection extends ArrayObject
{
}
