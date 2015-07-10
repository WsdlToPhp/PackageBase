<?php

namespace WsdlToPhp\PackageBase;

abstract class AbstractSoapClientBase
{
    /**
     * @var string
     */
    const DEFAULT_SOAP_CLIENT_CLASS = '\SoapClient';
    /**
     * @var string
     */
    const OPTION_PREFIX = 'wsdl_';
    /**
     * Option key to define WSDL url
     * @var string
     */
    const WSDL_URL = 'wsdl_url';
    /**
     * Option key to define WSDL classmap
     * @var string
     */
    const WSDL_CLASSMAP = 'wsdl_classmap';
    /**
     * Option key to define WSDL login
     * @var string
     */
    const WSDL_LOGIN = 'wsdl_login';
    /**
     * Option key to define WSDL password
     * @var string
     */
    const WSDL_PASSWORD = 'wsdl_password';
    /**
     * Option key to define WSDL trace option
     * @var string
     */
    const WSDL_TRACE = 'wsdl_trace';
    /**
     * Option key to define WSDL exceptions
     * @var string
     */
    const WSDL_EXCEPTIONS = 'wsdl_exceptions';
    /**
     * Option key to define WSDL cache_wsdl
     * @var string
     */
    const WSDL_CACHE_WSDL = 'wsdl_cache_wsdl';
    /**
     * Option key to define WSDL stream_context
     * @var string
     */
    const WSDL_STREAM_CONTEXT = 'wsdl_stream_context';
    /**
     * Option key to define WSDL soap_version
     * @var string
     */
    const WSDL_SOAP_VERSION = 'wsdl_soap_version';
    /**
     * Option key to define WSDL compression
     * @var string
     */
    const WSDL_COMPRESSION = 'wsdl_compression';
    /**
     * Option key to define WSDL encoding
     * @var string
     */
    const WSDL_ENCODING = 'wsdl_encoding';
    /**
     * Option key to define WSDL connection_timeout
     * @var string
     */
    const WSDL_CONNECTION_TIMEOUT = 'wsdl_connection_timeout';
    /**
     * Option key to define WSDL typemap
     * @var string
     */
    const WSDL_TYPEMAP = 'wsdl_typemap';
    /**
     * Option key to define WSDL user_agent
     * @var string
     */
    const WSDL_USER_AGENT = 'wsdl_user_agent';
    /**
     * Option key to define WSDL features
     * @var string
     */
    const WSDL_FEATURES = 'wsdl_features';
    /**
     * Option key to define WSDL keep_alive
     * @var string
     */
    const WSDL_KEEP_ALIVE = 'wsdl_keep_alive';
    /**
     * Option key to define WSDL proxy_host
     * @var string
     */
    const WSDL_PROXY_HOST = 'wsdl_proxy_host';
    /**
     * Option key to define WSDL proxy_port
     * @var string
     */
    const WSDL_PROXY_PORT = 'wsdl_proxy_port';
    /**
     * Option key to define WSDL proxy_login
     * @var string
     */
    const WSDL_PROXY_LOGIN = 'wsdl_proxy_login';
    /**
     * Option key to define WSDL proxy_password
     * @var string
     */
    const WSDL_PROXY_PASSWORD = 'wsdl_proxy_password';
    /**
     * Option key to define WSDL local_cert
     * @var string
     */
    const WSDL_LOCAL_CERT = 'wsdl_local_cert';
    /**
     * Option key to define WSDL passphrase
     * @var string
     */
    const WSDL_PASSPHRASE = 'wsdl_passphrase';
    /**
     * Option key to define WSDL authentication
     * @var string
     */
    const WSDL_AUTHENTICATION = 'wsdl_authentication';
    /**
     * Option key to define WSDL ssl_method
     * @var string
     */
    const WSDL_SSL_METHOD = 'wsdl_ssl_method';
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
    public function __construct(array $wsdlOptions = array(), $resetSoapClient = true)
    {
        $this->setLastError(array());
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
        $wsdlOptions = array();
        $defaultWsdlOptions = self::getDefaultWsdlOptions();
        foreach ($defaultWsdlOptions as $optioName=>$optionValue) {
            if (array_key_exists($optioName, $options) && !empty($options[$optioName])) {
                $wsdlOptions[str_replace(self::OPTION_PREFIX, '', $optioName)] = $options[$optioName];
            } elseif (!empty($optionValue)) {
                $wsdlOptions[str_replace(self::OPTION_PREFIX, '', $optioName)] = $optionValue;
            }
        }
        if (array_key_exists(str_replace(self::OPTION_PREFIX, '', self::WSDL_URL), $wsdlOptions)) {
            $wsdlUrl = $wsdlOptions[str_replace(self::OPTION_PREFIX, '', self::WSDL_URL)];
            unset($wsdlOptions[str_replace(self::OPTION_PREFIX, '', self::WSDL_URL)]);
            $soapClientClassName = $this->getSoapClientClassName();
            self::setSoapClient(new $soapClientClassName($wsdlUrl, $wsdlOptions));
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
        return array(
                    self::WSDL_CLASSMAP => null,
                    self::WSDL_CACHE_WSDL => WSDL_CACHE_NONE,
                    self::WSDL_COMPRESSION => null,
                    self::WSDL_CONNECTION_TIMEOUT => null,
                    self::WSDL_ENCODING => null,
                    self::WSDL_EXCEPTIONS => true,
                    self::WSDL_FEATURES => SOAP_SINGLE_ELEMENT_ARRAYS | SOAP_USE_XSI_ARRAY_TYPE,
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
                    self::WSDL_SSL_METHOD => null);
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
        if (self::getSoapClient() instanceof \SoapClient) {
            self::getSoapClient()->__setLocation($location);
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
        if (self::getSoapClient() instanceof \SoapClient) {
            $xml = self::getFormatedXml(self::getSoapClient()->$method(), $asDomDocument);
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
        $headers = self::getSoapClient() instanceof \SoapClient ? self::getSoapClient()->$method() : null;
        if (is_string($headers) && $asArray) {
            return self::convertStringHeadersToArray($headers);
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
        $headers = array();
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
        if (self::getSoapClient()) {
            $defaultHeaders = (isset(self::getSoapClient()->__default_headers) && is_array(self::getSoapClient()->__default_headers)) ? self::getSoapClient()->__default_headers : array();
            foreach ($defaultHeaders as $index=>$soapheader) {
                if ($soapheader->name === $name) {
                    unset($defaultHeaders[$index]);
                    break;
                }
            }
            self::getSoapClient()->__setSoapheaders(null);
            if (!empty($actor)) {
                array_push($defaultHeaders, new SoapHeader($nameSpace, $name, $data, $mustUnderstand, $actor));
            } else {
                array_push($defaultHeaders, new SoapHeader($nameSpace, $name, $data, $mustUnderstand));
            }
            self::getSoapClient()->__setSoapheaders($defaultHeaders);
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
        if (self::getSoapClient() && !empty($headerName)) {
            $streamContext = (isset(self::getSoapClient()->_stream_context) && is_resource(self::getSoapClient()->_stream_context)) ? self::getSoapClient()->_stream_context : null;
            if (!is_resource($streamContext)) {
                $options = array();
                $options['http'] = array();
                $options['http']['header'] = '';
            } else {
                $options = stream_context_get_options($streamContext);
                if (is_array($options)) {
                    if (!array_key_exists('http', $options) || !is_array($options['http'])) {
                        $options['http'] = array();
                        $options['http']['header'] = '';
                    } elseif (!array_key_exists('header', $options['http'])) {
                        $options['http']['header'] = '';
                    }
                } else {
                    $options = array();
                    $options['http'] = array();
                    $options['http']['header'] = '';
                }
            }
            if (count($options) && array_key_exists('http', $options) && is_array($options['http']) && array_key_exists('header', $options['http']) && is_string($options['http']['header'])) {
                $lines = explode("\r\n", $options['http']['header']);
                /**
                 * Ensure there is only one header entry for this header name
                 */
                $newLines = array();
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
                if (!is_resource($streamContext)) {
                    return (self::getSoapClient()->_stream_context = stream_context_create($options)) ? true : false;
                } else {
                    /**
                     * Set the new context http header option
                     */
                    return stream_context_set_option(self::getSoapClient()->_stream_context, 'http', 'header', $options['http']['header']);
                }
            }
            return false;
        }
        return false;
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
     * @param string $methoName the method called when the error occurred
     * @param \SoapFault $soapFault l'objet de l'erreur
     * @return AbstractSoapClientBase
     */
    protected function saveLastError($methoName, \SoapFault $soapFault)
    {
        $this->lastError[$methoName] = $soapFault;
        return $this;
    }
    /**
     * Method getting the last error for a certain method
     * @param string $methoName method name to get error from
     * @return \SoapFault|null
     */
    public function getLastErrorForMethod($methoName)
    {
        return array_key_exists($methoName, $this->lastError) ? $this->lastError[$methoName] : null;
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
    protected function setResult($result)
    {
        $this->result = $result;
        return $this;
    }
}
