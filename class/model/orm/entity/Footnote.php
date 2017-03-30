<?php namespace model\orm\entity;

class Footnote
{
    /**
     * @var integer
     */
    private $id;
    /**
     * @var integer
     */
    private $verseId = '0';
    /**
     * @var integer
     */
    private $wordNumber = '0';
    /**
     * @var integer
     */
    private $targetVerseId = '0';
    
    public function getId() {
        return $this->id;
    }
    
    public function getVerseId() {
        return $this->verseId;
    }
    
    public function setVerseId( $verseId ) {
        $this->verseId = $verseId;
        
        return $this;
    }
    
    public function getWordNumber() {
        return $this->wordNumber;
    }
    
    public function setWordNumber( $wordNumber ) {
        $this->wordNumber = $wordNumber;
        
        return $this;
    }
    
    public function getTargetVerseId() {
        return $this->targetVerseId;
    }
    
    public function setTargetVerseId( $targetVerseId ) {
        $this->targetVerseId = $targetVerseId;
        
        return $this;
    }
}