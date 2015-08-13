<?php

namespace WsdlToPhp\PackageBase\Tests;

class StructArrayTest extends TestCase
{
    /**
     *
     */
    public function testSetState()
    {
        $object = new StructArrayObject();
        $object
            ->setFoo(array(
                '1',
                2,
                '3',
            ));
        $this->assertEquals($object, StructArrayObject::__set_state(array(
            'foo' => array(
                '1',
                2,
                '3',
            ),
        )));
    }
    /**
     *
     */
    public function testGetAttributeName()
    {
        $object = new StructArrayObject();
        $this->assertSame('foo', $object->getAttributeName());
    }
    /**
     *
     */
    public function testLength()
    {
        $object = new StructArrayObject();
        $object
            ->setFoo(array(
                '1',
                2,
                '3',
            ));
        $object->initInternArray();
        $this->assertSame(3, $object->length());
    }
    /**
     *
     */
    public function testCount()
    {
        $object = new StructArrayObject();
        $object->initInternArray(array(
            '1',
            2,
            '3',
        ));
        $this->assertSame(3, $object->count());
    }
    /**
     *
     */
    public function testCurrent()
    {
        $object = new StructArrayObject();
        $object->initInternArray(array(
            '1',
            2,
            '3',
        ));
        $this->assertSame('1', $object->current());
    }
    /**
     *
     */
    public function testNextKey()
    {
        $object = new StructArrayObject();
        $object->initInternArray(array(
            '1',
            2,
            '3',
        ));
        $object->next();
        $this->assertSame(1, $object->key());
    }
    /**
     *
     */
    public function testRewind()
    {
        $object = new StructArrayObject();
        $object->initInternArray(array(
            '1',
            2,
            '3',
        ));
        $object->next();
        $object->rewind();
        $this->assertSame(0, $object->key());
    }
    /**
     *
     */
    public function testValid()
    {
        $object = new StructArrayObject();
        $object->initInternArray(array(
            '1',
            2,
            '3',
        ));
        $object->next();
        $this->assertTrue($object->valid());
    }
    /**
     *
     */
    public function testInValid()
    {
        $object = new StructArrayObject();
        $object->initInternArray(array(
            '1',
            2,
            '3',
        ));
        $object
            ->next()
            ->next()
            ->next()
            ->next();
        $this->assertFalse($object->valid());
    }
    /**
     *
     */
    public function testItem()
    {
        $object = new StructArrayObject();
        $object->initInternArray(array(
            '1',
            2,
            '3',
        ));
        $object->next();
        $this->assertSame(2, $object->item(1));
    }
    /**
     *
     */
    public function testAdd()
    {
        $object = new StructArrayObject();
        $object
            ->setFoo(array(
                '1',
                2,
                '3',
            ))
            ->initInternArray()
            ->add(4);
        $this->assertSame('1', $object->current());
    }
    /**
     *
     */
    public function testAddOnEmpty()
    {
        $object = new StructArrayObject();
        $object
            ->add(4)
            ->add(5)
            ->add(6);
        $this->assertSame(4, $object->current());
    }
    /**
     *
     */
    public function testFirst()
    {
        $object = new StructArrayObject();
        $object
            ->setFoo(array(
                '1',
                2,
                '3',
            ))
            ->initInternArray()
            ->add(4);
        $this->assertSame('1', $object->first());
    }
    /**
     *
     */
    public function testLast()
    {
        $object = new StructArrayObject();
        $object
            ->setFoo(array(
                '1',
                2,
                '3',
            ))
            ->initInternArray()
            ->add(4);
        $this->assertSame(4, $object->last());
    }
    /**
     *
     */
    public function testOffsetExists()
    {
        $object = new StructArrayObject();
        $object
            ->setFoo(array(
                '1',
                2,
                '3',
            ))
            ->initInternArray()
            ->add(4);
        $this->assertTrue($object->offsetExists(3));
    }
    /**
     *
     */
    public function testOffsetNotExists()
    {
        $object = new StructArrayObject();
        $object
            ->setFoo(array(
                '1',
                2,
                '3',
            ))
            ->initInternArray()
            ->add(4);
        $this->assertFalse($object->offsetExists(4));
    }
    /**
     *
     */
    public function testOffsetGet()
    {
        $object = new StructArrayObject();
        $object
            ->setFoo(array(
                '1',
                2,
                '3',
            ))
            ->initInternArray()
            ->add(4);
        $this->assertSame(4, $object->offsetGet(3));
    }
    /**
     *
     */
    public function testOffsetGetNull()
    {
        $object = new StructArrayObject();
        $object
            ->setFoo(array(
                '1',
                2,
                '3',
            ))
            ->initInternArray()
            ->add(4);
        $this->assertNull($object->offsetGet(4));
    }
    /**
     *
     */
    public function testOffsetSet()
    {
        $object = new StructArrayObject();
        $object
            ->setFoo(array(
                '1',
                2,
                '3',
            ))
            ->initInternArray()
            ->offsetSet(2, 4);
        $this->assertSame(4, $object->offsetGet(2));
    }
    /**
     *
     */
    public function testOffsetUnset()
    {
        $object = new StructArrayObject();
        $object
            ->setFoo(array(
                '1',
                2,
                '3',
            ))
            ->initInternArray()
            ->offsetUnset(2);
        $this->assertFalse($object->offsetExists(2));
    }
}