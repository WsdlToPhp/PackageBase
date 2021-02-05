# UPGRADE FROM 3.0 to 4.0

The previously `_set` and `_get` methods are to be used internally and are not intended to be used externally, at your own risks ;)

**Previously**:
```php
/** @var WsdlToPhp\PackageBase\AbstractStructBase|WsdlToPhp\PackageBase\AbstractStructArrayBase $o */
$o = new Struct();
$o->_set('name', 'the name');
$theName = $o->_get('name');
```

Same remark as previously, methods are renamed and marked as internal from now on ;)

**Now**:
```php
/** @var WsdlToPhp\PackageBase\AbstractStructBase|WsdlToPhp\PackageBase\AbstractStructArrayBase $o */
$o = new Struct();
$o->setPropertyValue('name', 'the name');
$theName = $o->getPropertyValue('name');
```
