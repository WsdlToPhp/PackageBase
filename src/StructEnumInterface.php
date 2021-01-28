<?php

declare(strict_types=1);

namespace WsdlToPhp\PackageBase;

interface StructEnumInterface
{
    /**
     * Return true if value is allowed
     * @param mixed $value value
     * @return bool true|false
     */
    public static function valueIsValid($value): bool;

    /**
     * Return allowed values
     * @return string[]
     */
    public static function getValidValues(): array;
}
