<?php
class GlobalConfig {
    private static $APP_PATH = '/planner/';
    
    private function __construct() {}
    
    private function __clone() {}
    
    public static function getAppPath()
    {
        return self::$APP_PATH;
    }

}
?>