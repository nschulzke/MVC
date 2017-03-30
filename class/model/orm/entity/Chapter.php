<?php namespace model\orm\entity;

/**
 * Chapter
 */
class Chapter
{
    /**
     * @var integer
     */
    private $bookId = '0';

    /**
     * @var integer
     */
    private $number = '0';

    /**
     * @var integer
     */
    private $id;


    /**
     * Set bookId
     *
     * @param integer $bookId
     *
     * @return Chapter
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
     * @param integer $number
     *
     * @return Chapter
     */
    public function setNumber( $number )
    {
        $this->number = $number;

        return $this;
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

