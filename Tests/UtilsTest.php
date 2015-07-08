<?php

namespace WsdlToPhp\PackageBase\Tests;

use WsdlToPhp\PackageBase\Utils;

class UtilsTest extends TestCase
{
    /**
     *
     */
    public function testGetFormatedXmlAsString()
    {
        $this->assertEquals(file_get_contents(__DIR__ . '/resources/formated.xml'), Utils::getFormatedXml(file_get_contents(__DIR__ . '/resources/oneline.xml')));
    }
    /**
     *
     */
    public function testGetFormatedXmlAsDomDocument()
    {
        $this->assertInstanceOf('\DOMDocument', Utils::getFormatedXml(file_get_contents(__DIR__ . '/resources/oneline.xml'), true));
    }
    /**
     *
     */
    public function testGetFormatedXmlEmptyStringAsString()
    {
        $this->assertSame('', Utils::getFormatedXml(''));
    }
    /**
     *
     */
    public function testGetFormatedXmlEmptyStringAsDomDocument()
    {
        $this->assertSame(null, Utils::getFormatedXml('', true));
    }
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetFormatedXmlInvalidXmlAsDomDocument()
    {
        Utils::getFormatedXml('<xsd:schema xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:img="http://ws.estesexpress.com/imageview" attributeFormDefault="unqualified" elementFormDefault="qualified" targetNamespace="http://ws.estesexpress.com/imageview" xml:lang="en"><root>', true);
    }
}
