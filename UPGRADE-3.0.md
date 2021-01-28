# UPGRADE FROM 2.0 to 3.0

The main change, apart from requiring PHP >= 7.4, is that `Utils` and `AbstractSoapClientBase` method `getFormatedXml` has been renamed to `getFormattedXml` (typo fix).

**Previously**:
```php
WsdlToPhp\PackageBase\Utils::getFormatedXml($xmlString);
WsdlToPhp\PackageBase\AbstractSoapClientBase::getFormatedXml($xmlString);
```

**Now**:
```php
WsdlToPhp\PackageBase\Utils::getFormattedXml($xmlString);
WsdlToPhp\PackageBase\AbstractSoapClientBase::getFormattedXml($xmlString);
```
