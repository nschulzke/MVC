<?php



/**
 * Pilcrow
 */
class Pilcrow
{
    /**
     * @var integer
     */
    private $verseId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set verseId
     *
     * @param integer $verseId
     *
     * @return Pilcrow
     */
    public function setVerseId($verseId)
    {
        $this->verseId = $verseId;

        return $this;
    }

    /**
     * Get verseId
     *
     * @return integer
     */
    public function getVerseId()
    {
        return $this->verseId;
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

