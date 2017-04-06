<?php namespace controller;

use config\Application;
use model\MScripture;
use model\orm\entity\Chapter;
use model\orm\entity\Footnote;
use model\orm\entity\Verse;
use util\HTTP;
use util\View;
use util\WordAnalysis;

class Scripture
{
    const VIEW_VERSES = 'scripture/view.php';
    const VIEW_CHAPTERS = 'scripture/chapter-list.php';
    const VIEW_BOOKS = 'scripture/book-list.php';
    const ROOT = Application::APP_PATH . '/scripture';
    
    static public function action_lookup( $route, $params )
    {
        $view = new View( $route );
        if ( isset( $params[0] ) && isset( $params[1] ) ) {
            $book = $params[0];
            $chapter = $params[1];
            if ( isset( $params[2] ) )
                $verses = explode( ',', $params[2] );
            else
                $verses = null;
            
            $scripture = MScripture::lookup( $book, $chapter, $verses );
            
            $view->setVar( 'scripture', $scripture );
        }
        $view->display();
    }
    
    static public function action_default( $route, $params )
    {
        // Set the variables we need to use based on input values
        $verses = [];
        if ( isset( $params[0] ) && ( $book = MScripture::findBook( $params[0] ) ) != null ) {
            $view = new View( $route );
            
            $volume = $book->getVolume();
            $chapters = $book->getChapters();
            /* @var Chapter[] $chapters */
            $breadcrumb = [
                [ 'name' => $volume->getTitle(), 'path' => url( [ self::ROOT ], [ 'volume' => $volume->getLdsUrl() ] ) ],
                [ 'name' => $book->getTitle(), 'path' => url( [ self::ROOT, $book->getLdsUrl() ] ) ],
            ];
            if ( isset( $params[1] ) ) {
                if ( sizeof( $chapters ) == 1 && !isset( $params[2] ) ) {
                    $chapter = $chapters[0]->getNumber();
                    $scripture = MScripture::lookup( $book, $chapter );
                    $verses = MScripture::explodeVerses( $params[1] );
                } else if ( $params[1] <= sizeof( $chapters ) && $params[1] > 0 ) {
                    $chapter = $params[1];
                    $scripture = MScripture::lookup( $book, $chapter );
                    $breadcrumb[] = [ 'name' => 'Chapter ' . $chapter, 'path' => url( [ self::ROOT, $book->getLdsUrl(), $chapter ] ) ];
                    if ( isset( $params[2] ) && $params[2] != '' ) {
                        $verses = MScripture::explodeVerses( $params[2] );
                    }
                }
            } else if ( sizeof( $chapters ) == 1 ) {
                $chapter = $chapters[0]->getNumber();
                $scripture = MScripture::lookup( $book, $chapter );
            }
            if ( isset( $chapter ) ) {
                $arrows = [];
                if ( $chapter < sizeof( $chapters ) )
                    $arrows['right'] = url( [ self::ROOT, $book->getLdsUrl(), ( $chapter + 1 ) ] );
                if ( $chapter > 1 )
                    $arrows['left'] = url( [ self::ROOT, $book->getLdsUrl(), ( $chapter - 1 ) ] );
            }
        }
        
        // Based on the variables set, load te appropriate view
        if ( isset( $breadcrumb ) && isset( $view ) ) {
            $view->setVar( 'breadcrumb', $breadcrumb );
            if ( isset( $scripture ) && isset( $arrows ) ) {
                $view->setVars( [
                    'scripture' => $scripture,
                    'verses'    => $verses,
                    'arrows'    => $arrows,
                    'viewPath'  => self::VIEW_VERSES,
                ] );
            } else if ( isset( $book ) ) {
                $view->setVars( [
                    'book'     => $book,
                    'viewPath' => self::VIEW_CHAPTERS,
                ] );
            }
            $view->display();
        } else {
            $view = new View( $route );
            
            if ( isset( $_GET['volume'] ) )
                $active = $_GET['volume'];
            
            $volumes = MScripture::getVolumeRepo()->findAll();
            
            $view->setVars( [
                'volumes'  => $volumes,
                'active'   => isset( $active ) ? $active : '',
                'viewPath' => self::VIEW_BOOKS,
            ] );
            $view->display();
        }
    }
    
    static public function action_newFootnote( $route, $params )
    {
        // No source verse selected
        if ( empty( $params[0] ) )
            echo "No verse selected";
        else {
            $verse = MScripture::getVerseRepo()->find( $params[0] );
            $view = new View( $route, 'none' );
            $view->setVar( 'verse', $verse )->display();
        }
    }
    
    static public function action_saveFootnote( $route, $params )
    {
        $vars = [ 'verseId' => 'Verse', 'wordNumber' => 'Word', 'targetVerseId' => 'Target Verse' ];
        HTTP::requireVars( $vars );
        HTTP::numericVars( $vars );
        
        extract( $_REQUEST );
        /** Request variables:
         * @var integer $verseId
         * @var integer $wordNumber
         * @var integer $targetVerseId
         */
        
        // Validate variables before saving
        $verse = MScripture::getVerseRepo()->find( $verseId );
        /* @var Verse $verse */
        if ( $verse == null )
            HTTP::json_exit( HTTP::BAD_REQUEST, 'No verse with id ' . $verseId . ' exists.' );
        $targetVerse = MScripture::getVerseRepo()->find( $targetVerseId );
        if ( $targetVerse == null )
            HTTP::json_exit( HTTP::BAD_REQUEST, 'No target verse with id ' . $targetVerseId . ' exists.' );
        $words = WordAnalysis::explodeWords( $verse->getText() );
        if ( $wordNumber > sizeof( $words ) )
            HTTP::json_exit( HTTP::BAD_REQUEST, 'There are not ' . $wordNumber . ' words in verse with id ' . $verseId );
        
        $footnote = new Footnote();
        $footnote->setVerse( $verse );
        $footnote->setWordNumber( $wordNumber );
        $footnote->setTargetVerse( $targetVerse );
        $footnote->save();
        
        echo HTTP::json( HTTP::OK, 'Success' );
    }
    
    private function __construct()
    {
    }
    
    private function __clone()
    {
    }
}