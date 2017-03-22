<?php
// Load configuration files
require_once __DIR__ . '/config/DBConfig.php';
require_once __DIR__ . '/config/GlobalConfig.php';

// Load required classes
require_once __DIR__ . '/classes/Navbar.php';
require_once __DIR__ . '/classes/View.php';

// Load models
require_once __DIR__ . '/model/MScripture.php';

// Load controllers
require_once __DIR__ . "/controller/CError.php";
require_once __DIR__ . "/controller/CStaticPages.php";
require_once __DIR__ . "/controller/CScripture.php";

// Load Route class
require_once __DIR__ . '/route.php';

// Load and display view
$route = new Route();
$route->display();