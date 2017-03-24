<?php namespace config;

class Database
{
    private static $HOST = 'localhost';
    private static $NAME = 'scriptures';
    private static $USER = 'root';
    private static $PASS = '';

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * @return string The host parameter for database connection
     */
    public static function getHost()
    {
        return self::$HOST;
    }

    /**
     * @return string The dbname parameter for database connection
     */
    public static function getName()
    {
        return self::$NAME;
    }

    /**
     * @return string The username to use to connect
     */
    public static function getUser()
    {
        return self::$USER;
    }

    /**
     * @return string The password to use to connect
     */
    public static function getPass()
    {
        return self::$PASS;
    }
}