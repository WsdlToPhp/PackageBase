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
     * @expectedException \InvalidArgumentException
     */
    public function testGetFormatedXmlEmptyStringAsString()
    {
        Utils::getFormatedXml('');
    }
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetFormatedXmlEmptyStringAsDomDocument()
    {
        Utils::getFormatedXml('', true);
    }
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetFormatedXmlInvalidXmlAsDomDocument()
    {
        Utils::getFormatedXml('<xsd:schema xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:img="http://ws.estesexpress.com/imageview" attributeFormDefault="unqualified" elementFormDefault="qualified" targetNamespace="http://ws.estesexpress.com/imageview" xml:lang="en"><root>', true);
    }
    /**
     *
     */
    public function testGetFormatedXmlNullAsString()
    {
        $this->assertNull(Utils::getFormatedXml(null));
    }
    /**
     *
     */
    public function testGetFormatedXmlNullAsDomDocument()
    {
        $this->assertNull(Utils::getFormatedXml(null, true));
    }
    /**
     *
     */
    public function testGetDOMDocument()
    {
        $this->assertInstanceOf('\DOMDocument', Utils::getDOMDocument(file_get_contents(__DIR__ . '/resources/oneline.xml')));
    }
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetDOMDocumentException()
    {
        $this->assertInstanceOf('\DOMDocument', Utils::getDOMDocument(''));
    }
}
