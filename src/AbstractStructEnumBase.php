<?php

namespace WsdlToPhp\PackageBase;

abstract class AbstractStructEnumBase implements StructEnumInterface
{
    /**
     * Return true if value is allowed
     * @uses self::getValidValues()
     * @param mixed $value value
     * @return bool true|false
     */
    public static function valueIsValid($value)
    {
        return ($value === null) || in_array($value, static::getValidValues(), true);
    }
    /**
     * Default string representation of current object. Don't want to expose any sensible data
     * @return string
     */
    public function __toString()
    {
        return get_called_class();
    }
}
