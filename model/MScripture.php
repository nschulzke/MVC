<?php
// Bootstrap ORM
require_once __DIR__ . "/../orm/bootstrap.php";

// Load ORM classes
foreach ( glob( __DIR__ . "/../orm/entities/*.php" ) as $filename )
    require_once $filename;

use Doctrine\Common\Collections\Criteria;

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
        global $entityManager;
        if ( !isset( $volumesRepo ) )
            self::$volumesRepo = $entityManager->getRepository( 'Volumes' );
        return self::$volumesRepo;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public static function getBooksRepo()
    {
        global $entityManager;
        if ( !isset( $booksRepo ) )
            self::$booksRepo = $entityManager->getRepository( 'Books' );
        return self::$booksRepo;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public static function getChaptersRepo()
    {
        global $entityManager;
        if ( !isset( $chaptersRepo ) )
            self::$chaptersRepo = $entityManager->getRepository( 'Chapters' );
        return self::$chaptersRepo;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public static function getVersesRepo()
    {
        global $entityManager;
        if ( !isset( $versesRepo ) )
            self::$versesRepo = $entityManager->getRepository( 'Verses' );
        return self::$versesRepo;
    }

    private $book; /* @var Books $book */
    private $chapter; /* @var Chapters $chapter */
    private $verses = array();

    /**
     * @param $bookName
     * @return Books|null|object
     */
    private function findBook( $bookName )
    {
        if ( is_numeric( $bookName ) )
            return self::getBooksRepo()->find( $bookName );
        $criteria = Criteria::create();
        $criteria->where(
            Criteria::expr()->orX(
                Criteria::expr()->contains( 'bookTitle', $bookName ),
                Criteria::expr()->contains( 'bookLongTitle', $bookName ),
                Criteria::expr()->contains( 'bookShortTitle', $bookName )
            )
        );
        $books = self::getBooksRepo()->matching( $criteria );
        if ( $books->count() > 0 )
            return $books->get( 0 );
        else
            return null;
    }

    /**
     * MScripture constructor.
     * @param $bookName
     * @param $chapterNum
     * @param array $verseNums
     */
    public function __construct( $bookName, $chapterNum, $verseNums = array() )
    {
        $this->book = $this->findBook( $bookName );

        $this->chapter = self::getChaptersRepo()->findOneBy( array( 'bookId' => $this->book->getId(), 'number' => $chapterNum ) );

        if ( is_numeric( $verseNums ) )
            $this->verses = array( self::getVersesRepo()->findOneBy( array( 'chapterId' => $this->chapter->getId(), 'number' => $verseNums ) ) );
        else {
            for ( $i = 0; $i < sizeof( $verseNums ); $i++ ) {
                if ( strpos( $verseNums[$i], '-' ) != false ) {
                    $range = explode( '-', $verseNums[$i] );
                    unset ( $verseNums[$i] );
                    for ( $j = $range[0]; $j <= $range[1]; $j++ )
                        $verseNums[] = $j;
                }
            }
            $verses = self::getVersesRepo()->findBy( array( 'chapterId' => $this->chapter->getId() ) );
            if ( isset( $verseNums ) && sizeof( $verseNums ) > 0 ) {
                if ( isset( $verseNums['start'] ) && isset( $verseNums['end'] ) ) {
                    foreach ( $verses as $verse ) /* @var Verses $verse*/
                        if ( $verse->getNumber() >= $verseNums['start'] && $verse->getNumber() <= $verseNums['end'] )
                            $this->verses[$verse->getNumber()] = $verse;
                } else {
                    foreach ( $verses as $verse ) /* @var Verses $verse*/
                        if ( in_array( $verse->getNumber(), $verseNums ) )
                            $this->verses[$verse->getNumber()] = $verse;
                }
            } else {
                foreach ( $verses as $verse ) /* @var Verses $verse*/
                    $this->verses[$verse->getNumber()] = $verse;
            }
        }
    }

    /**
     * @return array
     */
    public function getVerses()
    {
        $retArr = array();
        foreach ( $this->verses as $verse ) /* @var Verses $verse*/
            $retArr[$verse->getNumber()] = $verse->getText();
        return $retArr;
    }

    /**
     * @param bool $long
     * @return string
     */
    public function getBook( $long = false )
    {
        if ( $long )
            return $this->book->getLongTitle();
        else
            return $this->book->getShortTitle();
    }

    /**
     * @return mixed
     */
    public function getChapter()
    {
        return $this->chapter->getNumber();
    }

    /**
     * @return mixed
     */
    public function getVerse()
    {
        return $this->chapter->getNumber();
    }
}