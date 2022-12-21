<?php

declare(strict_types=1);

namespace WsdlToPhp\PackageBase\Tests;

class StructEnumTest extends TestCase
{
    public function test__toStringMustReturnTheClassNameOfTheInstance(): void
    {
        $this->assertSame(StructEnumObject::class, (string) new StructEnumObject());
    }

    public function testValueIsValidMustReturnTrue(): void
    {
        $this->assertTrue(StructEnumObject::valueIsValid(1));
        $this->assertTrue(StructEnumObject::valueIsValid(StructEnumObject::ONE));
    }

    public function testValueIsValidMustReturnFalse(): void
    {
        $this->assertFalse(StructEnumObject::valueIsValid('1'));
        $this->assertFalse(StructEnumObject::valueIsValid((string) StructEnumObject::ONE));
    }
}
