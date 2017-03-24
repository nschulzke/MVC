<?php namespace model\orm\entity;

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
    private $number = '0';

    /**
     * @var string
     */
    private $text;

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
     * @param integer $number
     *
     * @return Verses
     */
    public function setNumber( $number )
    {
        $this->number = $number;

        return $this;
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
     * Set scriptureText
     *
     * @param string $text
     *
     * @return Verses
     */
    public function setText( $text )
    {
        $this->text = $text;

        return $this;
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
}

