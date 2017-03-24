<?php

class WordAnalysis
{
    private static $filter = array(
        'the', 'and', 'of', 'to', 'that', 'in', 'unto', 'he', 'i', 'shall', 'for', 'they', 'be', 'his', 'a', 'it',
        'them', 'not', 'is', 'all', 'him', 'with', 'my', 'which', 'their', 'have', 'was', 'ye',

        'came', 'pass',
    );

    public static function filterWords( &$array )
    {
        foreach ( $array as $key => $value )
        {
            if (in_array($key, self::$filter))
                unset($array[$key]);
        }
    }

    public static function explodeWords( $text, $filter = true )
    {
        // Replace punctuation and extra spaces
        $text = preg_replace( '/[.,\/#!$%\^&\*\?;:{}=\-_`~()"]/', ' ', $text );
        // Replace apostrophes not in contractions
        $text = str_replace( "'s", '', $text );
        $text = str_replace( "' ", ' ', $text );
        $text = str_replace( " '", ' ', $text );
        // Make it all lower case
        $text = strtolower( $text );
        // Remove extra spaces before explode
        $text = preg_replace( '/ +/', ' ', $text );
        return array_filter( explode( ' ', $text ), 'strlen' );
    }

    public static function countWords( $text )
    {
        $allWords = self::explodeWords( $text );
        $words = array();
        foreach ( $allWords as $word ) {
            if ( $word != '' && !self::isNumber( $word ) ) {
                if ( array_key_exists( $word, $words ) )
                    $words[$word]++;
                else
                    $words[$word] = 1;
            }
        }
        return $words;
    }

    public static function countWord ( $needle, $haystack )
    {
        $array = self::countWords( $haystack );
        return isset($array[$needle]) ? $array[$needle] : 0;
    }

    private static function isNumber( $word )
    {
        if ( preg_match( '/^[0-9]/', $word ) == 1 )
            return true;
        else
            return false;
    }
}