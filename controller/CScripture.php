<?php

class CScripture
{
    static public function action_view( $route, $params )
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

    private function __construct()
    {
    }

    private function __clone()
    {
    }
}