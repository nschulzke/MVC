<?php namespace model;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;
use model\orm\entity\Books;
use model\orm\entity\Chapters;
use model\orm\entity\Verses;
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
    public static function getBooksRepo()
    {
        if ( !isset( $booksRepo ) )
            self::$booksRepo = ORM::getManager()->getRepository( 'entity:Books' );

        return self::$booksRepo;
    }

    /**
     * @return EntityRepository The repository of chapters
     */
    public static function getChaptersRepo()
    {
        if ( !isset( $chaptersRepo ) )
            self::$chaptersRepo = ORM::getManager()->getRepository( 'entity:Chapters' );

        return self::$chaptersRepo;
    }

    /**
     * @return EntityRepository The repository of verses
     */
    public static function getVersesRepo()
    {
        if ( !isset( $versesRepo ) )
            self::$versesRepo = ORM::getManager()->getRepository( 'entity:Verses' );

        return self::$versesRepo;
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
     * @return Books|null|object The Book object (if found), else null
     */
    public static function findBook( $bookName )
    {
        if ( is_numeric( $bookName ) )
            return self::getBooksRepo()->find( $bookName );
        $criteria = Criteria::create();
        $criteria->where(
            Criteria::expr()->orX(
                Criteria::expr()->contains( 'title', $bookName ),
                Criteria::expr()->contains( 'longTitle', $bookName ),
                Criteria::expr()->contains( 'shortTitle', $bookName ),
                Criteria::expr()->contains( 'ldsUrl', $bookName )
            )
        );
        $books = self::getBooksRepo()->matching( $criteria );
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
     * @param       $bookName
     * @param       $chapterNum
     * @param array $verseNums Array of verses, ranges are acceptable
     */
    public function __construct( $bookName, $chapterNum, $verseNums = [] )
    {
        $this->book = self::findBook( $bookName );

        $this->chapter = self::getChaptersRepo()->findOneBy( [ 'bookId' => $this->book->getId(), 'number' => $chapterNum ] );

        if ( is_numeric( $verseNums ) )
            $this->verses = [ self::getVersesRepo()->findOneBy( [ 'chapterId' => $this->chapter->getId(), 'number' => $verseNums ] ) ];
        else {
            $verseNums = self::explodeRanges( $verseNums );
            $verses = self::getVersesRepo()->findBy( [ 'chapterId' => $this->chapter->getId() ] );
            if ( isset( $verseNums ) && sizeof( $verseNums ) > 0 ) {
                if ( isset( $verseNums['start'] ) && isset( $verseNums['end'] ) ) {
                    foreach ( $verses as $verse ) /* @var Verses $verse */
                        if ( $verse->getNumber() >= $verseNums['start'] && $verse->getNumber() <= $verseNums['end'] )
                            $this->verses[$verse->getNumber()] = $verse;
                } else {
                    foreach ( $verses as $verse ) /* @var Verses $verse */
                        if ( in_array( $verse->getNumber(), $verseNums ) )
                            $this->verses[$verse->getNumber()] = $verse;
                }
            } else {
                foreach ( $verses as $verse ) /* @var Verses $verse */
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
        foreach ( $this->verses as $verse ) /* @var Verses $verse */
            $retArr[$verse->getNumber()] = $verse->getText();

        return $retArr;
    }

    /**
     * @return Verses[] The objects for each verse stored
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
     * @return Books The Books object for the scripture
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
     * @return object|Chapters The Chapters object for the scripture
     */
    public function getChapter()
    {
        return $this->chapter;
    }
}