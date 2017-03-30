<?php namespace model;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;
use model\orm\entity\Book;
use model\orm\entity\Chapter;
use model\orm\entity\Verse;
use model\orm\ORM;

class MScripture
{
    private static $volumesRepo;
    private static $booksRepo;
    private static $chaptersRepo;
    private static $versesRepo;

    /**
     * @return EntityRepository The repository of volumes
     */
    public static function getVolumesRepo()
    {
        if ( !isset( $volumesRepo ) )
            self::$volumesRepo = ORM::getManager()->getRepository( 'entity:Volumes' );

        return self::$volumesRepo;
    }

    /**
     * @return EntityRepository The repository of books
     */
    public static function getBookRepo()
    {
        if ( !isset( $booksRepo ) )
            self::$booksRepo = ORM::getManager()->getRepository( 'entity:Book' );

        return self::$booksRepo;
    }

    /**
     * @return EntityRepository The repository of chapters
     */
    public static function getChapterRepo()
    {
        if ( !isset( $chaptersRepo ) )
            self::$chaptersRepo = ORM::getManager()->getRepository( 'entity:Chapter' );

        return self::$chaptersRepo;
    }

    /**
     * @return EntityRepository The repository of verses
     */
    public static function getVerseRepo()
    {
        if ( !isset( $versesRepo ) )
            self::$versesRepo = ORM::getManager()->getRepository( 'entity:Verse' );

        return self::$versesRepo;
    }

    public static function explodeVerses( $verseString )
    {
        return self::explodeRanges(explode( ',', $verseString ));
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
        $criteria = Criteria::create();
        $criteria->where( Criteria::expr()->contains( 'ldsUrl', $bookName ) );
        $books = self::getBookRepo()->matching( $criteria );
        if ( $books->count() > 0 )
            return $books->get( 0 );

        $criteria = Criteria::create();
        $criteria->where(
            Criteria::expr()->orX(
                Criteria::expr()->contains( 'title', $bookName ),
                Criteria::expr()->contains( 'longTitle', $bookName ),
                Criteria::expr()->contains( 'shortTitle', $bookName ),
                Criteria::expr()->contains( 'ldsUrl', $bookName )
            )
        );
        $books = self::getBookRepo()->matching( $criteria );
        if ( $books->count() > 0 )
            return $books->get( 0 );
        else
            return null;
    }

    private $book;
    private $chapter;
    private $verses = [];

    /**
     * MScripture constructor.
     *
     * @param string|Book  $book
     * @param              $chapterNum
     * @param array        $verseNums Array of verses, ranges are acceptable
     */
    public function __construct( $book, $chapterNum, $verseNums = [] )
    {
        if ( is_object( $book ) && get_class( $book ) == 'model\orm\entity\Book' )
            $this->book = $book;
        else
            $this->book = self::findBook( $book );

        $this->chapter = self::getChapterRepo()->findOneBy( [ 'bookId' => $this->book->getId(), 'number' => $chapterNum ] );

        if ( is_numeric( $verseNums ) )
            $this->verses = [ self::getVerseRepo()->findOneBy( [ 'chapterId' => $this->chapter->getId(), 'number' => $verseNums ] ) ];
        else {
            $verseNums = self::explodeRanges( $verseNums );
            $verses = self::getVerseRepo()->findBy( [ 'chapterId' => $this->chapter->getId() ] );
            if ( isset( $verseNums ) && sizeof( $verseNums ) > 0 ) {
                if ( isset( $verseNums['start'] ) && isset( $verseNums['end'] ) ) {
                    foreach ( $verses as $verse ) /* @var Verse $verse */
                        if ( $verse->getNumber() >= $verseNums['start'] && $verse->getNumber() <= $verseNums['end'] )
                            $this->verses[$verse->getNumber()] = $verse;
                } else {
                    foreach ( $verses as $verse ) /* @var Verse $verse */
                        if ( in_array( $verse->getNumber(), $verseNums ) )
                            $this->verses[$verse->getNumber()] = $verse;
                }
            } else {
                foreach ( $verses as $verse ) /* @var Verse $verse */
                    $this->verses[$verse->getNumber()] = $verse;
            }
        }
    }

    /**
     * @return array An array mapped verseNum => verseText
     */
    public function getText()
    {
        $retArr = [];
        foreach ( $this->verses as $verse ) /* @var Verse $verse */
            $retArr[$verse->getNumber()] = $verse->getText();

        return $retArr;
    }

    /**
     * @return Verse[] The objects for each verse stored
     */
    public function getVerses()
    {
        return $this->verses;
    }

    /**
     * @param bool $long Whether to use the long title or the short title
     *
     * @return string The title of the book
     */
    public function getBookTitle( $long = false )
    {
        if ( $long )
            return $this->book->getLongTitle();
        else
            return $this->book->getShortTitle();
    }

    /**
     * @return Book The Book object for the scripture
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * @return integer The number of the chapter
     */
    public function getChapterNumber()
    {
        return $this->chapter->getNumber();
    }

    /**
     * @return object|Chapter The Chapter object for the scripture
     */
    public function getChapter()
    {
        return $this->chapter;
    }
}