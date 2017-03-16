<?php
require_once '../config/DBConfig.php'

class Connection {        
    private static $instance = NULL;
    private static $dbname = DBConfig->getName();
    private static $user = DBConfig->getUser();
    private static $pass = DBConfig->getPass();

    private function __construct() {}

    private function __clone() {}

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            self::$instance = new PDO('mysql:host=localhost;dbname=' + $dbname, $user, $password, $pdo_options);
        }
        return self::$instance;
    }
}
?>