<?php

namespace WsdlToPhp\PackageBase;

class Utils
{
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
        if (!empty($string) && class_exists('DOMDocument')) {
            $dom = new \DOMDocument('1.0', 'UTF-8');
            $dom->formatOutput = true;
            $dom->preserveWhiteSpace = false;
            $dom->resolveExternals = false;
            $dom->substituteEntities = false;
            $dom->validateOnParse = false;
            try {
                if ($dom->loadXML($string)) {
                    return $asDomDocument ? $dom : $dom->saveXML();
                }
            } catch (\Exception $exception) {
                throw new \InvalidArgumentException(sprintf('XML string is invalid'), null, $exception);
            }
        }
        return $asDomDocument ? null : $string;
    }
}
