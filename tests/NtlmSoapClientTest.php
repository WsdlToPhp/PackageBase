<?php

namespace WsdlToPhp\PackageBase\Tests;

use WsdlToPhp\PackageBase\Utils;
use WsdlToPhp\PackageBase\Tests\SoapClient;

class NtlmSoapClientTest extends TestCase
{
    /**
     *
     */
    public function testGetSoapClientClassName()
    {
        $soapClient = new NtlmSoapClient();

        $this->assertSame('\WsdlToPhp\PackageBase\SoapClient\NtlmBase', $soapClient->getSoapClientClassName());
    }
    /**
     *
     */
    public function testGetSoapClientClassNameDefault()
    {
        $soapClient = new NtlmSoapClient();

        $this->assertSame('\SoapClient', $soapClient->getSoapClientClassName('\SoapClie'));
    }
    /**
     *
     */
    public function testUseNTLMAuthenticationFalse()
    {
        $soapClient = new NtlmSoapClient(array(
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
        ), true);

        $this->assertFalse(NtlmSoapClient::getSoapClient()->useNTLMAuthentication());
    }
    /**
     *
     */
    public function testUseNTLMAuthenticationTrue()
    {
        $soapClient = new NtlmSoapClient(array(
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
            SoapClient::WSDL_LOGIN => 'foo',
            SoapClient::WSDL_PASSWORD => 'bar',
        ), true);

        $this->assertTrue(NtlmSoapClient::getSoapClient()->useNTLMAuthentication());
    }
    /**
     *
     */
    public function testSearchWithoutAuthentication()
    {
        $soapClient = new NtlmSoapClient(array(
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
        ), true);

        // this call should fail as no parameter is defined in the request
        $soapClient->search();

        $this->assertInstanceOf('\SoapFault', $soapClient->getLastErrorForMethod('WsdlToPhp\PackageBase\Tests\NtlmSoapClient::search'));
    }
    /**
     *
     */
    public function testSearchWithAuthentication()
    {
        $soapClient = new NtlmSoapClient(array(
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
            SoapClient::WSDL_LOGIN => 'foo',
            SoapClient::WSDL_PASSWORD => 'bar',
        ), true);

        // this call should fail as no parameter is defined in the request
        $soapClient->search();

        $this->assertInstanceOf('\SoapFault', $soapClient->getLastErrorForMethod('WsdlToPhp\PackageBase\Tests\NtlmSoapClient::search'));
    }
    /**
     *
     */
    public function testGetLastRequest()
    {
        $soapClient = new NtlmSoapClient(array(
            SoapClient::WSDL_URL => __DIR__ . '/resources/bingsearch.wsdl',
            SoapClient::WSDL_CLASSMAP => self::classMap(),
            SoapClient::WSDL_LOGIN => 'foo',
            SoapClient::WSDL_PASSWORD => 'bar',
        ), true);

        // this call should fail as no parameter is defined in the request
        $soapClient->search();

        $this->assertNotEmpty(NtlmSoapClient::getSoapClient()->__getLastRequest());
    }
}
