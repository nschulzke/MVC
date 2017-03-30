<?php namespace model\orm\entity;

/**
 * Chapter
 */
class Chapter
{
    /**
     * @var Book
     */
    private $book;

    /**
     * @var integer
     */
    private $number;

    /**
     * @var integer
     */
    private $id;
    
    /**
     * @var Verse[]
     */
    private $verses;

    /**
     * Get book
     *
     * @return Book
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * Get chapterNumber
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Get verses
     *
     * @return Verse[]
     */
    public function getVerses()
    {
        return $this->verses;
    }
    
    /**
     * Find verse number $num
     *
     * @param int $num The verse number
     *
     * @return Verse
     */
    public function findVerse( $num )
    {
        return $this->verses[$num - 1];
    }
    
}

