<?php namespace controller;

use config\Application;
use model\MScripture;
use model\orm\entity\Books;
use model\orm\entity\Volumes;
use util\View;

class Scripture
{
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

    static public function action_view( $route, $params )
    {
        $view = new View( $route );
        $crumbRoot = Application::getAppPath() . '/scripture/view';
        $verses = [];
        if ( isset( $params[0] ) ) {
            $book = MScripture::findBook( $params[0] );
            $volume = MScripture::getVolumesRepo()->find( $book->getVolumeId() );
            $chapters = MScripture::getChaptersRepo()->findBy( [ 'bookId' => $book->getId() ] );
            $breadcrumb = [
                [ 'name' => $volume->getTitle(), 'path' => $crumbRoot . '?volume=' . $volume->getId() ],
                [ 'name' => $book->getTitle(), 'path' => $crumbRoot . '/' . $book->getLdsUrl() ],
            ];
            if ( isset( $params[1] ) ) {
                $chapter = $params[1];
                $scripture = new MScripture( $book, $chapter );
                $breadcrumb[] = [ 'name' => 'Chapter ' . $chapter, 'path' => $crumbRoot . '/' . $book->getLdsUrl() . '/' . $chapter ];
                if ( isset( $params[2] ) && $params[2] != '' ) {
                    $verses = explode( ',', $params[2] );
                    $verses = MScripture::explodeRanges( $verses );
                }
            }
            else if ( sizeof($chapters) == 1 )
                $scripture = new MScripture( $book, $chapters[0]->getNumber() );
        }

        if ( isset( $breadcrumb ) ) {
            $view->setVar( 'breadcrumb', $breadcrumb );
            if ( isset( $scripture ) ) {
                $view->setVar( 'scripture', $scripture )
                     ->setVar( 'verses', $verses );
            } else if ( isset( $book ) && isset( $volume ) && isset( $chapters ) ) {
                $view->setVar( 'book', $book )
                     ->setVar( 'volume', $volume )
                     ->setVar( 'chapters', $chapters )
                     ->setVar( 'breadcrumb', $breadcrumb )
                     ->setVar( 'viewPath', 'scripture/chapter-list.php' );
            }
            $view->display();
        } else {
            if ( isset( $_GET['volume'] ) && is_numeric( $_GET['volume'] ) )
                $active = MScripture::getVolumesRepo()->find( $_GET['volume'] );

            $view = new View( $route );

            $volumes = MScripture::getVolumesRepo()->findAll();
            $books = MScripture::getBooksRepo();

            $array = [];
            foreach ( $volumes as $volume ) /* @var Volumes $volume */ {
                $array[$volume->getTitle()] = [];
                foreach ( $books->findBy( [ 'volumeId' => $volume->getId() ] ) as $book ) /* @var Books $book */ {
                    $array[$volume->getTitle()][$book->getLdsUrl()] = $book->getTitle();
                }
            }

            $view->setVar( 'volumes', $array )
                 ->setVar( 'viewPath', 'scripture/book-list.php' );
            if ( isset( $active ) )
                $view->setVar( 'active', $active->getTitle() );
            else
                $view->setVar( 'active', '' );
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