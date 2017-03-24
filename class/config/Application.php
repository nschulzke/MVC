<?php namespace config;

class Application
{
    private static $DOC_ROOT = __DIR__ . '/../..';
    private static $APP_PATH = '/framework';
    private static $APP_NAME = 'Framework Demo';

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getAppPath( $finalSlash = false )
    {
        if ( $finalSlash )
            return self::$APP_PATH . '/';
        else
            return self::$APP_PATH;
    }

    public static function getDocRoot( $finalSlash = false )
    {
        if ( $finalSlash )
            return self::$DOC_ROOT . '/';
        else
            return self::$DOC_ROOT;
    }

    public static function getAppName()
    {
        return self::$APP_NAME;
    }
}