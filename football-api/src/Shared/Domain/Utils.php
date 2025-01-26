<?php

namespace Src\Shared\Domain;

final class Utils
{
    public static function omitKeys(array $inputArray, $keysToOmit): array
    {
        return array_diff_key($inputArray, array_flip($keysToOmit));
    }

    public static function toSnakeCase(string $text): string
    {
        return ctype_lower($text)
            ? $text
            : strtolower(preg_replace('/([^A-Z\s])([A-Z])/', "$1_$2", $text));
    }

    public static function hasTrait($objectOrClass, string $trait): bool
    {
        return in_array($trait, class_uses($objectOrClass));
    }
}
