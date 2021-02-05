<?php

declare(strict_types=1);

namespace WsdlToPhp\PackageBase\Tests;

class StructArrayTest extends TestCase
{
    public function testSetState()
    {
        $object = new StructArrayObject();
        $object
            ->setFoo([
                '1',
                2,
                '3',
            ]);

        $this->assertEquals($object, StructArrayObject::__set_state([
            'foo' => [
                '1',
                2,
                '3',
            ],
        ]));
    }

    public function testGetAttributeName()
    {
        $object = new StructArrayObject();

        $this->assertSame('foo', $object->getAttributeName());
    }

    public function testLength()
    {
        $object = new StructArrayObject();
        $object
            ->setFoo([
                '1',
                2,
                '3',
            ]);

        $this->assertSame(3, $object->length());
    }

    public function testAdd()
    {
        $object = new StructArrayObject();
        $object
            ->setFoo([
                '1',
                2,
                '3',
            ])
            ->add(4);

        $this->assertSame('1', $object->current());
    }

    public function testAddOnEmpty()
    {
        $object = new StructArrayObject();
        $object
            ->add(4)
            ->add(5)
            ->add(6);

        $this->assertSame(4, $object->current());
    }

    public function testFirst()
    {
        $object = new StructArrayObject();
        $object
            ->setFoo([
                '1',
                2,
                '3',
            ])
            ->add(4);

        $this->assertSame('1', $object->first());
    }

    public function testLast()
    {
        $object = new StructArrayObject();
        $object
            ->setFoo([
                '1',
                2,
                '3',
            ])
            ->add(4);

        $this->assertSame(4, $object->last());
    }

    public function testOffsetExists()
    {
        $object = new StructArrayObject();
        $object
            ->setFoo([
                '1',
                2,
                '3',
            ])
            ->add(4);

        $this->assertTrue($object->offsetExists(3));
    }

    public function testOffsetNotExists()
    {
        $object = new StructArrayObject();
        $object
            ->setFoo([
                '1',
                2,
                '3',
            ])
            ->add(4);

        $this->assertFalse($object->offsetExists(4));
    }

    public function testOffsetGet()
    {
        $object = new StructArrayObject();
        $object
            ->setFoo([
                '1',
                2,
                '3',
            ])
            ->add(4);

        $this->assertSame(4, $object->offsetGet(3));
    }

    public function testOffsetGetNull()
    {
        $object = new StructArrayObject();
        $object
            ->setFoo([
                '1',
                2,
                '3',
            ])
            ->add(4);

        $this->assertNull($object->offsetGet(4));
    }

    public function testOffsetSet()
    {
        $object = new StructArrayObject();
        $object
            ->setFoo([
                '1',
                2,
                '3',
            ])
            ->offsetSet(2, 4);

        $this->assertSame(4, $object->offsetGet(2));
    }

    public function testOffsetUnset()
    {
        $object = new StructArrayObject();
        $object
            ->setFoo([
                '1',
                2,
                '3',
            ])
            ->offsetUnset(2);

        $this->assertFalse($object->offsetExists(2));
    }

    public function testIteratorMethods()
    {
        $object = new StructArrayObject();
        $object
            ->setFoo($items = [
                '1',
                2,
                '3',
            ])
            ->offsetUnset(2);

        foreach ($object as $index => $item) {
            $this->assertSame($items[$index], $item);
        }
    }

    public function test__toStringMustReturnTheClassNameOfTheInstance()
    {
        $this->assertSame(StructArrayObject::class, (string) new StructArrayObject());
    }
}
