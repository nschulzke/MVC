<?php namespace config;

class Application
{
    const APP_PATH = '/framework';
    const APP_NAME = 'Framework Demo';
    const APP_TITLE = 'Framework';

    const NAV_ITEMS = [
        [ 'name' => 'Home',       'controller' => 'static-pages', 'action' => 'home',    'url' => '/' ],
        [ 'name' => 'About',      'controller' => 'static-pages', 'action' => 'about',   'url' => 'about' ],
        [ 'name' => 'Scriptures', 'controller' => 'scripture',    'action' => 'default', 'url' => 'scripture' ],
        [ 'name' => 'Test',       'controller' => 'static-pages', 'action' => 'test',    'url' => 'test' ],
    ];

    /**
     * @param bool $finalSlash Whether to include a final slash in the path.
     *
     * @return string The path of the application (after the domain). Example: localhost/framework
     */
    public static function getAppPath( $finalSlash = false )
    {
        if ( $finalSlash )
            return self::APP_PATH . '/';
        else
            return self::APP_PATH;
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }
}