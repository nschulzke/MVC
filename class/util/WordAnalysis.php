<?php namespace util;

use \Wamania\Snowball\English;

class WordAnalysis
{
    static private $stemmer;
    
    const FILTER = [
        'the', 'and', 'of', 'to', 'that', 'in', 'unto', 'he',
        'i', 'shall', 'for', 'they', 'be', 'his', 'a', 'it', 'them',
        'not', 'is', 'all', 'him', 'with', 'my', 'which', 'their',
        'have', 'was', 'ye', 'thou', 'will', 'me', 'you', 'thy', 'but',
        'as', 'from', 'were', 'this', 'are', 'said', 'by', 'upon', 'thee',
        'had', 'came', 'when', 'out', 'behold', 'there',
        'up', 'also', 'come', 'your', 'we', 'did', 'hath', 'into',
        'now', 'who', 'on', 'if', 'one', 'things', 'even', 'before',
        'then', 'pass', 'against', 'day', 'these',
        'an', 'so', 'do', 'should', 'at', 'her', 'because', 'therefore', 'let',
        'no', 'our', 'go', 'say', 'us', 'may', 'or', 'after', 'shalt', 'yea',
        'among', 'every', 'went', 'down', 'according', 'many', 'over', 'o',
        'forth', 'again', 'away', 'thus', 'hast', 'been'
    ];
    
    public static function filterWords( &$array )
    {
        foreach ( $array as $key => $value ) {
            if ( in_array( $key, self::FILTER ) )
                unset( $array[$key] );
        }
    }
    
    public static function explodeWords( $text, $filter = false )
    {
        // Replace punctuation and extra spaces
        $text = preg_replace( '/[.,\/#!$%\^&\*\?;:{}=\-_`~()"]/', ' ', $text );
        $text = ' ' . $text . ' ';
        // Make it all lower case
        $text = strtolower( $text );
        if ( $filter ) {
            foreach ( self::FILTER as $word )
                $text = str_replace( ' ' . $word . ' ', ' ', $text );
        }
    
        // Remove extra spaces before explode
        $text = preg_replace( '/ +/', ' ', $text );
    
        $array = array_filter( explode( ' ', $text ), 'strlen' );
        
        return $array;
    }
    
    public static function stem( $word )
    {
        if ( !isset(self::$stemmer))
            self::$stemmer = new English();
        return self::$stemmer->stem($word);
    }
    
    public static function countWords( $text )
    {
        $allWords = self::explodeWords( $text );
        $words = [];
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
    
    public static function countWord( $needle, $haystack )
    {
        $array = self::countWords( $haystack );
    
        return isset( $array[$needle] ) ? $array[$needle] : 0;
    }
    
    private static function isNumber( $word )
    {
        if ( preg_match( '/^[0-9]/', $word ) == 1 )
            return true;
        else
            return false;
    }
}