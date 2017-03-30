<?php namespace controller;

use Doctrine\Common\Collections\Criteria;
use model\MScripture;
use model\orm\entity\Book;
use model\orm\entity\Chapter;
use model\orm\entity\Verse;
use model\orm\entity\Volume;
use util\WordAnalysis;

class ScriptureAnalysis
{
    public static function action_wordFrequency( $route, $params )
    {
        $bookRepo = MScripture::getBookRepo();
        $chapterRepo = MScripture::getChapterRepo();
        $verseRepo = MScripture::getVerseRepo();
        
        if ( isset( $params[0] ) )
            $volumes = MScripture::getVolumeRepo()->findBy( [ 'ldsUrl' => $params[0] ] );
        else
            $volumes = MScripture::getVolumeRepo()->findAll();
        
        $preMerge = [];
        $wordCount = 0;
        foreach ( $volumes as $volume ) /* @var Volume $volume */ {
            $books = $bookRepo->findBy( [ 'volumeId' => $volume->getId() ] );
            
            foreach ( $books as $book ) /* @var Book $book */ {
                $chapters = $chapterRepo->findBy( [ 'bookId' => $book->getId() ] );
                
                foreach ( $chapters as $chapter ) /* @var Chapter $chapter */ {
                    $verses = $verseRepo->findBy( [ 'chapterId' => $chapter->getId() ] );
                    
                    foreach ( $verses as $verse ) /* @var Verse $verse */ {
                        $words = WordAnalysis::explodeWords( $verse->getText() );
                        foreach ( $words as $word ) {
                            if ( array_key_exists( $word, $preMerge ) )
                                $preMerge[$word]++;
                            else
                                $preMerge[$word] = 1;
                            $wordCount++;
                        }
                    }
                }
            }
        }
        $wordsArray = [];
        foreach ( $preMerge as $word => $count ) {
            $stem = WordAnalysis::stem( $word );
            if ( array_key_exists( $stem, $wordsArray ) )
                $wordsArray[$stem] += $count;
            else
                $wordsArray[$stem] = $count;
        }
        
        arsort( $wordsArray );
        
        foreach ( $wordsArray as $word => $count )
            echo $word . ' => ' . $count . '<br>';
        
        $file = fopen( 'wordFrequency.json', 'w' );
        fwrite( $file, json_encode( $wordsArray ) );
        fclose( $file );
    }
    
    public static function action_connectionsBetweenWords( $route, $params )
    {
        $bookRepo = MScripture::getBookRepo();
        $chapterRepo = MScripture::getChapterRepo();
        $verseRepo = MScripture::getVerseRepo();
        
        if ( isset( $params[0] ) )
            $volumes = MScripture::getVolumeRepo()->findBy( [ 'ldsUrl' => $params[0] ] );
        else
            $volumes = MScripture::getVolumeRepo()->findAll();
        
        $preMerge = [];
        foreach ( $volumes as $volume ) /* @var Volume $volume */ {
            $books = $bookRepo->findBy( [ 'volumeId' => $volume->getId() ] );
            
            foreach ( $books as $book ) /* @var Book $book */ {
                $chapters = $chapterRepo->findBy( [ 'bookId' => $book->getId() ] );
                
                foreach ( $chapters as $chapter ) /* @var Chapter $chapter */ {
                    $verses = $verseRepo->findBy( [ 'chapterId' => $chapter->getId() ] );
                    
                    foreach ( $verses as $verse ) /* @var Verse $verse */ {
                        $words = WordAnalysis::explodeWords( $verse->getText(), true );
                        foreach ( $words as $source ) {
                            if ( !array_key_exists( $source, $preMerge ) )
                                $preMerge[$source] = [];
                            foreach ( $words as $target ) {
                                if ( $source != $target ) {
                                    if ( array_key_exists( $target, $preMerge[$source] ) )
                                        $preMerge[$source][$target]++;
                                    else
                                        $preMerge[$source][$target] = 1;
                                }
                            }
                        }
                    }
                }
            }
        }
        
        $wordsArray = [];
        foreach ( $preMerge as $source => $words ) {
            $sourceStem = WordAnalysis::stem( $source );
            if ( !array_key_exists( $sourceStem, $wordsArray ) )
                $wordsArray[$sourceStem] = [];
            foreach ( $words as $target => $count ) {
                $targetStem = WordAnalysis::stem( $target );
                if ( $sourceStem != $targetStem ) {
                    if ( array_key_exists( $targetStem, $wordsArray[$sourceStem] ) )
                        $wordsArray[$sourceStem][$targetStem] += $count;
                    else
                        $wordsArray[$sourceStem][$targetStem] = $count;
                }
            }
        }
        
        foreach ( $wordsArray as $source => $array )
            arsort( $wordsArray[$source] );
        
        foreach ( $wordsArray as $source => $targetArr ) {
            echo '<br><br>' . $source . ' => ';
            print_r( $targetArr );
        }
    }
    
    public static function action_findConnections( $route, $params )
    {
        if ( isset( $params[0] ) && isset( $params[1] ) ) {
            $book = $params[0];
            $chapter = $params[1];
            if ( isset( $params[2] ) )
                $verses = explode( ',', $params[2] );
            else
                $verses = null;
            
            $verseRepo = MScripture::getVerseRepo();
            $scripture = new MScripture( $book, $chapter, $verses );
            
            $references = [];
            foreach ( $scripture->getVerses() as $verse ) /* @var Verse $verse */ {
                $words = WordAnalysis::countWords( $verse->getText() );
                WordAnalysis::filterWords( $words );
                foreach ( $words as $word => $count ) {
                    echo "$word, ";
                    $criteria = Criteria::create();
                    $criteria->where( Criteria::expr()->contains( 'text', $word ) );
                    $verses = $verseRepo->matching( $criteria );
                    foreach ( $verses as $verse ) {
                        if ( array_key_exists( $verse->getId(), $references ) )
                            $references[$verse->getId()] += $count + WordAnalysis::countWord( $word, $verse->getText() );
                        else
                            $references[$verse->getId()] = $count + WordAnalysis::countWord( $word, $verse->getText() );
                    }
                }
            }
            arsort( $references );
            echo '<br/>';
            foreach ( $references as $refId => $count ) {
                $verse = $verseRepo->find( $refId );
                echo $count . ': ';
                echo $verse->getText();
                echo '<br/>';
            }
        }
    }
    
    private function __construct()
    {
    }
    
    private function __clone()
    {
    }
}