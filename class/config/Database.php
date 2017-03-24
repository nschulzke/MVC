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

    public static function getHost()
    {
        return self::$HOST;
    }

    public static function getName()
    {
        return self::$NAME;
    }

    public static function getUser()
    {
        return self::$USER;
    }

    public static function getPass()
    {
        return self::$PASS;
    }
}