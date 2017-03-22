<?php

class CScripture
{
    static public function action_lookup( $route, $params )
    {
        $view = new View( $route );
        if ( isset( $_GET['book'] ) && $_GET['book'] != '' && isset( $_GET['chapter'] ) && $_GET['chapter'] != '' ) {
            $book = $_GET['book'];
            $chapter = $_GET['chapter'];
            if ( isset( $_GET['verses'] ) && $_GET['verses'] != '' )
                $verses = explode( ',', $_GET['verses'] );
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
        $verses = array();
        if ( isset( $_GET['book'] ) && $_GET['book'] != '' && isset( $_GET['chapter'] ) && $_GET['chapter'] != '' ) {
            $book = $_GET['book'];
            $chapter = $_GET['chapter'];
            if ( isset( $_GET['verses'] ) && $_GET['verses'] != '' )
                $verses = explode( ',', $_GET['verses'] );
        }
        else if ( isset( $params[0] ) && isset( $params[1]) ) {
            $book = $params[0];
            $chapter = $params[1];
            if ( isset( $params[2] ) && $params[2] != '' )
                $verses = explode( ',', $params[2] );
        }
        else return;

        $verses = MScripture::explodeRanges($verses);

        $scripture = new MScripture( $book, $chapter );

        $view->setVar( 'scripture', $scripture )
             ->setVar( 'verses', $verses );
        $view->display();
    }

    static public function action_bookList( $route, $params )
    {
        if ( isset( $_GET['volume'] ) && is_numeric( $_GET['volume'] ) )
            $active = MScripture::getVolumesRepo()->find( $_GET['volume'] );

        $view = new View( $route );

        $volumes = MScripture::getVolumesRepo()->findAll();
        $books = MScripture::getBooksRepo();

        $array = array();
        foreach ( $volumes as $volume ) /* @var Volumes $volume */ {
            $array[$volume->getTitle()] = array();
            foreach ( $books->findBy( array( 'volumeId' => $volume->getId() ) ) as $book ) /* @var Books $book */ {
                $array[$volume->getTitle()][$book->getId()] = $book->getTitle();
            }
        }

        $view->setVar( 'volumes', $array )
             ->setVar( 'active', $active->getTitle() );
        $view->display();
    }

    static public function action_chapterList( $route, $params )
    {
        if ( isset( $_GET['book'] ) && is_numeric( $_GET['book'] ) ) {
            $view = new View( $route );

            $book = MScripture::getBooksRepo()->find( $_GET['book'] );
            /* @var Books $book */
            $volume = MScripture::getVolumesRepo()->find( $book->getVolumeId() );
            $chapters = MScripture::getChaptersRepo()->findBy( array( 'bookId' => $book->getId() ) );

            $view->setVar( 'book', $book )
                 ->setVar( 'volume', $volume )
                 ->setVar( 'chapters', $chapters );
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