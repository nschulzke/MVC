<?php namespace model\orm\entity;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @var ArrayCollection
     */
    private $books;
    
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
     * Get volumeTitle
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * get chapters
     *
     * @return ArrayCollection
     */
    public function getBooks()
    {
        return $this->books;
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
     * Get volumeSubtitle
     *
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
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

