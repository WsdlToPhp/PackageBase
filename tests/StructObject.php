<?php

namespace WsdlToPhp\PackageBase\Tests;

use WsdlToPhp\PackageBase\AbstractStructBase;

class StructObject extends AbstractStructBase
{
    public $foo;
    public $bar;
    public function setFoo($foo)
    {
        $this->foo = $foo;
        return $this;
    }
    public function getFoo()
    {
        return $this->foo;
    }
    public function setBar($bar)
    {
        $this->bar = $bar;
        return $this;
    }
    public function getBar()
    {
        return $this->bar;
    }
}
