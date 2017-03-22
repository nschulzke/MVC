<?php

class Connection
{
    private static $instance = NULL;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
        if ( !isset( self::$instance ) ) {
            $pdo[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            $conn = 'mysql:host=' . DBConfig::getHost() . ';dbname=' . DBConfig::getName();

            self::$instance = new PDO( $conn, DBConfig::getUser(), DBConfig::getPass(), $pdo_options );
        }
        return self::$instance;
    }
}