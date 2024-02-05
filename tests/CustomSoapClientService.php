<?php

declare(strict_types=1);

namespace WsdlToPhp\PackageBase\Tests;

use WsdlToPhp\PackageBase\AbstractSoapClientBase;

/**
 * Services can specify a custom SoapClient class
 * to be used instead of PHP default by overriding
 * the constant below.
 * 
 * @see \WsdlToPhp\PackageBase\SoapClientInterface
 * @see \WsdlToPhp\PackageBase\AbstractSoapClientBase :: getSoapClientClassName()
 */

class CustomSoapClientService extends AbstractSoapClientBase
{

    /**
     * Custom SoapClient class used for current service.
     */
    const DEFAULT_SOAP_CLIENT_CLASS = Client::class;
    
}
