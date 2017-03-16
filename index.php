<?php
require_once __DIR__ . '/classes/Connection.php';
require_once __DIR__ . '/config/GlobalConfig.php';

$uri = str_replace(GlobalConfig::getAppPath(), '', $_SERVER["REQUEST_URI"]);
$uri = explode( '/', $uri, 3 );

if (isset($uri[2]))
{
    $params = $uri[2];
}
else
{
    $params = array();
}
if (isset($uri[0]) && isset($uri[1]))
{
    $controller = $uri[0];
    $action = $uri[1];
}
else if (isset($uri[0]) && $uri[0] != NULL)
{
    $controller = 'static-pages';
    $action = $uri[0];
}
else
{
    $controller = 'static-pages';
    $action = 'home';
}

require_once __DIR__ . '/view/layout.php';
?>