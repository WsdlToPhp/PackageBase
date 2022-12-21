<?php

declare(strict_types=1);

namespace WsdlToPhp\PackageBase\Tests;

class StructArrayTest extends TestCase
{
    public function testSetState(): void
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

    public function testGetAttributeName(): void
    {
        $object = new StructArrayObject();

        $this->assertSame('foo', $object->getAttributeName());
    }

    public function testLength(): void
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

    public function testAdd(): void
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

    public function testAddOnEmpty(): void
    {
        $object = new StructArrayObject();
        $object
            ->add(4)
            ->add(5)
            ->add(6);

        $this->assertSame(4, $object->current());
    }

    public function testFirst(): void
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

    public function testLast(): void
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

    public function testOffsetExists(): void
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

    public function testOffsetNotExists(): void
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

    public function testOffsetGet(): void
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

    public function testOffsetGetNull(): void
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

    public function testOffsetSet(): void
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

    public function testOffsetUnset(): void
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

    public function testIteratorMethods(): void
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

    public function test__toStringMustReturnTheClassNameOfTheInstance(): void
    {
        $this->assertSame(StructArrayObject::class, (string) new StructArrayObject());
    }
}
