<?php
// Bootstrap ORM
require_once __DIR__ . "/../orm/bootstrap.php";

// Load ORM classes
foreach (glob(__DIR__ . "/../orm/entities/*.php") as $filename)
    require_once $filename;
    
use Doctrine\Common\Collections\Criteria;

class MScripture
{
    private static $booksRepo;
    private static $chaptersRepo;
    private static $versesRepo;
    
    private $book;
    private $chapter;
    private $verses = array();
    
    private function findBook($bookName)
    {
        $crit = Criteria::create();
        $crit->where(
            $crit->expr()->orX(
                $crit->expr()->contains('bookTitle', $bookName),
                $crit->expr()->contains('bookLongTitle', $bookName),
                $crit->expr()->contains('bookShortTitle', $bookName)
            )
        );
        $books = self::$booksRepo->matching($crit);
        if ($books->count() > 0)
            return $books->get(0);
        else
            return null;
    }
    
    public function __construct($bookName, $chapterNum, $verseNums = null)
    {
        global $entityManager;
        if (!isset($booksRepo))
            self::$booksRepo = $entityManager->getRepository('Books');
        if (!isset($chaptersRepo))
            self::$chaptersRepo = $entityManager->getRepository('Chapters');
        if (!isset($versesRepo))
            self::$versesRepo = $entityManager->getRepository('Verses');
        
        $this->book = $this->findBook($bookName);
        
        $this->chapter = self::$chaptersRepo->findOneBy(array( 'bookId' => $this->book->getId(), 'chapterNumber' => $chapterNum));
        
        if ( is_numeric($verseNums) )
            $this->verses = array( self::$versesRepo->findOneBy(array( 'chapterId' => $this->chapter->getId() , 'verseNumber' => $verseNums )) );
        else
        {
            $verses = self::$versesRepo->findBy(array( 'chapterId' => $this->chapter->getId() ));
            if ( isset($verseNums) )
            {
                if ( isset($verseNums['start']) && isset($verseNums['end']) )
                {
                    foreach ($verses as $verse)
                        if ( $verse->getVerseNumber() >= $verseNums['start'] && $verse->getVerseNumber() <= $verseNums['end'] )
                            $this->verses[$verse->getVerseNumber()] = $verse;
                }
                else
                {
                    foreach ($verses as $verse)
                        if ( in_array($verse->getVerseNumber(), $verseNums ) )
                            $this->verses[$verse->getVerseNumber()] = $verse;
                }
            }
            else
            {
                foreach ($verses as $verse)
                    $this->verses[$verse->getVerseNumber()] = $verse;
            }
        }
    }
    
    public function getVerses()
    {
        $retArr = array();
        foreach ( $this->verses as $verse )
            $retArr[$verse->getVerseNumber()] = $verse->getScriptureText();
        return $retArr;
    }
    
    public function getBook($long = false)
    {
        if ($long)
            return $this->book->getBookLongTitle();
        else
            return $this->book->getBookShortTitle();
    }
    
    public function getChapter()
    {
        return $this->chapter->getChapterNumber();
    }
    
    public function getVerse()
    {
        return $this->chapter->getVerseNumber();
    }
}
?>