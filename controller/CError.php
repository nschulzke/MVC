<?php

class CError
{
    public static function action_html( $route, $params )
    {
        $view = new View( $route, array( 'code' => $params['code'], 'msg' => $params['msg'] ) );
        $view->display();
    }

    public static function action_json( $route, $params )
    {
        echo json_encode( $params );
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }
}