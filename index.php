<?php
// Load configuration files
require_once __DIR__ . '/config/DBConfig.php';
require_once __DIR__ . '/config/GlobalConfig.php';

// Autoload classes
foreach ( glob( __DIR__ . "/class/*.php" ) as $filename )
    require_once $filename;

// Autoload models
foreach ( glob( __DIR__ . "/model/*.php" ) as $filename )
    require_once $filename;

// Autoload controllers
foreach ( glob( __DIR__ . "/controller/*.php" ) as $filename )
    require_once $filename;

// Load and display view
$route = new Route();
$route->call();