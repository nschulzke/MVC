<?php namespace controller;

use config\Application;
use model\MScripture;
use model\orm\entity\Book;
use model\orm\entity\Chapter;
use model\orm\entity\Volume;
use util\HTTP;
use util\View;

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
            
            $scripture = new MScripture( $book, $chapter, $verses );
            
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
            
            $volume = MScripture::getVolumeRepo()->find( $book->getVolumeId() );
            $chapters = MScripture::getChapterRepo()->findBy( [ 'bookId' => $book->getId() ] );
            /* @var Chapter[] $chapters */
            $breadcrumb = [
                [ 'name' => $volume->getTitle(), 'path' => url( [ self::ROOT ], [ 'volume' => $volume->getLdsUrl() ] ) ],
                [ 'name' => $book->getTitle(), 'path' => url( [ self::ROOT, $book->getLdsUrl() ] ) ],
            ];
            if ( isset( $params[1] ) ) {
                if ( sizeof( $chapters ) == 1 && !isset( $params[2] ) ) {
                    $chapter = $chapters[0]->getNumber();
                    $scripture = new MScripture( $book, $chapter );
                    $verses = MScripture::explodeVerses( $params[1] );
                } else if ( $params[1] <= sizeof( $chapters ) && $params[1] > 0 ) {
                    $chapter = $params[1];
                    $scripture = new MScripture( $book, $chapter );
                    $breadcrumb[] = [ 'name' => 'Chapter ' . $chapter, 'path' => url( [ self::ROOT, $book->getLdsUrl(), $chapter ] ) ];
                    if ( isset( $params[2] ) && $params[2] != '' ) {
                        $verses = MScripture::explodeVerses( $params[2] );
                    }
                }
            } else if ( sizeof( $chapters ) == 1 ) {
                $chapter = $chapters[0]->getNumber();
                $scripture = new MScripture( $book, $chapter );
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
            } else if ( isset( $book ) && isset( $volume ) && isset( $chapters ) ) {
                $view->setVars( [
                    'book'     => $book,
                    'volume'   => $volume,
                    'chapters' => $chapters,
                    'viewPath' => self::VIEW_CHAPTERS,
                ] );
            }
            $view->display();
        } else {
            $view = new View( $route );
            
            if ( isset( $_GET['volume'] ) )
                $active = $_GET['volume'];
            
            $volumes = MScripture::getVolumeRepo()->findAll();
            $books = MScripture::getBookRepo();
            
            $array = [];
            foreach ( $volumes as $volume ) /* @var Volume $volume */ {
                $array[$volume->getLdsUrl()] = [ 'name' => $volume->getTitle() ];
                foreach ( $books->findBy( [ 'volumeId' => $volume->getId() ] ) as $book ) /* @var Book $book */ {
                    $array[$volume->getLdsUrl()]['books'][$book->getLdsUrl()] = $book->getTitle();
                }
            }
            
            $view->setVars( [
                'volumes'  => $array,
                'active'   => isset( $active ) ? $active : '',
                'viewPath' => self::VIEW_BOOKS,
            ] );
            $view->display();
        }
    }
    
    static public function action_saveFootnote( $route, $params )
    {
        $vars = [ 'verseId' => 'Verse', 'wordNumber' => 'Word', 'targetVerseId' => 'Target Verse' ];
        HTTP::requireVars( $vars );
        HTTP::numericVars( $vars );
        HTTP::constrainVars(
            [
                'Verse ID must be a positive number' => $_REQUEST['verseId'] >= 0,
                'Word number must be a positive number' => $_REQUEST['wordNumber'] >= 0,
                'Target Verse ID must be a positive number' => $_REQUEST['targetVerseId'] >= 0
            ]
        );
    }
    
    private function __construct()
    {
    }
    
    private function __clone()
    {
    }
}