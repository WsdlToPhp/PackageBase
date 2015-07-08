<?php

namespace WsdlToPhp\PackageBase\Tests;

use WsdlToPhp\PackageBase\AbstractSoapClientBase;

class SoapClient extends AbstractSoapClientBase
{
    public function getSoapClientClassName($soapClientClassName = null)
    {
        return parent::getSoapClientClassName(empty($soapClientClassName) ? '\\WsdlToPhp\\PackageBase\\Tests\\Client' : $soapClientClassName);
    }
}
