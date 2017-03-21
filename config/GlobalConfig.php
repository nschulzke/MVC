<?php
class GlobalConfig {
    private static $APP_PATH = '/planner';
    
    private function __construct() {}
    
    private function __clone() {}
    
    public static function getAppPath($finalSlash = false)
    {
        if ($finalSlash)
            return self::$APP_PATH . '/';
        else
            return self::$APP_PATH;
    }

}
?>