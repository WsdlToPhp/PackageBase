<?php

declare(strict_types=1);

namespace WsdlToPhp\PackageBase\Tests;

use DOMDocument;
use SoapFault;
use WsdlToPhp\PackageBase\Utils;
use SoapClient as SoapClientBase;

class SoapClientTest extends TestCase
{
    public function testSoapClientName(): void
    {
        $soapClient = new SoapClient();

        $this->assertSame(Client::class, $soapClient->getSoapClientClassName());
    }

    public function testSoapClientNameDefault(): void
    {
        $soapClient = new SoapClient();

        $this->assertSame(Client::class, $soapClient->getSoapClientClassName(Client::class));
    }

    public function testCustomSoapClientNameReadFromConstant()
    {
        $defaultService = new DefaultSoapClientService();
        $customService  = new CustomSoapClientService();

        $this->assertSame(SoapClientBase::class, $defaultService->getSoapClientClassName());
        $this->assertSame(Client::class, $customService->getSoapClientClassName());
    }

    public function testSoapClient(): void
    {
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
        ]);

        $this->assertInstanceOf(Client::class, $soapClient->getSoapClient());
    }

    public function testSetLocation(): void
    {
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
        ]);

        $soapClient->setLocation('http://api.bing.net:80/soap.asm');

        $this->assertSame('http://api.bing.net:80/soap.asm', $soapClient->getSoapClient()->location);
    }

    public function testLocationOption(): void
    {
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
            SoapClient::WSDL_LOCATION => 'http://api.bing.net:80/soap.asm',
        ]);

        $this->assertSame('http://api.bing.net:80/soap.asm', $soapClient->getSoapClient()->location);
    }

    public function testGetLastRequestAsString(): void
    {
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
        ]);

        $this->assertSame(Utils::getFormattedXml(file_get_contents(__DIR__ . '/resources/oneline.xml')), $soapClient->getLastRequest(false));
    }

    public function testGetLastRequestAsDomDocument(): void
    {
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
        ]);

        $this->assertInstanceOf('\DOMDocument', $soapClient->getLastRequest(true));
    }

    public function testGetLastResponseAsString(): void
    {
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
        ]);

        $this->assertSame(Utils::getFormattedXml(file_get_contents(__DIR__ . '/resources/oneline.xml')), $soapClient->getLastResponse(false));
    }

    public function testGetLastResponseAsDomDocument(): void
    {
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
        ]);

        $this->assertInstanceOf(DOMDocument::class, $soapClient->getLastResponse(true));
    }

    public function testGetLastRequestHeadersAsString(): void
    {
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
        ]);

        $this->assertSame($soapClient->getSoapClient()->__getLastRequestHeaders(), $soapClient->getLastRequestHeaders(false));
    }

    public function testGetLastRequestHeadersAsArray(): void
    {
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
        ]);

        $this->assertSame($soapClient->getSoapClient()->getLastRequestHeadersAsArray(), $soapClient->getLastRequestHeaders(true));
    }

    public function testGetLastResponseHeadersAsString(): void
    {
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
        ]);

        $this->assertSame($soapClient->getSoapClient()->__getLastResponseHeaders(), $soapClient->getLastResponseHeaders(false));
    }

    public function testGetLastResponseHeadersAsArray(): void
    {
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
        ]);

        $this->assertSame($soapClient->getSoapClient()->getLastResponseHeadersAsArray(), $soapClient->getLastResponseHeaders(true));
    }

    public function testSetGetLastErrorForMethod(): void
    {
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
        ]);

        // this call should fail as no parameter is defined in the request
        $soapClient->search();

        $this->assertInstanceOf(SoapFault::class, $soapClient->getLastErrorForMethod(SoapClient::class.'::search'));
    }

    public function testSetGetLastError(): void
    {
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
        ]);

        // this call should fail as no parameter is defined in the request
        $soapClient->search();

        $this->assertCount(1, $soapClient->getLastError());
    }

    public function testSetGetResult(): void
    {
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
        ]);

        // this call should fail as no parameter is defined in the request
        $soapClient->search();

        $this->assertNull($soapClient->getResult());
    }

    public function testSetHeaders(): void
    {
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
        ]);

        $this->assertTrue($soapClient->setHttpHeader('X-Header-Name', 'X-Header-Value'));

        $this->assertTrue(is_resource($soapClient->getSoapClient()->_stream_context));

        $o = stream_context_get_options($soapClient->getSoapClient()->_stream_context);
        $this->assertTrue(strpos($o['http']['header'], 'X-Header-Name: X-Header-Value') !== false);
    }

    public function testSetHeadersOnExistingHeaders(): void
    {
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
        ]);

        $this->assertTrue($soapClient->setHttpHeader('X-Header-Name', 'X-Header-Value'));
        $this->assertTrue($soapClient->setHttpHeader('X-Header-ID', 'X-Header-ID-Value'));

        $this->assertTrue(is_resource($soapClient->getSoapClient()->_stream_context));

        $o = stream_context_get_options($soapClient->getSoapClient()->_stream_context);
        $this->assertTrue(strpos($o['http']['header'], 'X-Header-Name: X-Header-Value') !== false);
        $this->assertTrue(strpos($o['http']['header'], 'X-Header-ID: X-Header-ID-Value') !== false);
    }

    public function testSetHeadersOnExistingHttpsHeaders(): void
    {
        $streamContext = stream_context_create([
            'https' => [
                'header' => [
                    'X-HEADER' => 'X-VALUE',
                ],
            ],
        ]);
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
            SoapClient::WSDL_STREAM_CONTEXT => $streamContext,
        ]);

        $this->assertTrue($soapClient->setHttpHeader('X-Header-Name', 'X-Header-Value'));
        $this->assertTrue($soapClient->setHttpHeader('X-Header-ID', 'X-Header-ID-Value'));

        $this->assertTrue(is_resource($soapClient->getSoapClient()->_stream_context));

        $o = stream_context_get_options($soapClient->getSoapClient()->_stream_context);
        $this->assertSame([
            'header' => [
                'X-HEADER' => 'X-VALUE',
            ],
        ], $o['https']);
        $this->assertTrue(strpos($o['http']['header'], 'X-Header-Name: X-Header-Value') !== false);
        $this->assertTrue(strpos($o['http']['header'], 'X-Header-ID: X-Header-ID-Value') !== false);
    }

    public function testSetHeadersOnExistingHttpHeaders(): void
    {
        $streamContext = stream_context_create([
            'http' => [
                'Auth' => [
                    'X-HEADER' => 'X-VALUE',
                ],
            ],
        ]);
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
            SoapClient::WSDL_STREAM_CONTEXT => $streamContext,
        ]);

        $this->assertTrue($soapClient->setHttpHeader('X-Header-Name', 'X-Header-Value'));
        $this->assertTrue($soapClient->setHttpHeader('X-Header-ID', 'X-Header-ID-Value'));

        $this->assertTrue(is_resource($soapClient->getSoapClient()->_stream_context));

        $o = stream_context_get_options($soapClient->getSoapClient()->_stream_context);
        $this->assertSame([
            'X-HEADER' => 'X-VALUE',
        ], $o['http']['Auth']);
        $this->assertTrue(strpos($o['http']['header'], 'X-Header-Name: X-Header-Value') !== false);
        $this->assertTrue(strpos($o['http']['header'], 'X-Header-ID: X-Header-ID-Value') !== false);
    }

    public function testGetStreamContext(): void
    {
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
        ]);

        $this->assertTrue($soapClient->setHttpHeader('X-Header-Name', 'X-Header-Value'));

        $this->assertTrue(is_resource($soapClient->getStreamContext()));

        $o = stream_context_get_options($soapClient->getStreamContext());
        $this->assertTrue(strpos($o['http']['header'], 'X-Header-Name: X-Header-Value') !== false);
    }

    public function testGetStreamContextAsNull(): void
    {
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
        ]);

        if (PHP_VERSION_ID < 70013) {
            $this->assertNull($soapClient->getStreamContext());
        } else {
            $this->assertTrue(is_resource($soapClient->getStreamContext()));
        }
    }

    public function testSetHeadersOnExistingHttpHeadersWithGetStreamContextOptions(): void
    {
        $streamContext = stream_context_create([
            'http' => [
                'Auth' => [
                    'X-HEADER' => 'X-VALUE',
                ],
            ],
        ]);
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
            SoapClient::WSDL_STREAM_CONTEXT => $streamContext,
        ]);

        $this->assertTrue($soapClient->setHttpHeader('X-Header-Name', 'X-Header-Value'));
        $this->assertTrue($soapClient->setHttpHeader('X-Header-ID', 'X-Header-ID-Value'));

        $this->assertTrue(is_resource($soapClient->getStreamContext()));

        $o = $soapClient->getStreamContextOptions();
        $this->assertSame([
            'X-HEADER' => 'X-VALUE',
        ], $o['http']['Auth']);
        $this->assertContains('X-Header-Name: X-Header-Value', $o['http']['header']);
        $this->assertContains('X-Header-ID: X-Header-ID-Value', $o['http']['header']);
    }

    public function testSetSoapHeader(): void
    {
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
        ]);

        $soapClient->setSoapHeader('urn:namespace', 'HeaderAuth', 'the-data', false, null);

        $this->assertEquals([
            new \SoapHeader('urn:namespace', 'HeaderAuth', 'the-data', false),
        ], $soapClient->getSoapClient()->__default_headers);
    }

    public function testSetSoapHeaderModified(): void
    {
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
        ]);

        $soapClient->setSoapHeader('urn:namespace', 'HeaderAuth', 'the-data', false, null);
        $soapClient->setSoapHeader('urn:namespace', 'HeaderAuth', 'the-data-modified', false, null);

        $this->assertEquals(new \SoapHeader('urn:namespace', 'HeaderAuth', 'the-data-modified', false), array_pop($soapClient->getSoapClient()->__default_headers));
    }

    public function testSetSoapActor(): void
    {
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
        ]);

        $soapClient->setSoapHeader('urn:namespace', 'HeaderAuth', 'the-data', false, 'actor');

        $this->assertEquals([
            new \SoapHeader('urn:namespace', 'HeaderAuth', 'the-data', false, 'actor'),
        ], $soapClient->getSoapClient()->__default_headers);
    }
    /**
     * @return string[]
     */
    public static function classMap()
    {
        return [
            'AdultOption' => 'ApiEnumAdultOption',
            'ArrayOfDeepLink' => 'ApiStructArrayOfDeepLink',
            'ArrayOfError' => 'ApiStructArrayOfError',
            'ArrayOfImageResult' => 'ApiStructArrayOfImageResult',
            'ArrayOfInstantAnswerResult' => 'ApiStructArrayOfInstantAnswerResult',
            'ArrayOfMobileWebResult' => 'ApiStructArrayOfMobileWebResult',
            'ArrayOfMobileWebSearchOption' => 'ApiStructArrayOfMobileWebSearchOption',
            'ArrayOfNewsArticle' => 'ApiStructArrayOfNewsArticle',
            'ArrayOfNewsCollection' => 'ApiStructArrayOfNewsCollection',
            'ArrayOfNewsRelatedSearch' => 'ApiStructArrayOfNewsRelatedSearch',
            'ArrayOfNewsResult' => 'ApiStructArrayOfNewsResult',
            'ArrayOfRelatedSearchResult' => 'ApiStructArrayOfRelatedSearchResult',
            'ArrayOfSearchOption' => 'ApiStructArrayOfSearchOption',
            'ArrayOfSourceType' => 'ApiStructArrayOfSourceType',
            'ArrayOfSpellResult' => 'ApiStructArrayOfSpellResult',
            'ArrayOfString' => 'ApiStructArrayOfString',
            'ArrayOfVideoResult' => 'ApiStructArrayOfVideoResult',
            'ArrayOfWebResult' => 'ApiStructArrayOfWebResult',
            'ArrayOfWebSearchOption' => 'ApiStructArrayOfWebSearchOption',
            'ArrayOfWebSearchTag' => 'ApiStructArrayOfWebSearchTag',
            'DeepLink' => 'ApiStructDeepLink',
            'Error' => 'ApiStructError',
            'ImageRequest' => 'ApiStructImageRequest',
            'ImageResponse' => 'ApiStructImageResponse',
            'ImageResult' => 'ApiStructImageResult',
            'InstantAnswerResponse' => 'ApiStructInstantAnswerResponse',
            'InstantAnswerResult' => 'ApiStructInstantAnswerResult',
            'MobileWebRequest' => 'ApiStructMobileWebRequest',
            'MobileWebResponse' => 'ApiStructMobileWebResponse',
            'MobileWebResult' => 'ApiStructMobileWebResult',
            'MobileWebSearchOption' => 'ApiEnumMobileWebSearchOption',
            'NewsArticle' => 'ApiStructNewsArticle',
            'NewsCollection' => 'ApiStructNewsCollection',
            'NewsRelatedSearch' => 'ApiStructNewsRelatedSearch',
            'NewsRequest' => 'ApiStructNewsRequest',
            'NewsResponse' => 'ApiStructNewsResponse',
            'NewsResult' => 'ApiStructNewsResult',
            'NewsSortOption' => 'ApiEnumNewsSortOption',
            'PhonebookRequest' => 'ApiStructPhonebookRequest',
            'PhonebookSortOption' => 'ApiEnumPhonebookSortOption',
            'Query' => 'ApiStructQuery',
            'RelatedSearchResponse' => 'ApiStructRelatedSearchResponse',
            'RelatedSearchResult' => 'ApiStructRelatedSearchResult',
            'SearchOption' => 'ApiEnumSearchOption',
            'SearchRequest' => 'ApiStructSearchRequest',
            'SearchResponse' => 'ApiStructSearchResponse',
            'SourceType' => 'ApiEnumSourceType',
            'SpellResponse' => 'ApiStructSpellResponse',
            'SpellResult' => 'ApiStructSpellResult',
            'Thumbnail' => 'ApiStructThumbnail',
            'TranslationRequest' => 'ApiStructTranslationRequest',
            'VideoRequest' => 'ApiStructVideoRequest',
            'VideoResponse' => 'ApiStructVideoResponse',
            'VideoResult' => 'ApiStructVideoResult',
            'VideoSortOption' => 'ApiEnumVideoSortOption',
            'WebRequest' => 'ApiStructWebRequest',
            'WebResponse' => 'ApiStructWebResponse',
            'WebResult' => 'ApiStructWebResult',
            'WebSearchOption' => 'ApiEnumWebSearchOption',
            'WebSearchTag' => 'ApiStructWebSearchTag',
        ];
    }

    public function testInvalidNonWsdlModeMustNotCreateASoapInstanceForMissingUriAndLocationOptions(): void
    {
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => null,
        ]);

        $this->assertNull($soapClient->getSoapClient());
    }

    public function testInvalidNonWsdlModeMustNotCreateASoapInstanceForMissingLocationOption(): void
    {
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => null,
            SoapClient::WSDL_URI => 'http://api.bing.net:80/soap.asmx',
        ]);

        $this->assertNull($soapClient->getSoapClient());
    }

    public function testInvalidNonWsdlModeMustNotCreateASoapInstanceForMissingUriOption(): void
    {
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => null,
            SoapClient::WSDL_LOCATION => 'http://api.bing.net:80/soap.asmx',
        ]);

        $this->assertNull($soapClient->getSoapClient());
    }

    public function testInvalidNonWsdlModeMustCreateASoapInstanceWithUriAndLocationOptions(): void
    {
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => null,
            SoapClient::WSDL_LOCATION => 'http://api.bing.net:80/soap.asmx',
            SoapClient::WSDL_URI => 'http://api.bing.net:80/soap.asmx',
        ]);

        $this->assertInstanceOf(SoapClientBase::class, $soapClient->getSoapClient());
    }

    public function test__toStringMustReturnTheClassNameOfTheInstance(): void
    {
        $this->assertSame(SoapClient::class, (string) new SoapClient());
    }

    public function testGetOutputHeadersWithoutRequestMustReturnAnEmptyArray(): void
    {
        $soapClient = new SoapClient([
            SoapClient::WSDL_URL => null,
            SoapClient::WSDL_LOCATION => 'http://api.bing.net:80/soap.asmx',
            SoapClient::WSDL_URI => 'http://api.bing.net:80/soap.asmx',
        ]);

        $this->assertTrue(is_array($soapClient->getOutputHeaders()));
        $this->assertEmpty($soapClient->getOutputHeaders());
    }

}
