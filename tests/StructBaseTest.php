<?php

namespace WsdlToPhp\PackageBase\Tests;

class StructBase extends TestCase
{
    /**
     *
     */
    public function testSetState()
    {
        $object = new StructObject();
        $object
            ->setBar('foo')
            ->setFoo('bar');
        $this->assertEquals($object, StructObject::__set_state(array(
            'bar' => 'foo',
            'foo' => 'bar',
        )));
    }
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetStateException()
    {
        StructObject::__set_state(array(
            'bar' => 'foo',
            'foo' => 'bar',
            'sample' => 'data',
        ));
    }
    /**
     *
     */
    public function testSetGet()
    {
        $object = new StructObject();
        $object
            ->setBar('foo')
            ->setFoo('bar');
        $this->assertSame('foo', $object->_get('bar'));
    }
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetGetWithException()
    {
        $object = new StructObject();
        $object
            ->setBar('foo')
            ->setFoo('bar');
        $object->_get('sample');
    }
}