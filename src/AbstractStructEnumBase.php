<?php

declare(strict_types=1);

namespace WsdlToPhp\PackageBase;

abstract class AbstractStructEnumBase implements StructEnumInterface
{
    /**
     * Return true if value is allowed
     * @param mixed $value value
     * @return bool true|false
     */
    public static function valueIsValid($value): bool
    {
        return ($value === null) || in_array($value, static::getValidValues(), true);
    }

    /**
     * Default string representation of current object. Don't want to expose any sensible data
     * @return string
     */
    public function __toString(): string
    {
        return get_called_class();
    }
}
