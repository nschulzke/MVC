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
     * @var Book[]
     */
    private $books;
    
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
    
    /**
     * get chapters
     *
     * @return Book[]
     */
    public function getBooks()
    {
        return $this->books;
    }
    
    private function __construct()
    {
    }
    
    private function __clone()
    {
    }
}

