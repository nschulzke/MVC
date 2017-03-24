<?php namespace model\orm\entity;

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
    private $title;

    /**
     * @var string
     */
    private $longTitle;

    /**
     * @var string
     */
    private $subtitle;

    /**
     * @var string
     */
    private $shortTitle;

    /**
     * @var string
     */
    private $ldsUrl;

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
     * @param string $title
     *
     * @return Books
     */
    public function setTitle( $title )
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get bookTitle
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set bookLongTitle
     *
     * @param string $longTitle
     *
     * @return Books
     */
    public function setLongTitle( $longTitle )
    {
        $this->longTitle = $longTitle;

        return $this;
    }

    /**
     * Get bookLongTitle
     *
     * @return string
     */
    public function getLongTitle()
    {
        return $this->longTitle;
    }

    /**
     * Set bookSubtitle
     *
     * @param string $subtitle
     *
     * @return Books
     */
    public function setSubtitle( $subtitle )
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    /**
     * Get bookSubtitle
     *
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set bookShortTitle
     *
     * @param string $shortTitle
     *
     * @return Books
     */
    public function setShortTitle( $shortTitle )
    {
        $this->shortTitle = $shortTitle;

        return $this;
    }

    /**
     * Get bookShortTitle
     *
     * @return string
     */
    public function getShortTitle()
    {
        return $this->shortTitle;
    }

    /**
     * Set bookLdsUrl
     *
     * @param string $ldsUrl
     *
     * @return Books
     */
    public function setLdsUrl( $ldsUrl )
    {
        $this->ldsUrl = $ldsUrl;

        return $this;
    }

    /**
     * Get bookLdsUrl
     *
     * @return string
     */
    public function getLdsUrl()
    {
        return $this->ldsUrl;
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

