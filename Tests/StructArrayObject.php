<?php

namespace WsdlToPhp\PackageBase\Tests;

use WsdlToPhp\PackageBase\AbstractStructArrayBase;

class StructArrayObject extends AbstractStructArrayBase
{
    public $foo;
    public function setFoo(array $foo = array())
    {
        $this->foo = $foo;
        return $this;
    }
    public function getFoo()
    {
        return $this->foo;
    }
    public function getAttributeName()
    {
        return 'foo';
    }
}
