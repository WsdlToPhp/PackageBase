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
        $dom = null;
        $formated = $string;
        if (!empty($string) && class_exists('DOMDocument')) {
            $dom = new \DOMDocument('1.0', 'UTF-8');
            $dom->formatOutput = true;
            $dom->preserveWhiteSpace = false;
            $dom->resolveExternals = false;
            $dom->substituteEntities = false;
            $dom->validateOnParse = false;
            try {
                if ($dom->loadXML($string)) {
                    $formated = $dom->saveXML();
                }
            } catch (\Exception $exception) {
                throw new \InvalidArgumentException('XML string is invalid', $exception->getCode(), $exception);
            }
        }
        return $asDomDocument ? $dom : $formated;
    }
}
