<?php
// Load configuration files
require_once __DIR__ . '/config/DBConfig.php';
require_once __DIR__ . '/config/GlobalConfig.php';

// Load required classes
require_once __DIR__ . '/classes/Connection.php';
require_once __DIR__ . '/classes/Navbar.php';
require_once __DIR__ . '/classes/View.php';

// Load controllers
require_once __DIR__ . "/controller/error.php";
require_once __DIR__ . "/controller/static-pages.php";

// Load Route class
require_once __DIR__ . '/route.php';

// Load and display view
$route = new Route();

$layout = 'layout';
if (isset($_GET['layout']) && in_array($_GET['layout'], View::VALID_LAYOUTS))
    $layout = $_GET['layout'];
    
$view = new View($route, $layout, array());
$view->get();
?>