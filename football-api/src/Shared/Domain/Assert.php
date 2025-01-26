<?php

namespace Src\Shared\Domain;

use InvalidArgumentException;

final class Assert
{
    public static function instanceOf($item, string $class): void
    {
        if (!$item instanceof $class) {
            throw new InvalidArgumentException(
                sprintf('The object <%s> is not an instance of <%s>', get_class($item), $class)
            );
        }
    }

    public static function childInstanceOf($item, string $parent): void
    {
        if (!is_subclass_of($item, $parent)) {
            throw new InvalidArgumentException(
                sprintf('The object <%s> is not a child instance of <%s>', get_class($item), $parent)
            );
        }
    }
}
