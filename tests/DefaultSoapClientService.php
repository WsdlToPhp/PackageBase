<?php

declare(strict_types=1);

namespace WsdlToPhp\PackageBase\Tests;

use WsdlToPhp\PackageBase\AbstractSoapClientBase;

/**
 * By default all services extending the packagebase's
 * abstract class rely on PHP's default SoapClient.
 */

class DefaultSoapClientService extends AbstractSoapClientBase
{

}
