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
    
    const VIEW_VARS = [
        'title'  => Application::APP_TITLE,
        'footer' => 'footer.php',
        'modal'  => 'modal.php',
        'head'   => 'head.php',
    ];

    private function __construct()
    {
    }

    private function __clone()
    {
    }
}