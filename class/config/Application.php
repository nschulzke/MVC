<?php namespace config;

class Application
{
    private static $APP_PATH = '/framework';
    private static $APP_NAME = 'Framework Demo';

    /**
     * @param bool $finalSlash Whether to include a final slash in the path.
     *
     * @return string The path of the application (after the domain). Example: localhost/framework
     */
    public static function getAppPath( $finalSlash = false )
    {
        if ( $finalSlash )
            return self::$APP_PATH . '/';
        else
            return self::$APP_PATH;
    }

    /**
     * @return string The name of the application, for display.
     */
    public static function getAppName()
    {
        return self::$APP_NAME;
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }
}