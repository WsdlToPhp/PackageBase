<?php

declare(strict_types=1);

namespace WsdlToPhp\PackageBase\Tests;

use SoapFault;
use WsdlToPhp\PackageBase\AbstractSoapClientBase;

class SoapClient extends AbstractSoapClientBase
{
    public function getSoapClientClassName(?string $soapClientClassName = null): string
    {
        return parent::getSoapClientClassName(empty($soapClientClassName) ? Client::class : $soapClientClassName);
    }

    public function search()
    {
        try {
            $this->getSoapClient()->search();
        } catch (SoapFault $soapFault) {
            $this->setResult(null);
            $this->saveLastError(__METHOD__, $soapFault);
        }
    }
}
