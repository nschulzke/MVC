<?php
class Error
{
    const ACTIONS = array (
        'html', 'json'
    );
    
    private function __construct() {}
    
    private function __clone() {}
    
    public static function action_html($params)
    {
        require_once __DIR__ . '/../view/error/html.php';
    }
    
    public static function action_json($params)
    {
        echo json_encode($params);
    }
}
?>