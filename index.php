<?php
// Load configuration files
require_once __DIR__ . '/config/DBConfig.php';
require_once __DIR__ . '/config/GlobalConfig.php';

// Load required classes
require_once __DIR__ . '/classes/Connection.php';

// Load controllers
require_once __DIR__ . "/controller/error.php";
require_once __DIR__ . "/controller/static-pages.php";

// Load Route class
require_once __DIR__ . '/route.php';

// Load and display view
require_once __DIR__ . '/view/layout.php';
?>