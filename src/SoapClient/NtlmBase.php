<?php

namespace WsdlToPhp\PackageBase\SoapClient;

class NtlmBase extends \SoapClient
{
    /**
     * @var mixed[]
     */
    protected $options;
    /**
     * @var string
     */
    public $__last_request;
    /**
     * @param string $wsdl
     * @param mixed[] $options
     */
    public function __construct($wsdl, array $options = array())
    {
        parent::SoapClient($wsdl, $options);
        $this->setOptions($options);
    }
    /**
     * @see SoapClient::__doRequest()
     * @return mixed
     */
    public function __doRequest($request, $location, $action, $version, $one_way = false)
    {
        $this->__last_request = $request;
        $curl = curl_init($location);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getCurlHeaders($action));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_NTLM | CURLAUTH_BASIC);
        if ($this->useNTLMAuthentication()) {
            curl_setopt($curl, CURLOPT_USERPWD, sprintf('%s:%', $this->options['login'], $this->options['password']));
        }
        return curl_exec($curl);
    }
    /**
     * @param string
     * @return string[]
     */
    protected function getCurlHeaders($action)
    {
        return array(
            'Method: POST',
            'Connection: Keep-Alive',
            'User-Agent: PHP-SOAP-CURL',
            'Content-Type: text/xml; charset=utf-8',
            sprintf('SOAPAction: "%s"', $action),
        );
    }
    /**
     * @return bool
     */
    public function useNTLMAuthentication()
    {
        return isset($this->options['login']) && isset($this->options['password']);
    }
    /**
     * @param mixed[] $options
     * @return NtlmBase
     */
    protected function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }
}
