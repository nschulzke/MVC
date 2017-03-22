<?php


/**
 * Chapters
 */
class Chapters
{
    /**
     * @var integer
     */
    private $bookId = '0';

    /**
     * @var integer
     */
    private $chapterNumber = '0';

    /**
     * @var integer
     */
    private $id;


    /**
     * Set bookId
     *
     * @param integer $bookId
     *
     * @return Chapters
     */
    public function setBookId( $bookId )
    {
        $this->bookId = $bookId;

        return $this;
    }

    /**
     * Get bookId
     *
     * @return integer
     */
    public function getBookId()
    {
        return $this->bookId;
    }

    /**
     * Set chapterNumber
     *
     * @param integer $chapterNumber
     *
     * @return Chapters
     */
    public function setChapterNumber( $chapterNumber )
    {
        $this->chapterNumber = $chapterNumber;

        return $this;
    }

    /**
     * Get chapterNumber
     *
     * @return integer
     */
    public function getChapterNumber()
    {
        return $this->chapterNumber;
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

