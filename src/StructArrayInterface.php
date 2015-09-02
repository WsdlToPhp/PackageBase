<?php

namespace WsdlToPhp\PackageBase;

interface StructArrayInterface extends StructInterface, \ArrayAccess, \Iterator, \Countable
{
    /**
     * Method returning alone attribute name when class is *array* type
     * This method has been overridden in real-array struct class
     * @return string
     */
    public function getAttributeName();
}
