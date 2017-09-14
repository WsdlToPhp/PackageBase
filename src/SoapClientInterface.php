<?php

namespace WsdlToPhp\PackageBase;

interface SoapClientInterface
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
     * Option key to define WSDL authentication
     * @var string
     */
    const WSDL_AUTHENTICATION = 'wsdl_authentication';
    /**
     * Option key to define WSDL cache_wsdl
     * @var string
     */
    const WSDL_CACHE_WSDL = 'wsdl_cache_wsdl';
    /**
     * Option key to define WSDL classmap
     * @var string
     */
    const WSDL_CLASSMAP = 'wsdl_classmap';
    /**
     * Option key to define WSDL compression
     * @var string
     */
    const WSDL_COMPRESSION = 'wsdl_compression';
    /**
     * Option key to define WSDL connection_timeout
     * @var string
     */
    const WSDL_CONNECTION_TIMEOUT = 'wsdl_connection_timeout';
    /**
     * Option key to define WSDL encoding
     * @var string
     */
    const WSDL_ENCODING = 'wsdl_encoding';
    /**
     * Option key to define WSDL exceptions
     * @var string
     */
    const WSDL_EXCEPTIONS = 'wsdl_exceptions';
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
     * Option key to define WSDL local_cert
     * @var string
     */
    const WSDL_LOCAL_CERT = 'wsdl_local_cert';
    /**
     * Option key to define WSDL location
     * @var string
     */
    const WSDL_LOCATION = 'wsdl_location';
    /**
     * Option key to define WSDL login
     * @var string
     */
    const WSDL_LOGIN = 'wsdl_login';
    /**
     * Option key to define WSDL passphrase
     * @var string
     */
    const WSDL_PASSPHRASE = 'wsdl_passphrase';
    /**
     * Option key to define WSDL password
     * @var string
     */
    const WSDL_PASSWORD = 'wsdl_password';
    /**
     * Option key to define WSDL proxy_host
     * @var string
     */
    const WSDL_PROXY_HOST = 'wsdl_proxy_host';
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
     * Option key to define WSDL proxy_port
     * @var string
     */
    const WSDL_PROXY_PORT = 'wsdl_proxy_port';
    /**
     * Option key to define WSDL soap_version
     * @var string
     */
    const WSDL_SOAP_VERSION = 'wsdl_soap_version';
    /**
     * Option key to define WSDL ssl_method
     * @var string
     */
    const WSDL_SSL_METHOD = 'wsdl_ssl_method';
    /**
     * Option key to define WSDL stream_context
     * @var string
     */
    const WSDL_STREAM_CONTEXT = 'wsdl_stream_context';
    /**
     * Option key to define WSDL trace option
     * @var string
     */
    const WSDL_TRACE = 'wsdl_trace';
    /**
     * Option key to define WSDL typemap
     * @var string
     */
    const WSDL_TYPEMAP = 'wsdl_typemap';
    /**
     * Option key to define WSDL url
     * @var string
     */
    const WSDL_URL = 'wsdl_url';
    /**
     * Option key to define WSDL user_agent
     * @var string
     */
    const WSDL_USER_AGENT = 'wsdl_user_agent';
    /**
     * Constructor
     * @uses SoapClientInterface::setLastError()
     * @uses SoapClientInterface::initSoapClient()
     * @param array $wsdlOptions
     * @param bool $resetSoapClient allows to disable the SoapClient redefinition
     */
    public function __construct(array $wsdlOptions = [], $resetSoapClient = true);
    /**
     * Static method getting current SoapClient
     * @return \SoapClient
     */
    public static function getSoapClient();
    /**
     * Sets a SoapHeader to send
     * For more information, please read the online documentation on {@link http://www.php.net/manual/en/class.soapheader.php}
     * @param string $nameSpace SoapHeader namespace
     * @param string $name SoapHeader name
     * @param mixed $data SoapHeader data
     * @param bool $mustUnderstand
     * @param string $actor
     * @return SoapClientInterface
     */
    public function setSoapHeader($nameSpace, $name, $data, $mustUnderstand = false, $actor = null);
    /**
     * Method returning last errors occured during the calls
     * @return array
     */
    public function getLastError();
    /**
     * Method saving the last error returned by the SoapClient
     * @param string $methodName the method called when the error occurred
     * @param \SoapFault $soapFault l'objet de l'erreur
     * @return SoapClientInterface
     */
    public function saveLastError($methodName, \SoapFault $soapFault);
    /**
     * Method returning current result from Soap call
     * @return mixed
     */
    public function getResult();
    /**
     * Method setting current result from Soap call
     * @param mixed $result
     * @return SoapClientInterface
     */
    public function setResult($result);
}
