<?php

namespace WsdlToPhp\PackageBase\Tests;

use WsdlToPhp\PackageBase\AbstractNtlmSoapClientBase;

class NtlmSoapClient extends AbstractNtlmSoapClientBase
{
    /**
     *
     */
    public function search()
    {
        try {
            self::getSoapClient()->search();
        } catch (\SoapFault $soapFault) {
            $this->setResult(null);
            $this->saveLastError(__METHOD__, $soapFault);
        }
    }
}
