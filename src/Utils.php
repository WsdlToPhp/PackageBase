<?php

declare(strict_types=1);

namespace WsdlToPhp\PackageBase;

use DOMDocument;
use Exception;
use InvalidArgumentException;
use ValueError;

class Utils
{
    /**
     * Returns a XML string content as a DOMDocument or as a formated XML string
     * @throws InvalidArgumentException
     * @param string|null $string
     * @param bool $asDomDocument
     * @return DOMDocument|string|null
     */
    public static function getFormattedXml(?string $string, bool $asDomDocument = false)
    {
        if (!is_null($string)) {
            $domDocument = self::getDOMDocument($string);

            return $asDomDocument ? $domDocument : $domDocument->saveXML();
        }

        return null;
    }

    /**
     * @param string $string
     * @return DOMDocument
     * @throws InvalidArgumentException|ValueError
     */
    public static function getDOMDocument(string $string): DOMDocument
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;
        $dom->preserveWhiteSpace = false;
        $dom->resolveExternals = false;
        $dom->substituteEntities = false;
        $dom->validateOnParse = false;

        try {
            $dom->loadXML($string);
        } catch (Exception $exception) {
            throw new InvalidArgumentException('XML string is invalid', $exception->getCode(), $exception);
        }

        return $dom;
    }
}
