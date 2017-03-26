<?php namespace config;

class Database
{
    const DRIVER = 'pdo_mysql';
    const DBNAME = 'scriptures';
    const HOST = 'localhost';
    const USER = 'root';
    const PASSWORD = '';
    
    private function __construct()
    {
    }
    
    private function __clone()
    {
    }
}