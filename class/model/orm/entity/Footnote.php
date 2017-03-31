<?php namespace model\orm\entity;

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
     * @var Verse
     */
    private $targetVerse;
    
    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * @return Verse
     */
    public function getVerseId() {
        return $this->verse;
    }
    
    /**
     * @param Verse $verse
     *
     * @return $this
     */
    public function setVerse( $verse ) {
        $this->verse = $verse;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getWordNumber() {
        return $this->wordNumber;
    }
    
    /**
     * @param int $wordNumber
     *
     * @return $this
     */
    public function setWordNumber( $wordNumber ) {
        $this->wordNumber = $wordNumber;
        
        return $this;
    }
    
    /**
     * @return Verse
     */
    public function getTargetVerse() {
        return $this->targetVerse;
    }
    
    /**
     * @param $targetVerse
     *
     * @return $this
     */
    public function setTargetVerse( $targetVerse ) {
        $this->targetVerse = $targetVerse;
        
        return $this;
    }
    
    public function save() {
        ORM::getManager()->persist($this);
        ORM::getManager()->flush();
    }
}