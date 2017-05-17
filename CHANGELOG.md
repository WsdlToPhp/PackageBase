# CHANGELOG

## 1.0.7
- Issue #3 - More than one SoapClient in Project

## 1.0.6
- Pull request #4: Rename $optioName to $optionName

## 1.0.5
- Update readme

## 1.0.4
- Issue #2 - Var name change request from $methoName to $methodName

## 1.0.3
- Add utility methods **getStreamContext()** and **getStreamContextOptions()** to AbstractSoapClientbase class

## 1.0.2
- Remove AbstractStructArrayBase::getAttributeName() method due to fatal error on PHP <= 5.3

## 1.0.1
- Interfaces' methods has been well declared as public
- Minor readme typo updates

## 1.0.0
- First major release, code coverage improved to reach 100% from the 1.0.0RC02 release.

## 1.0.0RC02
- Major: update source code structure, put all classes under ```src``` folder, rename Tests to tests, update composer and phpunit accordingly

## 1.0.0RC01
- Update Readme
- Define interfaces that must be used as interfaces in order to be able to define a usable top class for any generated ServiceType/StructType/ArrayType class by the [PackageGenerator](https://github.com/WsdlToPhp/PackageGenerator)

## 0.0.3
- Update dependency badge

## 0.0.2
- use top level namespace for SoapHeader class

## 0.0.1
- Initial version
