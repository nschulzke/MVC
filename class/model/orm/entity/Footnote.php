<?php namespace model\orm\entity;

use model\MScripture;
use model\orm\ORM;

class Footnote
{
    /**
     * @var integer
     */
    private $id;
    /**
     * @var Verse
     */
    private $verse;
    /**
     * @var integer
     */
    private $wordNumber;
    /**
     * @var Verse[]
     */
    private $targetVerses;
    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return Verse
     */
    public function getVerseId()
    {
        return $this->verse;
    }
    
    /**
     * @param Verse $verse
     *
     * @return $this
     */
    public function setVerse( $verse )
    {
        $this->verse = $verse;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getWordNumber()
    {
        return $this->wordNumber;
    }
    
    /**
     * @param int $wordNumber
     *
     * @return $this
     */
    public function setWordNumber( $wordNumber )
    {
        $this->wordNumber = $wordNumber;
        
        return $this;
    }
    
    /**
     * @return MScripture
     */
    public function getScripture()
    {
        return new MScripture( $this->targetVerses );
    }
    
    /**
     * @param MScripture $scripture
     *
     * @return $this
     */
    public function setScripture( $scripture )
    {
        $this->targetVerses = $scripture->getVerses();
        
        return $this;
    }
    
    public function save()
    {
        ORM::getManager()->persist( $this );
        ORM::getManager()->flush();
    }
}