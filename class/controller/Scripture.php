<?php namespace controller;

use config\Application;
use model\MScripture;
use model\orm\entity\Books;
use model\orm\entity\Chapters;
use model\orm\entity\Volumes;
use util\View;

class Scripture
{
    const VIEW_VERSES   = 'scripture/view.php';
    const VIEW_CHAPTERS = 'scripture/chapter-list.php';
    const VIEW_BOOKS    = 'scripture/book-list.php';
    
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
            $crumbRoot = Application::APP_PATH . '/scripture';
        
            $volume = MScripture::getVolumesRepo()->find( $book->getVolumeId() );
            $chapters = MScripture::getChaptersRepo()->findBy( [ 'bookId' => $book->getId() ] );
            /* @var Chapters[] $chapters */
            $breadcrumb = [
                [ 'name' => $volume->getTitle(), 'path' => $crumbRoot . '?volume=' . $volume->getLdsUrl() ],
                [ 'name' => $book->getTitle(), 'path' => $crumbRoot . '/' . $book->getLdsUrl() ],
            ];
            if ( isset( $params[1] ) ) {
                if ( sizeof( $chapters ) == 1 && !isset( $params[2] ) ) {
                    $scripture = new MScripture( $book, $chapters[0]->getNumber() );
                    $verses = MScripture::explodeVerses( $params[1] );
                } else if ( $params[1] <= sizeof( $chapters ) && $params[1] > 0 ) {
                    $chapter = $params[1];
                    $scripture = new MScripture( $book, $chapter );
                    $breadcrumb[] = [ 'name' => 'Chapter ' . $chapter, 'path' => $crumbRoot . '/' . $book->getLdsUrl() . '/' . $chapter ];
                    if ( isset( $params[2] ) && $params[2] != '' ) {
                        $verses = MScripture::explodeVerses( $params[2] );
                    }
                    $arrows = [];
                    if ( $chapter < sizeof( $chapters ) )
                        $arrows['right'] = $crumbRoot . '/' . $book->getLdsUrl() . '/' . ( $chapter + 1 );
                    if ( $chapter > 1 )
                        $arrows['left'] = $crumbRoot . '/' . $book->getLdsUrl() . '/' . ( $chapter - 1 );
                }
            } else if ( sizeof( $chapters ) == 1 )
                $scripture = new MScripture( $book, $chapters[0]->getNumber() );
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
        
            $volumes = MScripture::getVolumesRepo()->findAll();
            $books = MScripture::getBooksRepo();
        
            $array = [];
            foreach ( $volumes as $volume ) /* @var Volumes $volume */ {
                $array[$volume->getLdsUrl()] = [ 'name' => $volume->getTitle() ];
                foreach ( $books->findBy( [ 'volumeId' => $volume->getId() ] ) as $book ) /* @var Books $book */ {
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
    
    private function __construct()
    {
    }
    
    private function __clone()
    {
    }
}