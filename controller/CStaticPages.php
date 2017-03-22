<?php

class CStaticPages
{
    public static function action_home( $route, $params )
    {
        $view = new View( $route );
        $view->display();
    }

    public static function action_about( $route, $params )
    {
        $view = new View( $route );
        $view->display();
    }

    public static function action_test( $route, $params )
    {
        $view = new View( $route );
        $view->display();
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }
}