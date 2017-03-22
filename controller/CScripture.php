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

    static public function action_bookList ( $route, $params )
    {
        $view = new View( $route );

        $volumes = MScripture::getVolumesRepo()->findAll();
        $books = MScripture::getBooksRepo();

        $array = array();
        foreach ($volumes as $volume) /* @var Volumes $volume */
        {
            $array[$volume->getTitle()] = array();
            foreach ( $books->findBy( array( 'volumeId' => $volume->getId() ) ) as $book ) /* @var Books $book */
                $array[$volume->getTitle()][] = $book->getTitle();
        }

        $view->setVar( 'volumes', $array );
        $view->display();
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }
}