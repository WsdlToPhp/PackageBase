<?php
/**
 * Created by PhpStorm.
 * User: mikael
 * Date: 17/01/19
 * Time: 00:20
 */

namespace WsdlToPhp\PackageBase\Tests;


class EnumTest extends TestCase
{
    /**
     *
     */
    public function test__toStringMustReturnTheClassNameOfTheInstance()
    {
        $this->assertSame('WsdlToPhp\PackageBase\Tests\EnumObject', (string) new EnumObject());
    }
    /**
     *
     */
    public function testValueIsValidMustReturnTrue()
    {
        $this->assertTrue(EnumObject::valueIsValid(1));
        $this->assertTrue(EnumObject::valueIsValid(EnumObject::ONE));
    }
    /**
     *
     */
    public function testValueIsValidMustReturnFalse()
    {
        $this->assertFalse(EnumObject::valueIsValid('1'));
        $this->assertFalse(EnumObject::valueIsValid((string) EnumObject::ONE));
    }
}