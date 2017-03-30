<?php namespace model\orm\entity;

/**
 * Volume
 */
class Volume
{
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
     * Set volumeTitle
     *
     * @param string $title
     *
     * @return Volume
     */
    public function setTitle( $title )
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get volumeTitle
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set volumeLongTitle
     *
     * @param string $longTitle
     *
     * @return Volume
     */
    public function setLongTitle( $longTitle )
    {
        $this->longTitle = $longTitle;

        return $this;
    }

    /**
     * Get volumeLongTitle
     *
     * @return string
     */
    public function getLongTitle()
    {
        return $this->longTitle;
    }

    /**
     * Set volumeSubtitle
     *
     * @param string $subtitle
     *
     * @return Volume
     */
    public function setSubtitle( $subtitle )
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    /**
     * Get volumeSubtitle
     *
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set volumeShortTitle
     *
     * @param string $shortTitle
     *
     * @return Volume
     */
    public function setShortTitle( $shortTitle )
    {
        $this->shortTitle = $shortTitle;

        return $this;
    }

    /**
     * Get volumeShortTitle
     *
     * @return string
     */
    public function getShortTitle()
    {
        return $this->shortTitle;
    }

    /**
     * Set volumeLdsUrl
     *
     * @param string $ldsUrl
     *
     * @return Volume
     */
    public function setLdsUrl( $ldsUrl )
    {
        $this->ldsUrl = $ldsUrl;

        return $this;
    }

    /**
     * Get volumeLdsUrl
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

