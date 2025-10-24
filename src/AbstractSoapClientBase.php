<?php

declare(strict_types=1);

namespace WsdlToPhp\PackageBase;

use DOMDocument;
use SoapClient;
use SoapFault;
use SoapHeader;

abstract class AbstractSoapClientBase implements SoapClientInterface
{
    /**
     * SoapClient called to communicate with the actual SOAP Service
     * @var SoapClient|null
     */
    private ?SoapClient $soapClient = null;

    /**
     * The SoapClient's stream context.
     * Stored separately since SoapClient->_stream_context is private in php 8.
     * @var resource|null
     */
    private $streamContext = null;

    /**
     * Contains Soap call result
     * @var mixed
     */
    private $result;

    /**
     * Contains last errors
     * @var array
     */
    private array $lastError = [];

    /**
     * Contains output headers
     * @var array
     */
    protected array $outputHeaders = [];

    public function __construct(array $wsdlOptions = [])
    {
        $this->initSoapClient($wsdlOptions);
    }

    public function getSoapClient(): ?SoapClient
    {
        return $this->soapClient;
    }

    public function initSoapClient(array $options): void
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

        foreach ($options as $optionName => $optionValue) {
            if (!array_key_exists($optionName, $defaultWsdlOptions) && !is_null($optionValue)) {
                $wsdlOptions[$optionName] = $optionValue;
            }
        }

        if (self::canInstantiateSoapClientWithOptions($wsdlOptions)) {
            $wsdlUrl = null;
            if (array_key_exists(str_replace(self::OPTION_PREFIX, '', self::WSDL_URL), $wsdlOptions)) {
                $wsdlUrl = $wsdlOptions[str_replace(self::OPTION_PREFIX, '', self::WSDL_URL)];
                unset($wsdlOptions[str_replace(self::OPTION_PREFIX, '', self::WSDL_URL)]);
            }

            if (!isset($wsdlOptions['stream_context'])){
                $this->streamContext = stream_context_create();
                $wsdlOptions['stream_context'] = $this->streamContext;

            }
            $soapClientClassName = $this->getSoapClientClassName();
            $this->soapClient = new $soapClientClassName($wsdlUrl, $wsdlOptions);
        }
    }

    /**
     * Checks if the provided options are sufficient to instantiate a SoapClient:
     *  - WSDL-mode : only the WSDL is required
     *  - non-WSDL-mode : URI and LOCATION are required, WSDL url can be empty then
     * @param array $wsdlOptions
     * @return bool
     */
    protected static function canInstantiateSoapClientWithOptions(array $wsdlOptions): bool
    {
        return (
            array_key_exists(str_replace(self::OPTION_PREFIX, '', self::WSDL_URL), $wsdlOptions) ||
            (
                array_key_exists(str_replace(self::OPTION_PREFIX, '', self::WSDL_URI), $wsdlOptions) &&
                array_key_exists(str_replace(self::OPTION_PREFIX, '', self::WSDL_LOCATION), $wsdlOptions)
            )
        );
    }

    /**
     * Returns the SoapClient class name to use to create the instance of the SoapClient.
     * Be sure that this class inherits from the native PHP SoapClient class and this class has been loaded or can be loaded.
     * The goal is to allow the override of the SoapClient without having to modify this generated class.
     * Then the overriding SoapClient class can override for example the SoapClient::__doRequest() method if it is needed.
     * @param string|null $soapClientClassName
     * @return string
     */
    public function getSoapClientClassName(?string $soapClientClassName = null): string
    {
        $className = static::DEFAULT_SOAP_CLIENT_CLASS;
        if (!empty($soapClientClassName) && is_subclass_of($soapClientClassName, SoapClient::class)) {
            $className = $soapClientClassName;
        }

        return $className;
    }

    /**
     * Method returning all default SoapClient options values
     * @return array
     */
    public static function getDefaultWsdlOptions(): array
    {
        return [
            self::WSDL_AUTHENTICATION => null,
            self::WSDL_CACHE_WSDL => WSDL_CACHE_NONE,
            self::WSDL_CLASSMAP => null,
            self::WSDL_COMPRESSION => null,
            self::WSDL_CONNECTION_TIMEOUT => null,
            self::WSDL_ENCODING => null,
            self::WSDL_EXCEPTIONS => true,
            self::WSDL_FEATURES => SOAP_SINGLE_ELEMENT_ARRAYS | SOAP_USE_XSI_ARRAY_TYPE,
            self::WSDL_LOCAL_CERT => null,
            self::WSDL_LOCATION => null,
            self::WSDL_LOGIN => null,
            self::WSDL_PASSPHRASE => null,
            self::WSDL_PASSWORD => null,
            self::WSDL_PROXY_HOST => null,
            self::WSDL_PROXY_LOGIN => null,
            self::WSDL_PROXY_PASSWORD => null,
            self::WSDL_PROXY_PORT => null,
            self::WSDL_SOAP_VERSION => null,
            self::WSDL_SSL_METHOD => null,
            self::WSDL_STREAM_CONTEXT => null,
            self::WSDL_STYLE => null,
            self::WSDL_TRACE => true,
            self::WSDL_TYPEMAP => null,
            self::WSDL_URL => null,
            self::WSDL_URI => null,
            self::WSDL_USE => null,
            self::WSDL_USER_AGENT => null,
        ];
    }

    /**
     * Allows to set the SoapClient location to call
     * @param string $location
     * @return AbstractSoapClientBase
     */
    public function setLocation(string $location): self
    {
        if ($this->getSoapClient() instanceof SoapClient) {
            $this->getSoapClient()->__setLocation($location);
        }

        return $this;
    }

    /**
     * Returns the last request content as a DOMDocument or as a formatted XML String
     * @param bool $asDomDocument
     * @return DOMDocument|string|null
     */
    public function getLastRequest(bool $asDomDocument = false)
    {
        return $this->getLastXml('__getLastRequest', $asDomDocument);
    }

    /**
     * Returns the last response content as a DOMDocument or as a formatted XML String
     * @param bool $asDomDocument
     * @return DOMDocument|string|null
     */
    public function getLastResponse(bool $asDomDocument = false)
    {
        return $this->getLastXml('__getLastResponse', $asDomDocument);
    }

    /**
     * @param string $method
     * @param bool $asDomDocument
     * @return DOMDocument|string|null
     */
    protected function getLastXml(string $method, bool $asDomDocument = false)
    {
        $xml = null;
        if ($this->getSoapClient() instanceof SoapClient) {
            $xml = static::getFormattedXml($this->getSoapClient()->$method(), $asDomDocument);
        }

        return $xml;
    }

    /**
     * Returns the last request headers used by the SoapClient object as the original value or an array
     * @param bool $asArray allows to get the headers in an associative array
     * @return null|string|string[]
     */
    public function getLastRequestHeaders(bool $asArray = false)
    {
        return $this->getLastHeaders('__getLastRequestHeaders', $asArray);
    }

    /**
     * Returns the last response headers used by the SoapClient object as the original value or an array
     * @param bool $asArray allows to get the headers in an associative array
     * @return null|string|string[]
     */
    public function getLastResponseHeaders(bool $asArray = false)
    {
        return $this->getLastHeaders('__getLastResponseHeaders', $asArray);
    }

    /**
     * @param string $method
     * @param bool $asArray allows to get the headers in an associative array
     * @return null|string|string[]
     */
    protected function getLastHeaders(string $method, bool $asArray)
    {
        $headers = $this->getSoapClient() instanceof SoapClient ? $this->getSoapClient()->$method() : null;
        if (is_string($headers) && $asArray) {
            return static::convertStringHeadersToArray($headers);
        }

        return $headers;
    }

    /**
     * Returns a XML string content as a DOMDocument or as a formatted XML string
     * @param string|null $string
     * @param bool $asDomDocument
     * @return DOMDocument|string|null
     */
    public static function getFormattedXml(?string $string, bool $asDomDocument = false)
    {
        return Utils::getFormattedXml($string, $asDomDocument);
    }

    /**
     * Returns an associative array between the headers name and their respective values
     * @param string $headers
     * @return string[]
     */
    public static function convertStringHeadersToArray(string $headers): array
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
     * @param string $namespace SoapHeader namespace
     * @param string $name SoapHeader name
     * @param mixed $data SoapHeader data
     * @param bool $mustUnderstand
     * @param string|null $actor
     * @return AbstractSoapClientBase
     */
    public function setSoapHeader(string $namespace, string $name, $data, bool $mustUnderstand = false, ?string $actor = null): self
    {
        if ($this->getSoapClient()) {
            $defaultHeaders = (isset($this->getSoapClient()->__default_headers) && is_array($this->getSoapClient()->__default_headers)) ? $this->getSoapClient()->__default_headers : [];
            foreach ($defaultHeaders as $index => $soapHeader) {
                if ($soapHeader->name === $name) {
                    unset($defaultHeaders[$index]);
                    break;
                }
            }
            $this->getSoapClient()->__setSoapheaders(null);
            if (!empty($actor)) {
                array_push($defaultHeaders, new SoapHeader($namespace, $name, $data, $mustUnderstand, $actor));
            } else {
                array_push($defaultHeaders, new SoapHeader($namespace, $name, $data, $mustUnderstand));
            }
            $this->getSoapClient()->__setSoapheaders($defaultHeaders);
        }

        return $this;
    }

    /**
     * Sets the SoapClient Stream context HTTP Header name according to its value
     * If a context already exists, it tries to modify it
     * It the context does not exist, it then creates it with the header name and its value
     * @param string $headerName
     * @param mixed $headerValue
     * @return bool
     */
    public function setHttpHeader(string $headerName, $headerValue): bool
    {
        $state = false;
        $streamContext = $this->getStreamContext();
        if ($this->getSoapClient() && $streamContext && !empty($headerName)) {
            $options = stream_context_get_options($streamContext);
            if (!array_key_exists('http', $options) || !is_array($options['http'])) {
                $options['http'] = [];
                $options['http']['header'] = '';
            } elseif (!array_key_exists('header', $options['http'])) {
                $options['http']['header'] = '';
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
                $state = stream_context_set_option($this->streamContext, 'http', 'header', $options['http']['header']);
            }
        }

        return $state;
    }

    /**
     * Returns current SoapClient::_stream_context resource or null
     * @return resource|null
     */
    public function getStreamContext()
    {
        return $this->streamContext;
    }

    /**
     * Returns current SoapClient::_stream_context resource options or empty array
     * @return array
     */
    public function getStreamContextOptions(): array
    {
        $options = [];
        $context = $this->getStreamContext();
        if ($context !== null) {
            $options = stream_context_get_options($context);
            if (isset($options['http']['header']) && is_string($options['http']['header'])) {
                $options['http']['header'] = array_filter(array_map('trim', explode(PHP_EOL, $options['http']['header'])));
            }
        }

        return $options;
    }

    /**
     * Method returning last errors occurred during the calls
     * @return array
     */
    public function getLastError(): array
    {
        return $this->lastError;
    }

    /**
     * Method saving the last error returned by the SoapClient
     * @param string $methodName the method called when the error occurred
     * @param SoapFault $soapFault the fault
     * @return AbstractSoapClientBase
     */
    public function saveLastError(string $methodName, SoapFault $soapFault): SoapClientInterface
    {
        $this->lastError[$methodName] = $soapFault;

        return $this;
    }

    /**
     * Method getting the last error for a certain method
     * @param string $methodName method name to get error from
     * @return SoapFault|null
     */
    public function getLastErrorForMethod(string $methodName): ?SoapFault
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
    public function setResult($result): SoapClientInterface
    {
        $this->result = $result;

        return $this;
    }

    /**
     * @return array
     */
    public function getOutputHeaders(): array
    {
        return $this->outputHeaders;
    }

    /**
     * Default string representation of current object. Don't want to expose any sensible data
     * @return string
     */
    public function __toString(): string
    {
        return get_called_class();
    }
}
