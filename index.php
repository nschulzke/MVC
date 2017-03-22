<?php
// Load configuration files
require_once __DIR__ . '/config/DBConfig.php';
require_once __DIR__ . '/config/GlobalConfig.php';

// Load required classes
require_once __DIR__ . '/classes/Navbar.php';
require_once __DIR__ . '/classes/View.php';

// Load models
require_once __DIR__ . '/model/Scripture.php';

// Load controllers
require_once __DIR__ . "/controller/ErrorController.php";
require_once __DIR__ . "/controller/StaticPagesController.php";
require_once __DIR__ . "/controller/ScriptureController.php";

// Load Route class
require_once __DIR__ . '/route.php';

// Load and display view
$route = new Route();
$route->display();