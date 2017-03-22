<?php

/**
 * Books
 */
class Books
{
    /**
     * @var integer
     */
    private $volumeId;

    /**
     * @var string
     */
    private $bookTitle;

    /**
     * @var string
     */
    private $bookLongTitle;

    /**
     * @var string
     */
    private $bookSubtitle;

    /**
     * @var string
     */
    private $bookShortTitle;

    /**
     * @var string
     */
    private $bookLdsUrl;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set volumeId
     *
     * @param integer $volumeId
     *
     * @return Books
     */
    public function setVolumeId( $volumeId )
    {
        $this->volumeId = $volumeId;

        return $this;
    }

    /**
     * Get volumeId
     *
     * @return integer
     */
    public function getVolumeId()
    {
        return $this->volumeId;
    }

    /**
     * Set bookTitle
     *
     * @param string $bookTitle
     *
     * @return Books
     */
    public function setBookTitle( $bookTitle )
    {
        $this->bookTitle = $bookTitle;

        return $this;
    }

    /**
     * Get bookTitle
     *
     * @return string
     */
    public function getBookTitle()
    {
        return $this->bookTitle;
    }

    /**
     * Set bookLongTitle
     *
     * @param string $bookLongTitle
     *
     * @return Books
     */
    public function setBookLongTitle( $bookLongTitle )
    {
        $this->bookLongTitle = $bookLongTitle;

        return $this;
    }

    /**
     * Get bookLongTitle
     *
     * @return string
     */
    public function getBookLongTitle()
    {
        return $this->bookLongTitle;
    }

    /**
     * Set bookSubtitle
     *
     * @param string $bookSubtitle
     *
     * @return Books
     */
    public function setBookSubtitle( $bookSubtitle )
    {
        $this->bookSubtitle = $bookSubtitle;

        return $this;
    }

    /**
     * Get bookSubtitle
     *
     * @return string
     */
    public function getBookSubtitle()
    {
        return $this->bookSubtitle;
    }

    /**
     * Set bookShortTitle
     *
     * @param string $bookShortTitle
     *
     * @return Books
     */
    public function setBookShortTitle( $bookShortTitle )
    {
        $this->bookShortTitle = $bookShortTitle;

        return $this;
    }

    /**
     * Get bookShortTitle
     *
     * @return string
     */
    public function getBookShortTitle()
    {
        return $this->bookShortTitle;
    }

    /**
     * Set bookLdsUrl
     *
     * @param string $bookLdsUrl
     *
     * @return Books
     */
    public function setBookLdsUrl( $bookLdsUrl )
    {
        $this->bookLdsUrl = $bookLdsUrl;

        return $this;
    }

    /**
     * Get bookLdsUrl
     *
     * @return string
     */
    public function getBookLdsUrl()
    {
        return $this->bookLdsUrl;
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

