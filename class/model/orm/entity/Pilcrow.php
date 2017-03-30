<?php namespace model\orm\entity;

/**
 * Pilcrow
 */
class Pilcrow
{
    /**
     * @var Verse
     */
    private $verse;

    /**
     * @var integer
     */
    private $id;
    
    /**
     * Get verse
     *
     * @return Verse
     */
    public function getVerse()
    {
        return $this->verse;
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

