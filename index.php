<?php
// Load configuration files
require_once __DIR__ . '/config/DBConfig.php';
require_once __DIR__ . '/config/GlobalConfig.php';

// Load required classes
require_once __DIR__ . '/classes/Connection.php';
require_once __DIR__ . '/classes/Navbar.php';
require_once __DIR__ . '/classes/View.php';

// Load models
require_once __DIR__ . '/model/Scripture.php';

// Load controllers
require_once __DIR__ . "/controller/error.php";
require_once __DIR__ . "/controller/static-pages.php";
require_once __DIR__ . "/controller/scripture.php";

// Load Route class
require_once __DIR__ . '/route.php';

// Load and display view
$route = new Route();

if (isset($_GET['layout']))
    $view = new View($route, $_GET['layout']);
else
    $view = new View($route);
$view->get();
?>