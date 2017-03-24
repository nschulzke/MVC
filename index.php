<?php
/**
 * AutoLoader
 * Namespaces we use:
 *      \class\*
 *      \config\*
 *      \controller\*
 *      \model\*
 * Other directories should not contain classes
 */
require_once __DIR__ . '/vendor/autoload.php';

function directory( $array = array(), $root = true )
{
    if ( $root )
        $retString = __DIR__;
    else
        $retString = '';
    foreach ( $array as $item )
        $retString .= DIRECTORY_SEPARATOR . $item;
    return $retString;
}

spl_autoload_register( function ( $className ) {
    $className = ltrim( $className, '\\' );
    $fileName = 'class' . DIRECTORY_SEPARATOR;
    if ( $lastNsPos = strrpos( $className, '\\' ) ) {       // Find the last backslash
        $namespace = substr( $className, 0, $lastNsPos );   // Everything to the left is the namespace
        $className = substr( $className, $lastNsPos + 1 );  // Everything to the right is the class name
        $fileName .= str_replace( '\\', DIRECTORY_SEPARATOR, $namespace ) . DIRECTORY_SEPARATOR; // Convert to path
    }
    $fileName .= $className . '.php';   // Append ClassName.php

    require $fileName;
} );

// Load and display view
$route = new \util\Route();
$route->call();