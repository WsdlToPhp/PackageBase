<?php

declare(strict_types=1);

namespace WsdlToPhp\PackageBase\Tests;

use WsdlToPhp\PackageBase\AbstractStructArrayBase;

class StructArrayObject extends AbstractStructArrayBase
{
    public $foo;

    public function setFoo(array $foo = []): self
    {
        $this->foo = $foo;

        return $this;
    }

    public function getFoo()
    {
        return $this->foo;
    }

    public function getAttributeName(): string
    {
        return 'foo';
    }
}
