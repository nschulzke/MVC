<?php namespace controller;

use config\Application;
use model\MScripture;
use model\orm\entity\Books;
use model\orm\entity\Chapters;
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

    static public function action_default( $route, $params )
    {
        // Set the variables we need to use based on input values
        if ( isset( $params[0] ) && ( $book = MScripture::findBook( $params[0] ) ) != null ) {
            $view = new View( $route );
            $crumbRoot = Application::getAppPath() . '/scripture';
            $verses = [];

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
        if ( isset( $breadcrumb ) ) {
            $view->setVar( 'breadcrumb', $breadcrumb );
            if ( isset( $scripture )  && isset( $arrows ) ) {
                $view->setVar( 'scripture', $scripture )
                     ->setVar( 'verses', $verses )
                     ->setVar( 'arrows', $arrows )
                     ->setVar( 'viewPath', 'scripture/view.php' );
            } else if ( isset( $book ) && isset( $volume ) && isset( $chapters ) ) {
                $view->setVar( 'book', $book )
                     ->setVar( 'volume', $volume )
                     ->setVar( 'chapters', $chapters )
                     ->setVar( 'viewPath', 'scripture/chapter-list.php' );
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

            $view->setVar( 'volumes', $array )
                 ->setVar( 'viewPath', 'scripture/book-list.php' );
            if ( isset( $active ) )
                $view->setVar( 'active', $active );
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