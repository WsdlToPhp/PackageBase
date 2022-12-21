<?php

declare(strict_types=1);

namespace WsdlToPhp\PackageBase\Tests;

use DOMDocument;
use InvalidArgumentException;
use ValueError;
use WsdlToPhp\PackageBase\Utils;

class UtilsTest extends TestCase
{
    public function testGetFormattedXmlAsString(): void
    {
        $this->assertEquals(file_get_contents(__DIR__ . '/resources/formated.xml'), Utils::getFormattedXml(file_get_contents(__DIR__ . '/resources/oneline.xml')));
    }

    public function testGetFormattedXmlAsDomDocument(): void
    {
        $this->assertInstanceOf(DOMDocument::class, Utils::getFormattedXml(file_get_contents(__DIR__ . '/resources/oneline.xml'), true));
    }

    public function testGetFormattedXmlEmptyStringAsString(): void
    {
        $this->expectException(-1 === version_compare(PHP_VERSION, '8.0.0') ? InvalidArgumentException::class : ValueError::class);

        Utils::getFormattedXml('');
    }

    public function testGetFormattedXmlEmptyStringAsDomDocument(): void
    {
        $this->expectException(-1 === version_compare(PHP_VERSION, '8.0.0') ? InvalidArgumentException::class : ValueError::class);

        Utils::getFormattedXml('', true);
    }

    public function testGetFormattedXmlInvalidXmlAsDomDocument(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Utils::getFormattedXml('<xsd:schema xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:img="http://ws.estesexpress.com/imageview" attributeFormDefault="unqualified" elementFormDefault="qualified" targetNamespace="http://ws.estesexpress.com/imageview" xml:lang="en"><root>', true);
    }

    public function testGetFormattedXmlNullAsString(): void
    {
        $this->assertNull(Utils::getFormattedXml(null));
    }

    public function testGetFormattedXmlNullAsDomDocument(): void
    {
        $this->assertNull(Utils::getFormattedXml(null, true));
    }

    public function testGetDOMDocument(): void
    {
        $this->assertInstanceOf(DOMDocument::class, Utils::getDOMDocument(file_get_contents(__DIR__ . '/resources/oneline.xml')));
    }

    public function testGetDOMDocumentException(): void
    {
        $this->expectException(-1 === version_compare(PHP_VERSION, '8.0.0') ? InvalidArgumentException::class : ValueError::class);

        $this->assertInstanceOf(DOMDocument::class, Utils::getDOMDocument(''));
    }
}
