<?php namespace model\orm\entity;

/**
 * Verse
 */
class Verse
{
    /**
     * @var Chapter
     */
    private $chapter;

    /**
     * @var integer
     */
    private $number;

    /**
     * @var string
     */
    private $text;

    /**
     * @var integer
     */
    private $id;
    
    /**
     * @var Footnote[]
     */
    private $footnotes;
    
    /**
     * Get chapter
     *
     * @return Chapter
     */
    public function getChapter()
    {
        return $this->chapter;
    }

    /**
     * Get verseNumber
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Get scriptureText
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
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
     * Get footnotes
     *
     * @return Footnote[]
     */
    public function getFootnotes()
    {
        return $this->footnotes;
    }
}

