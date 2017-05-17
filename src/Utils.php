<?php

namespace WsdlToPhp\PackageBase;

class Utils
{
    /**
     * Returns a XML string content as a DOMDocument or as a formated XML string
     * @throws \InvalidArgumentException
     * @param string $string
     * @param bool $asDomDocument
     * @return \DOMDocument|null
     */
    public static function getFormatedXml($string, $asDomDocument = false)
    {
        $domDocument = self::getDOMDocument($string);
        return $asDomDocument ? $domDocument : $domDocument->saveXML();
    }
    /**
     * @param string $string
     * @throws \InvalidArgumentException
     * @return \DOMDocument
     */
    public static function getDOMDocument($string)
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;
        $dom->preserveWhiteSpace = false;
        $dom->resolveExternals = false;
        $dom->substituteEntities = false;
        $dom->validateOnParse = false;
        try {
            $dom->loadXML($string);
        } catch (\Exception $exception) {
            throw new \InvalidArgumentException('XML string is invalid', $exception->getCode(), $exception);
        }
        return $dom;
    }
}
