<?php
foreach (glob(__DIR__ . "/controller/*.php") as $filename)
{
    require_once $filename;
}

require_once __DIR__ . '/classes/Connection.php';
require_once __DIR__ . '/config/GlobalConfig.php';

require_once __DIR__ . '/view/layout.php';
?>