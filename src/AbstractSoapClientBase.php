<?php

namespace WsdlToPhp\PackageBase;

abstract class AbstractSoapClientBase implements SoapClientInterface
{
    /**
     * Soapclient called to communicate with the actual SOAP Service
     * @var \SoapClient
     */
    private static $soapClient;
    /**
     * Contains Soap call result
     * @var mixed
     */
    private $result;
    /**
     * Contains last errors
     * @var array
     */
    private $lastError;
    /**
     * Constructor
     * @uses AbstractSoapClientBase::setLastError()
     * @uses AbstractSoapClientBase::initSoapClient()
     * @param array $wsdlOptions
     * @param bool $resetSoapClient allows to disable the SoapClient redefinition
     */
    public function __construct(array $wsdlOptions = [], $resetSoapClient = true)
    {
        $this->setLastError([]);
        /**
         * Init soap Client
         * Set default values
         */
        if ($resetSoapClient) {
            $this->initSoapClient($wsdlOptions);
        }
    }
    /**
     * Static method getting current SoapClient
     * @return \SoapClient
     */
    public static function getSoapClient()
    {
        return self::$soapClient;
    }
    /**
     * Static method setting current SoapClient
     * @param \SoapClient $soapClient
     * @return \SoapClient
     */
    public static function setSoapClient(\SoapClient $soapClient)
    {
        return (self::$soapClient = $soapClient);
    }
    /**
     * Method initiating SoapClient
     * @uses ApiClassMap::classMap()
     * @uses AbstractSoapClientBase::getDefaultWsdlOptions()
     * @uses AbstractSoapClientBase::getSoapClientClassName()
     * @uses AbstractSoapClientBase::setSoapClient()
     * @param array $options WSDL options
     * @return void
     */
    public function initSoapClient(array $options)
    {
        $wsdlOptions = [];
        $defaultWsdlOptions = static::getDefaultWsdlOptions();
        foreach ($defaultWsdlOptions as $optionName => $optionValue) {
            if (array_key_exists($optionName, $options) && !is_null($options[$optionName])) {
                $wsdlOptions[str_replace(self::OPTION_PREFIX, '', $optionName)] = $options[$optionName];
            } elseif (!is_null($optionValue)) {
                $wsdlOptions[str_replace(self::OPTION_PREFIX, '', $optionName)] = $optionValue;
            }
        }
        if (array_key_exists(str_replace(self::OPTION_PREFIX, '', self::WSDL_URL), $wsdlOptions)) {
            $wsdlUrl = $wsdlOptions[str_replace(self::OPTION_PREFIX, '', self::WSDL_URL)];
            unset($wsdlOptions[str_replace(self::OPTION_PREFIX, '', self::WSDL_URL)]);
            $soapClientClassName = $this->getSoapClientClassName();
            static::setSoapClient(new $soapClientClassName($wsdlUrl, $wsdlOptions));
        }
    }
    /**
     * Returns the SoapClient class name to use to create the instance of the SoapClient.
     * The SoapClient class is determined based on the package name.
     * If a class is named as {Api}SoapClient, then this is the class that will be used.
     * Be sure that this class inherits from the native PHP SoapClient class and this class has been loaded or can be loaded.
     * The goal is to allow the override of the SoapClient without having to modify this generated class.
     * Then the overridding SoapClient class can override for example the SoapClient::__doRequest() method if it is needed.
     * @return string
     */
    public function getSoapClientClassName($soapClientClassName = null)
    {
        $className = self::DEFAULT_SOAP_CLIENT_CLASS;
        if (!empty($soapClientClassName) && is_subclass_of($soapClientClassName, '\SoapClient')) {
            $className = $soapClientClassName;
        }
        return $className;
    }
    /**
     * Method returning all default options values
     * @uses AbstractSoapClientBase::WSDL_CLASSMAP
     * @uses AbstractSoapClientBase::WSDL_CACHE_WSDL
     * @uses AbstractSoapClientBase::WSDL_COMPRESSION
     * @uses AbstractSoapClientBase::WSDL_CONNECTION_TIMEOUT
     * @uses AbstractSoapClientBase::WSDL_ENCODING
     * @uses AbstractSoapClientBase::WSDL_EXCEPTIONS
     * @uses AbstractSoapClientBase::WSDL_FEATURES
     * @uses AbstractSoapClientBase::WSDL_LOCATION
     * @uses AbstractSoapClientBase::WSDL_LOGIN
     * @uses AbstractSoapClientBase::WSDL_PASSWORD
     * @uses AbstractSoapClientBase::WSDL_SOAP_VERSION
     * @uses AbstractSoapClientBase::WSDL_STREAM_CONTEXT
     * @uses AbstractSoapClientBase::WSDL_TRACE
     * @uses AbstractSoapClientBase::WSDL_TYPEMAP
     * @uses AbstractSoapClientBase::WSDL_URL
     * @uses AbstractSoapClientBase::VALUE_WSDL_URL
     * @uses AbstractSoapClientBase::WSDL_USER_AGENT
     * @uses AbstractSoapClientBase::WSDL_PROXY_HOST
     * @uses AbstractSoapClientBase::WSDL_PROXY_PORT
     * @uses AbstractSoapClientBase::WSDL_PROXY_LOGIN
     * @uses AbstractSoapClientBase::WSDL_PROXY_PASSWORD
     * @uses AbstractSoapClientBase::WSDL_LOCAL_CERT
     * @uses AbstractSoapClientBase::WSDL_PASSPHRASE
     * @uses AbstractSoapClientBase::WSDL_AUTHENTICATION
     * @uses AbstractSoapClientBase::WSDL_SSL_METHOD
     * @uses SOAP_SINGLE_ELEMENT_ARRAYS
     * @uses SOAP_USE_XSI_ARRAY_TYPE
     * @return array
     */
    public static function getDefaultWsdlOptions()
    {
        return [
            self::WSDL_CLASSMAP => null,
            self::WSDL_CACHE_WSDL => WSDL_CACHE_NONE,
            self::WSDL_COMPRESSION => null,
            self::WSDL_CONNECTION_TIMEOUT => null,
            self::WSDL_ENCODING => null,
            self::WSDL_EXCEPTIONS => true,
            self::WSDL_FEATURES => SOAP_SINGLE_ELEMENT_ARRAYS | SOAP_USE_XSI_ARRAY_TYPE,
            self::WSDL_LOCATION => null,
            self::WSDL_LOGIN => null,
            self::WSDL_PASSWORD => null,
            self::WSDL_SOAP_VERSION => null,
            self::WSDL_STREAM_CONTEXT => null,
            self::WSDL_TRACE => true,
            self::WSDL_TYPEMAP => null,
            self::WSDL_URL => null,
            self::WSDL_USER_AGENT => null,
            self::WSDL_PROXY_HOST => null,
            self::WSDL_PROXY_PORT => null,
            self::WSDL_PROXY_LOGIN => null,
            self::WSDL_PROXY_PASSWORD => null,
            self::WSDL_LOCAL_CERT => null,
            self::WSDL_PASSPHRASE => null,
            self::WSDL_AUTHENTICATION => null,
            self::WSDL_SSL_METHOD => null,
        ];
    }
    /**
     * Allows to set the SoapClient location to call
     * @uses AbstractSoapClientBase::getSoapClient()
     * @uses SoapClient::__setLocation()
     * @param string $location
     * @return AbstractSoapClientBase
     */
    public function setLocation($location)
    {
        if (static::getSoapClient() instanceof \SoapClient) {
            static::getSoapClient()->__setLocation($location);
        }
        return $this;
    }
    /**
     * Returns the last request content as a DOMDocument or as a formated XML String
     * @see SoapClient::__getLastRequest()
     * @uses AbstractSoapClientBase::getSoapClient()
     * @uses AbstractSoapClientBase::getFormatedXml()
     * @uses SoapClient::__getLastRequest()
     * @param bool $asDomDocument
     * @return \DOMDocument|string|null
     */
    public function getLastRequest($asDomDocument = false)
    {
        return $this->getLastXml('__getLastRequest', $asDomDocument);
    }
    /**
     * Returns the last response content as a DOMDocument or as a formated XML String
     * @see SoapClient::__getLastResponse()
     * @uses AbstractSoapClientBase::getSoapClient()
     * @uses AbstractSoapClientBase::getFormatedXml()
     * @uses SoapClient::__getLastResponse()
     * @param bool $asDomDocument
     * @return \DOMDocument|string|null
     */
    public function getLastResponse($asDomDocument = false)
    {
        return $this->getLastXml('__getLastResponse', $asDomDocument);
    }
    /**
     * @param string $method
     * @param bool $asDomDocument
     * @return \DOMDocument|string|null
     */
    protected function getLastXml($method, $asDomDocument = false)
    {
        $xml = null;
        if (static::getSoapClient() instanceof \SoapClient) {
            $xml = static::getFormatedXml(static::getSoapClient()->$method(), $asDomDocument);
        }
        return $xml;
    }
    /**
     * Returns the last request headers used by the SoapClient object as the original value or an array
     * @see SoapClient::__getLastRequestHeaders()
     * @uses AbstractSoapClientBase::getSoapClient()
     * @uses AbstractSoapClientBase::convertStringHeadersToArray()
     * @uses SoapClient::__getLastRequestHeaders()
     * @param bool $asArray allows to get the headers in an associative array
     * @return null|string|array
     */
    public function getLastRequestHeaders($asArray = false)
    {
        return $this->getLastHeaders('__getLastRequestHeaders', $asArray);
    }
    /**
     * Returns the last response headers used by the SoapClient object as the original value or an array
     * @see SoapClient::__getLastResponseHeaders()
     * @uses AbstractSoapClientBase::getSoapClient()
     * @uses AbstractSoapClientBase::convertStringHeadersToArray()
     * @uses SoapClient::__getLastRequestHeaders()
     * @param bool $asArray allows to get the headers in an associative array
     * @return null|string|array
     */
    public function getLastResponseHeaders($asArray = false)
    {
        return $this->getLastHeaders('__getLastResponseHeaders', $asArray);
    }
    /**
     * @param string $method
     * @param bool $asArray allows to get the headers in an associative array
     * @return string[]|null
     */
    protected function getLastHeaders($method, $asArray)
    {
        $headers = static::getSoapClient() instanceof \SoapClient ? static::getSoapClient()->$method() : null;
        if (is_string($headers) && $asArray) {
            return static::convertStringHeadersToArray($headers);
        }
        return $headers;
    }
    /**
     * Returns a XML string content as a DOMDocument or as a formated XML string
     * @uses \DOMDocument::loadXML()
     * @uses \DOMDocument::saveXML()
     * @param string $string
     * @param bool $asDomDocument
     * @return \DOMDocument|string|null
     */
    public static function getFormatedXml($string, $asDomDocument = false)
    {
        return Utils::getFormatedXml($string, $asDomDocument);
    }
    /**
     * Returns an associative array between the headers name and their respective values
     * @param string $headers
     * @return string[]
     */
    public static function convertStringHeadersToArray($headers)
    {
        $lines = explode("\r\n", $headers);
        $headers = [];
        foreach ($lines as $line) {
            if (strpos($line, ':')) {
                $headerParts = explode(':', $line);
                $headers[$headerParts[0]] = trim(implode(':', array_slice($headerParts, 1)));
            }
        }
        return $headers;
    }
    /**
     * Sets a SoapHeader to send
     * For more information, please read the online documentation on {@link http://www.php.net/manual/en/class.soapheader.php}
     * @uses AbstractSoapClientBase::getSoapClient()
     * @uses SoapClient::__setSoapheaders()
     * @param string $nameSpace SoapHeader namespace
     * @param string $name SoapHeader name
     * @param mixed $data SoapHeader data
     * @param bool $mustUnderstand
     * @param string $actor
     * @return AbstractSoapClientBase
     */
    public function setSoapHeader($nameSpace, $name, $data, $mustUnderstand = false, $actor = null)
    {
        if (static::getSoapClient()) {
            $defaultHeaders = (isset(static::getSoapClient()->__default_headers) && is_array(static::getSoapClient()->__default_headers)) ? static::getSoapClient()->__default_headers : [];
            foreach ($defaultHeaders as $index => $soapHeader) {
                if ($soapHeader->name === $name) {
                    unset($defaultHeaders[$index]);
                    break;
                }
            }
            static::getSoapClient()->__setSoapheaders(null);
            if (!empty($actor)) {
                array_push($defaultHeaders, new \SoapHeader($nameSpace, $name, $data, $mustUnderstand, $actor));
            } else {
                array_push($defaultHeaders, new \SoapHeader($nameSpace, $name, $data, $mustUnderstand));
            }
            static::getSoapClient()->__setSoapheaders($defaultHeaders);
        }
        return $this;
    }
    /**
     * Sets the SoapClient Stream context HTTP Header name according to its value
     * If a context already exists, it tries to modify it
     * It the context does not exist, it then creates it with the header name and its value
     * @uses AbstractSoapClientBase::getSoapClient()
     * @param string $headerName
     * @param mixed $headerValue
     * @return bool
     */
    public function setHttpHeader($headerName, $headerValue)
    {
        $state = false;
        if (static::getSoapClient() && !empty($headerName)) {
            $streamContext = $this->getStreamContext();
            if ($streamContext === null) {
                $options = [];
                $options['http'] = [];
                $options['http']['header'] = '';
            } else {
                $options = stream_context_get_options($streamContext);
                if (!array_key_exists('http', $options) || !is_array($options['http'])) {
                    $options['http'] = [];
                    $options['http']['header'] = '';
                } elseif (!array_key_exists('header', $options['http'])) {
                    $options['http']['header'] = '';
                }
            }
            if (count($options) && array_key_exists('http', $options) && is_array($options['http']) && array_key_exists('header', $options['http']) && is_string($options['http']['header'])) {
                $lines = explode("\r\n", $options['http']['header']);
                /**
                 * Ensure there is only one header entry for this header name
                 */
                $newLines = [];
                foreach ($lines as $line) {
                    if (!empty($line) && strpos($line, $headerName) === false) {
                        array_push($newLines, $line);
                    }
                }
                /**
                 * Add new header entry
                 */
                array_push($newLines, "$headerName: $headerValue");
                /**
                 * Set the context http header option
                 */
                $options['http']['header'] = implode("\r\n", $newLines);
                /**
                 * Create context if it does not exist
                 */
                if ($streamContext === null) {
                    $state = (static::getSoapClient()->_stream_context = stream_context_create($options)) ? true : false;
                } else {
                    /**
                     * Set the new context http header option
                     */
                    $state = stream_context_set_option(static::getSoapClient()->_stream_context, 'http', 'header', $options['http']['header']);
                }
            }
        }
        return $state;
    }
    /**
     * Returns current \SoapClient::_stream_context resource or null
     * @return resource|null
     */
    public function getStreamContext()
    {
        return (static::getSoapClient() && isset(static::getSoapClient()->_stream_context) && is_resource(static::getSoapClient()->_stream_context)) ? static::getSoapClient()->_stream_context : null;
    }
    /**
     * Returns current \SoapClient::_stream_context resource options or empty array
     * @return array
     */
    public function getStreamContextOptions()
    {
        $options = [];
        $context = $this->getStreamContext();
        if ($context !== null) {
            $options = stream_context_get_options($context);
        }
        return $options;
    }
    /**
     * Method returning last errors occured during the calls
     * @return array
     */
    public function getLastError()
    {
        return $this->lastError;
    }
    /**
     * Method setting last errors occured during the calls
     * @param array $lastError
     * @return AbstractSoapClientBase
     */
    private function setLastError($lastError)
    {
        $this->lastError = $lastError;
        return $this;
    }
    /**
     * Method saving the last error returned by the SoapClient
     * @param string $methodName the method called when the error occurred
     * @param \SoapFault $soapFault l'objet de l'erreur
     * @return AbstractSoapClientBase
     */
    public function saveLastError($methodName, \SoapFault $soapFault)
    {
        $this->lastError[$methodName] = $soapFault;
        return $this;
    }
    /**
     * Method getting the last error for a certain method
     * @param string $methodName method name to get error from
     * @return \SoapFault|null
     */
    public function getLastErrorForMethod($methodName)
    {
        return array_key_exists($methodName, $this->lastError) ? $this->lastError[$methodName] : null;
    }
    /**
     * Method returning current result from Soap call
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }
    /**
     * Method setting current result from Soap call
     * @param mixed $result
     * @return AbstractSoapClientBase
     */
    public function setResult($result)
    {
        $this->result = $result;
        return $this;
    }
}
