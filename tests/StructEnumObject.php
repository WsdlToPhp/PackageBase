<?php

namespace WsdlToPhp\PackageBase\Tests;

use WsdlToPhp\PackageBase\AbstractStructStructEnumBase;

class StructEnumObject extends AbstractStructStructEnumBase
{
    const ONE = 1;
    const TWO = 2;
    const THREE = 3;
    public static function getValidValues()
    {
        return [
            self::ONE,
            self::TWO,
            self::THREE,
        ];
    }
}