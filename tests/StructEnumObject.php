<?php

declare(strict_types=1);

namespace WsdlToPhp\PackageBase\Tests;

use WsdlToPhp\PackageBase\AbstractStructEnumBase;

class StructEnumObject extends AbstractStructEnumBase
{
    const ONE = 1;
    const TWO = 2;
    const THREE = 3;

    public static function getValidValues(): array
    {
        return [
            self::ONE,
            self::TWO,
            self::THREE,
        ];
    }
}
