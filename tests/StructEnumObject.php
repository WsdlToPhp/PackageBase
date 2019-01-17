<?php

namespace WsdlToPhp\PackageBase\Tests;

use WsdlToPhp\PackageBase\AbstractStructEnumBase;

class StructEnumObject extends AbstractStructEnumBase
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