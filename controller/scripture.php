<?php

class Scripture
{
    const ACTIONS = array(
        'view'
    );

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    static public function action_view()
    {
        if ( isset( $_GET['book'] ) && isset( $_GET['chapter'] ) ) {
            $book = $_GET['book'];
            $chapter = $_GET['chapter'];
            if ( isset( $_GET['verses'] ) && $_GET['verses'] != '' )
                $verses = explode( ',', $_GET['verses'] );
            else
                $verses = null;

            $scripture = new MScripture( $book, $chapter, $verses );

            require_once __DIR__ . '/../view/scripture/view.php';
        } else
            echo 'No chapter specified';
    }
}