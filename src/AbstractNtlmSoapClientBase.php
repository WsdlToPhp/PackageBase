<?php

namespace WsdlToPhp\PackageBase;

abstract class AbstractNtlmSoapClientBase extends AbstractSoapClientBase
{
    /**
     * @see \WsdlTophp\PackageBase\AbstractSoapClientBase::getSoapClientClassName()
     * @param string $soapClientClassName
     * @return string
     */
    public function getSoapClientClassName($soapClientClassName = null)
    {
        return parent::getSoapClientClassName(empty($soapClientClassName) ? '\WsdlToPhp\PackageBase\SoapClient\NtlmBase' : $soapClientClassName);
    }
    /**
     * @see \WsdlTophp\PackageBase\AbstractSoapClientBase::getSoapClient()
     * @return WsdlToPhp\PackageBase\SoapClient\NtlmBase
     */
    public static function getSoapClient()
    {
        return parent::getSoapClient();
    }
}
