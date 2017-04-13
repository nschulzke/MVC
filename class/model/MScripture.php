<?php namespace model;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;
use model\orm\entity\Book;
use model\orm\entity\Chapter;
use model\orm\entity\Verse;
use model\orm\entity\Volume;
use model\orm\ORM;

class MScripture
{
    private static $volumeRepo;
    private static $bookRepo;
    private static $chapterRepo;
    private static $verseRepo;
    
    /**
     * @return EntityRepository The repository of volumes
     */
    public static function getVolumeRepo()
    {
        if ( !isset( self::$volumeRepo ) )
            self::$volumeRepo = ORM::getManager()->getRepository( 'entity:Volume' );
        
        return self::$volumeRepo;
    }
    
    /**
     * @return EntityRepository The repository of books
     */
    public static function getBookRepo()
    {
        if ( !isset( self::$bookRepo ) )
            self::$bookRepo = ORM::getManager()->getRepository( 'entity:Book' );
        
        return self::$bookRepo;
    }
    
    /**
     * @return EntityRepository The repository of chapters
     */
    public static function getChapterRepo()
    {
        if ( !isset( self::$chapterRepo ) )
            self::$chapterRepo = ORM::getManager()->getRepository( 'entity:Chapter' );
        
        return self::$chapterRepo;
    }
    
    /**
     * @return EntityRepository The repository of verses
     */
    public static function getVerseRepo()
    {
        if ( !isset( self::$verseRepo ) )
            self::$verseRepo = ORM::getManager()->getRepository( 'entity:Verse' );
        
        return self::$verseRepo;
    }
    
    /**
     * @param string $verseString A string of the format "#-#,#-#"
     *
     * @return array An array in which each number appears as its own entry, including ranges split.
     */
    public static function explodeVerses( $verseString )
    {
        if ( is_array( $verseString ) )
            return self::explodeRanges( $verseString );
        else
            return self::explodeRanges( explode( ',', $verseString ) );
    }
    
    /**
     * @param array $verseNums Array of integers in one of these formats: '#', '#-#'
     *
     * @return array The same array, with ranges filled in. So, 1-3 would output [1, 2, 3]
     */
    public static function explodeRanges( $verseNums )
    {
        for ( $i = 0; $i < sizeof( $verseNums ); $i++ ) {
            if ( strpos( $verseNums[$i], '-' ) != false ) {
                $range = explode( '-', $verseNums[$i] );
                unset ( $verseNums[$i] );
                for ( $j = $range[0]; $j <= $range[1]; $j++ )
                    $verseNums[] = $j;
            }
        }
        
        return $verseNums;
    }
    
    /**
     * @param string $bookName The name of the book, either the title, abbreviation, or ldsUrl
     *
     * @return Book|null|object The Book object (if found), else null
     */
    public static function findBook( $bookName )
    {
        if ( is_numeric( $bookName ) )
            return self::getBookRepo()->find( $bookName );
        
        $criteria = Criteria::create()->where( Criteria::expr()->contains( 'ldsUrl', $bookName ) );
        $books = self::getBookRepo()->matching( $criteria );
        if ( $books->count() > 0 )
            return $books->get( 0 );
        
        $criteria = Criteria::create()->where(
            Criteria::expr()->orX(
                Criteria::expr()->contains( 'title', $bookName ),
                Criteria::expr()->contains( 'longTitle', $bookName ),
                Criteria::expr()->contains( 'shortTitle', $bookName )
            )
        );
        $books = self::getBookRepo()->matching( $criteria );
        if ( $books->count() > 0 )
            return $books->get( 0 );
        
        return null;
    }
    
    /**
     * @param string $ldsUrl The abbreviated URL for the volume
     *
     * @return Volume|null|object The Volume object if found, else null
     */
    public static function findVolume( $ldsUrl )
    {
        return self::getVolumeRepo()->findOneBy( [ 'ldsUrl' => $ldsUrl ] );
    }
    
    /**
     * @param Book | string $book
     * @param Chapter | int $chapter
     * @param array         $verseNums
     *
     * @return MScripture
     */
    public static function lookup( $book, $chapter, $verseNums = [] )
    {
        if ( !is_object( $book ) || !get_class( $book ) == 'model\orm\entity\Book' )
            $book = self::findBook( $book );
        if ( !is_object( $chapter ) || !get_class( $chapter ) == 'model\orm\entity\Chapter' )
            $chapter = $book->findChapter( $chapter );
        
        if ( empty( $book ) || empty( $chapter ) )
            return null;
        
        if ( is_numeric( $verseNums ) )
            $verses = [ $chapter->findVerse( $verseNums ) ];
        else {
            $verseNums = self::explodeVerses( $verseNums );
            $allVerses = $chapter->getVerses();
            /* @var Verse[] $verses */
            if ( !empty( $verseNums ) ) {
                foreach ( $allVerses as $verse )
                    if ( in_array( $verse->getNumber(), $verseNums ) )
                        $verses[] = $verse;
            } else {
                foreach ( $allVerses as $verse )
                    $verses[] = $verse;
            }
        }
        $verses = array_filter( $verses );
        if ( !empty( $verses ) )
            return new MScripture( $verses );
        else
            return null;
    }
    
    private $verses;
    
    /**
     * MScripture constructor.
     *
     * @param Verse[] $verses
     */
    public function __construct( $verses )
    {
        $this->verses = $verses;
    }
    
    /**
     * @return Verse[] The objects for each verse stored
     */
    public function getVerses()
    {
        return $this->verses;
    }
    
    /**
     * @return Book The Book object for the scripture
     */
    public function getBook()
    {
        return $this->verses[0]->getChapter()->getBook();
    }
    
    /**
     * @return Chapter The Chapter object for the scripture
     */
    public function getChapter()
    {
        return $this->verses[0]->getChapter();
    }
    
    /**
     * @return string The reference string for the scripture
     */
    public function getReference()
    {
        $book = $this->getBook()->getShortTitle();
        $chapter = $this->getChapter()->getNumber();
        $versesArr = [];
        foreach ( $this->getVerses() as $verse ) {
            $versesArr[] = $verse->getNumber();
        }
        $rangesArr = [];
        $start = -1;
        $end = -1;
        foreach ( $versesArr as $verse ) {
            if ( $verse == ( $end + 1 ) ) {
                $end = $verse;
            } else if ( $start == -1 ) {
                $start = $verse;
                $end = $verse;
            } else {
                if ( $start != $end ) {
                    $rangesArr[] = $start . '-' . $end;
                } else {
                    $rangesArr[] = $start;
                }
                $start = $verse;
                $end = $verse;
            }
        }
        if ( $start != -1 )
        {
            if ( $start != $end ) {
                $rangesArr[] = $start . '-' . $end;
            } else {
                $rangesArr[] = $start;
            }
        }
        
        $verses = implode( ',', $rangesArr );
        
        return $book . ' ' . $chapter . ':' . $verses;
    }
}