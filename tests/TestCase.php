<?php

namespace WsdlToPhp\PackageBase\Tests;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @return string[]
     */
    public static function classMap()
    {
        return array(
            'AdultOption' => 'ApiEnumAdultOption',
            'ArrayOfDeepLink' => 'ApiStructArrayOfDeepLink',
            'ArrayOfError' => 'ApiStructArrayOfError',
            'ArrayOfImageResult' => 'ApiStructArrayOfImageResult',
            'ArrayOfInstantAnswerResult' => 'ApiStructArrayOfInstantAnswerResult',
            'ArrayOfMobileWebResult' => 'ApiStructArrayOfMobileWebResult',
            'ArrayOfMobileWebSearchOption' => 'ApiStructArrayOfMobileWebSearchOption',
            'ArrayOfNewsArticle' => 'ApiStructArrayOfNewsArticle',
            'ArrayOfNewsCollection' => 'ApiStructArrayOfNewsCollection',
            'ArrayOfNewsRelatedSearch' => 'ApiStructArrayOfNewsRelatedSearch',
            'ArrayOfNewsResult' => 'ApiStructArrayOfNewsResult',
            'ArrayOfRelatedSearchResult' => 'ApiStructArrayOfRelatedSearchResult',
            'ArrayOfSearchOption' => 'ApiStructArrayOfSearchOption',
            'ArrayOfSourceType' => 'ApiStructArrayOfSourceType',
            'ArrayOfSpellResult' => 'ApiStructArrayOfSpellResult',
            'ArrayOfString' => 'ApiStructArrayOfString',
            'ArrayOfVideoResult' => 'ApiStructArrayOfVideoResult',
            'ArrayOfWebResult' => 'ApiStructArrayOfWebResult',
            'ArrayOfWebSearchOption' => 'ApiStructArrayOfWebSearchOption',
            'ArrayOfWebSearchTag' => 'ApiStructArrayOfWebSearchTag',
            'DeepLink' => 'ApiStructDeepLink',
            'Error' => 'ApiStructError',
            'ImageRequest' => 'ApiStructImageRequest',
            'ImageResponse' => 'ApiStructImageResponse',
            'ImageResult' => 'ApiStructImageResult',
            'InstantAnswerResponse' => 'ApiStructInstantAnswerResponse',
            'InstantAnswerResult' => 'ApiStructInstantAnswerResult',
            'MobileWebRequest' => 'ApiStructMobileWebRequest',
            'MobileWebResponse' => 'ApiStructMobileWebResponse',
            'MobileWebResult' => 'ApiStructMobileWebResult',
            'MobileWebSearchOption' => 'ApiEnumMobileWebSearchOption',
            'NewsArticle' => 'ApiStructNewsArticle',
            'NewsCollection' => 'ApiStructNewsCollection',
            'NewsRelatedSearch' => 'ApiStructNewsRelatedSearch',
            'NewsRequest' => 'ApiStructNewsRequest',
            'NewsResponse' => 'ApiStructNewsResponse',
            'NewsResult' => 'ApiStructNewsResult',
            'NewsSortOption' => 'ApiEnumNewsSortOption',
            'PhonebookRequest' => 'ApiStructPhonebookRequest',
            'PhonebookSortOption' => 'ApiEnumPhonebookSortOption',
            'Query' => 'ApiStructQuery',
            'RelatedSearchResponse' => 'ApiStructRelatedSearchResponse',
            'RelatedSearchResult' => 'ApiStructRelatedSearchResult',
            'SearchOption' => 'ApiEnumSearchOption',
            'SearchRequest' => 'ApiStructSearchRequest',
            'SearchResponse' => 'ApiStructSearchResponse',
            'SourceType' => 'ApiEnumSourceType',
            'SpellResponse' => 'ApiStructSpellResponse',
            'SpellResult' => 'ApiStructSpellResult',
            'Thumbnail' => 'ApiStructThumbnail',
            'TranslationRequest' => 'ApiStructTranslationRequest',
            'VideoRequest' => 'ApiStructVideoRequest',
            'VideoResponse' => 'ApiStructVideoResponse',
            'VideoResult' => 'ApiStructVideoResult',
            'VideoSortOption' => 'ApiEnumVideoSortOption',
            'WebRequest' => 'ApiStructWebRequest',
            'WebResponse' => 'ApiStructWebResponse',
            'WebResult' => 'ApiStructWebResult',
            'WebSearchOption' => 'ApiEnumWebSearchOption',
            'WebSearchTag' => 'ApiStructWebSearchTag',
        );
    }
}
