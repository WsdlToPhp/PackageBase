<?php

namespace WsdlToPhp\PackageBase;

interface StructInterface
{
    /**
     * Generic method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @uses ApiWsdlClass::_set()
     * @param array $array the exported values
     * @return Struct
     */
    public static function __set_state(array $array);
}
