<?php

declare(strict_types=1);

namespace WsdlToPhp\PackageBase\Tests;

use InvalidArgumentException;

class StructBaseTest extends TestCase
{
    public function testSetState()
    {
        $object = new StructObject();
        $object
            ->setBar('foo')
            ->setFoo('bar');

        $this->assertEquals($object, StructObject::__set_state([
            'bar' => 'foo',
            'foo' => 'bar',
        ]));
    }

    public function testSetStateException()
    {
        $this->expectException(InvalidArgumentException::class);

        StructObject::__set_state([
            'bar' => 'foo',
            'foo' => 'bar',
            'sample' => 'data',
        ]);
    }

    public function testSetGet()
    {
        $object = new StructObject();
        $object
            ->setBar('foo')
            ->setFoo('bar');
        $this->assertSame('foo', $object->getPropertyValue('bar'));
    }

    public function testSetGetWithException()
    {
        $this->expectException(InvalidArgumentException::class);

        $object = new StructObject();
        $object
            ->setBar('foo')
            ->setFoo('bar');
        $object->getPropertyValue('sample');
    }

    public function testJsonSerialize()
    {
        $object = new StructObject();
        $object
            ->setBar('foo')
            ->setFoo('bar');
        $this->assertSame([
            'foo' => 'bar',
            'bar' => 'foo',
        ], $object->jsonSerialize());
    }

    public function test__toStringMustReturnTheClassNameOfTheInstance()
    {
        $this->assertSame(StructObject::class, (string) new StructObject());
    }
}
