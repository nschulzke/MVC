<?php

class CError
{
    public static function action_html( $route, $params )
    {
        $view = new View( $route );
        $view->setVar( 'code', $params['code'] )
             ->setVar( 'msg', $params['msg'] );
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