<?php
/**
 * Use this function to form complicated or root-based paths. Not necessary for relative paths.
 *
 * @param array $array The breadcrumb trail (strings)
 * @param bool  $root  Whether to start at the root or just build a path
 *
 * @return string The path
 */
function directory( $array = [], $root = false )
{
    if ( $root )
        $start = __DIR__ . DIRECTORY_SEPARATOR;
    else
        $start = '';
    
    return $start . implode( DIRECTORY_SEPARATOR, $array );
}

function url( $array = [], $getVars = [] )
{
    $url = implode( '/', $array );
    
    if ( sizeof( $getVars ) > 0 )
        $url .= '?';
    foreach ( $getVars as $key => $value )
        $url .= $key . '=' . $value . '&';
    $url = rtrim( $url, '&' );
    
    return $url;
}

/**
 * AutoLoader
 * Namespaces we use:
 *      \class\*
 *      \config\*
 *      \controller\*
 *      \model\*
 * Other directories should not contain classes
 */
spl_autoload_register( function ( $className ) {
    $className = ltrim( $className, '\\' );
    $fileName = 'class' . DIRECTORY_SEPARATOR;
    if ( $lastNsPos = strrpos( $className, '\\' ) ) {       // Find the last backslash
        $namespace = substr( $className, 0, $lastNsPos );   // Everything to the left is the namespace
        $className = substr( $className, $lastNsPos + 1 );  // Everything to the right is the class name
        $fileName .= str_replace( '\\', DIRECTORY_SEPARATOR, $namespace ) . DIRECTORY_SEPARATOR; // Convert to path
    }
    $fileName .= $className . '.php';   // Append ClassName.php
    
    // Only require the file if it exists, otherwise just let the class error get thrown
    // This is needed for our controller checks in Route
    if ( file_exists( $fileName ) )
        require $fileName;
} );

require_once directory( [ 'vendor', 'autoload.php' ], true );