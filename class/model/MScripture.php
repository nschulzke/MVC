<?php namespace model;

use Doctrine\Common\Collections\Criteria;
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
     * @return \Doctrine\ORM\EntityRepository
     */
    public static function getVolumesRepo()
    {
        if ( !isset( $volumesRepo ) )
            self::$volumesRepo = ORM::getManager()->getRepository( 'entity:Volumes' );
        return self::$volumesRepo;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public static function getBooksRepo()
    {
        if ( !isset( $booksRepo ) )
            self::$booksRepo = ORM::getManager()->getRepository( 'entity:Books' );
        return self::$booksRepo;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public static function getChaptersRepo()
    {
        if ( !isset( $chaptersRepo ) )
            self::$chaptersRepo = ORM::getManager()->getRepository( 'entity:Chapters' );
        return self::$chaptersRepo;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public static function getVersesRepo()
    {
        if ( !isset( $versesRepo ) )
            self::$versesRepo = ORM::getManager()->getRepository( 'entity:Verses' );
        return self::$versesRepo;
    }

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
     * @param $bookName
     * @return Books|null|object
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
    /* @var Books $book */
    private $chapter;
    /* @var Chapters $chapter */
    private $verses = array();

    /**
     * MScripture constructor.
     * @param       $bookName
     * @param       $chapterNum
     * @param array $verseNums
     */
    public function __construct( $bookName, $chapterNum, $verseNums = array() )
    {
        $this->book = self::findBook( $bookName );

        $this->chapter = self::getChaptersRepo()->findOneBy( array( 'bookId' => $this->book->getId(), 'number' => $chapterNum ) );

        if ( is_numeric( $verseNums ) )
            $this->verses = array( self::getVersesRepo()->findOneBy( array( 'chapterId' => $this->chapter->getId(), 'number' => $verseNums ) ) );
        else {
            $verseNums = self::explodeRanges( $verseNums );
            $verses = self::getVersesRepo()->findBy( array( 'chapterId' => $this->chapter->getId() ) );
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
     * @return array
     */
    public function getText()
    {
        $retArr = array();
        foreach ( $this->verses as $verse ) /* @var Verses $verse */
            $retArr[$verse->getNumber()] = $verse->getText();
        return $retArr;
    }

    public function getVerses()
    {
        return $this->verses;
    }

    /**
     * @param bool $long
     * @return string
     */
    public function getBookTitle( $long = false )
    {
        if ( $long )
            return $this->book->getLongTitle();
        else
            return $this->book->getShortTitle();
    }

    /**
     * @return mixed
     */
    public function getChapterNumber()
    {
        return $this->chapter->getNumber();
    }
}