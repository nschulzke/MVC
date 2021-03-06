<?php namespace model\orm\entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Book
 */
class Book
{
    /**
     * @var Volume
     */
    private $volume;
    
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
     * @var Chapter[]|ArrayCollection
     */
    private $chapters;
    
    /**
     * Get volume
     *
     * @return Volume
     */
    public function getVolume()
    {
        return $this->volume;
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
     * Get bookLongTitle
     *
     * @return string
     */
    public function getLongTitle()
    {
        return $this->longTitle;
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
     * Get bookShortTitle
     *
     * @return string
     */
    public function getShortTitle()
    {
        return $this->shortTitle;
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
    
    /**
     * Get chapters
     *
     * @return Chapter[]
     */
    public function getChapters()
    {
        return $this->chapters;
    }
    
    /**
     * Find chapter number $num
     *
     * @param int $num The chapter number
     *
     * @return Chapter
     */
    public function findChapter( $num )
    {
        return $this->chapters[$num - 1];
    }
}

