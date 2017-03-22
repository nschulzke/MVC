<?php


/**
 * Verses
 */
class Verses
{
    /**
     * @var integer
     */
    private $chapterId = '0';

    /**
     * @var integer
     */
    private $verseNumber = '0';

    /**
     * @var string
     */
    private $scriptureText;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set chapterId
     *
     * @param integer $chapterId
     *
     * @return Verses
     */
    public function setChapterId( $chapterId )
    {
        $this->chapterId = $chapterId;

        return $this;
    }

    /**
     * Get chapterId
     *
     * @return integer
     */
    public function getChapterId()
    {
        return $this->chapterId;
    }

    /**
     * Set verseNumber
     *
     * @param integer $verseNumber
     *
     * @return Verses
     */
    public function setVerseNumber( $verseNumber )
    {
        $this->verseNumber = $verseNumber;

        return $this;
    }

    /**
     * Get verseNumber
     *
     * @return integer
     */
    public function getVerseNumber()
    {
        return $this->verseNumber;
    }

    /**
     * Set scriptureText
     *
     * @param string $scriptureText
     *
     * @return Verses
     */
    public function setScriptureText( $scriptureText )
    {
        $this->scriptureText = $scriptureText;

        return $this;
    }

    /**
     * Get scriptureText
     *
     * @return string
     */
    public function getScriptureText()
    {
        return $this->scriptureText;
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

