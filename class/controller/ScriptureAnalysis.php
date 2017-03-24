<?php namespace controller;

use Doctrine\Common\Collections\Criteria;
use model\MScripture;
use model\orm\entity\Books;
use model\orm\entity\Chapters;
use model\orm\entity\Verses;
use model\orm\entity\Volumes;
use util\WordAnalysis;

class ScriptureAnalysis
{
    public static function action_mostCommonWords( $route, $params )
    {
        $booksRepo = MScripture::getBooksRepo();
        $chaptersRepo = MScripture::getChaptersRepo();
        $versesRepo = MScripture::getVersesRepo();

        $threshold = 0.007;

        if ( isset( $params[0] ) )
            $volumes = MScripture::getVolumesRepo()->findBy( [ 'ldsUrl' => $params[0] ] );
        else
            $volumes = MScripture::getVolumesRepo()->findAll();

        $wordsArray = [];
        $wordCount = 0;
        foreach ( $volumes as $volume ) /* @var Volumes $volume */ {
            $books = $booksRepo->findBy( [ 'volumeId' => $volume->getId() ] );

            foreach ( $books as $book ) /* @var Books $book */ {
                $chapters = $chaptersRepo->findBy( [ 'bookId' => $book->getId() ] );

                foreach ( $chapters as $chapter ) /* @var Chapters $chapter */ {
                    $verses = $versesRepo->findBy( [ 'chapterId' => $chapter->getId() ] );

                    foreach ( $verses as $verse ) /* @var Verses $verse */ {
                        $words = WordAnalysis::explodeWords( $verse->getText() );
                        foreach ( $words as $word ) {
                            if ( array_key_exists( $word, $wordsArray ) )
                                $wordsArray[$word]++;
                            else
                                $wordsArray[$word] = 1;
                            $wordCount++;
                        }
                    }
                }
            }
        }
        echo 'words:' . $wordCount . ' ';
        arsort( $wordsArray );
        foreach ( $wordsArray as $word => $count ) {
            if ( $count / $wordCount < $threshold )
                break;
            else
                echo $word . ', ';
        }

        print_r( $wordsArray );
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

            $versesRepo = MScripture::getVersesRepo();
            $scripture = new MScripture( $book, $chapter, $verses );

            $references = [];
            foreach ( $scripture->getVerses() as $verse ) /* @var Verses $verse */ {
                $words = WordAnalysis::countWords( $verse->getText() );
                WordAnalysis::filterWords( $words );
                foreach ( $words as $word => $count ) {
                    echo "$word, ";
                    $criteria = Criteria::create();
                    $criteria->where( Criteria::expr()->contains( 'text', $word ) );
                    $verses = $versesRepo->matching( $criteria );
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
                $verse = $versesRepo->find( $refId );
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