<?php

namespace WsdlToPhp\PackageBase\Tests;

class Client extends \SoapClient
{
    public function __getLastRequest()
    {
        return file_get_contents(__DIR__ . '/resources/oneline.xml');
    }
    public function __getLastResponse()
    {
        return file_get_contents(__DIR__ . '/resources/oneline.xml');
    }
    public function __getLastRequestHeaders()
    {
        return "X-Header-1: valud-1\r\n".
               "X-Header-2: valud-2\r\n".
               "X-Header-Date: 2015-03-02T21:36:87\r\n".
               "X-Header-Content-Type: text/xml; charset=utf-8\r\n";
    }
    public function getLastRequestHeadersAsArray()
    {
        return array(
            'X-Header-1' => 'valud-1',
            'X-Header-2' => 'valud-2',
            'X-Header-Date' => '2015-03-02T21:36:87',
            'X-Header-Content-Type' => 'text/xml; charset=utf-8',
        );
    }
    public function __getLastResponseHeaders()
    {
        return "X-Header-1: valud-1\r\n".
               "X-Header-2: valud-2\r\n".
               "X-Header-Date: 2015-03-02T21:36:87\r\n".
               "X-Header-Content-Type: text/xml; charset=utf-8\r\n";
    }
    public function getLastResponseHeadersAsArray()
    {
        return array(
            'X-Header-1' => 'valud-1',
            'X-Header-2' => 'valud-2',
            'X-Header-Date' => '2015-03-02T21:36:87',
            'X-Header-Content-Type' => 'text/xml; charset=utf-8',
        );
    }
}
