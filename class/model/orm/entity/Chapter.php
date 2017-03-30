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
}

