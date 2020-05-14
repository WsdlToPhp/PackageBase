<?php

namespace WsdlToPhp\PackageBase;

interface StructEnumInterface
{
    /**
     * Return true if value is allowed
     * @uses self::getValidValues()
     * @param mixed $value value
     * @return bool true|false
     */
    public static function valueIsValid($value);
    /**
     * Return allowed values
     * @return string[]
     */
    public static function getValidValues();
}
