<?php

declare(strict_types=1);

namespace WsdlToPhp\PackageBase;

use ArrayAccess;
use Countable;
use Iterator;

interface StructArrayInterface extends StructInterface, ArrayAccess, Iterator, Countable
{
    /**
     * Method returning alone attribute name when class is *array* type
     * This method has been overridden in real-array struct class
     * @return string
     */
    public function getAttributeName(): string;
}
