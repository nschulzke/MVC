<?php

class CError
{
    const ACTIONS = array(
        'html', 'json'
    );

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function action_html( $route, $params )
    {
        require_once __DIR__ . '/../view/error/html.php';
    }

    public static function action_json( $route, $params )
    {
        echo json_encode( $params );
    }
}