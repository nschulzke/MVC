<?php namespace util;

use config\Application;

class Route
{
    // Takes a hyphen-format controller name and returns it in CamelCase
    private static function toClass( $controller )
    {
        $classString = str_replace( ' ', '', ucwords( str_replace( '-', ' ', $controller ) ) );
        
        return 'controller\\' . $classString;
    }
    
    // Takes an action name and converts it to the method format (usually appending a prefix)
    private static function toMethod( $action )
    {
        $actionString = str_replace( ' ', '', ucwords( str_replace( '-', ' ', $action ) ) );
        $actionString[0] = strtolower( $actionString[0] );
        
        return 'action_' . $actionString;
    }
    
    // Returns whether or not $action can be found in $controller, based on the ACTIONS constant
    private static function isAction( $controller, $action )
    {
        $controllerClass = self::toClass( $controller );
        $actionMethod = self::toMethod( $action );
        
        return class_exists( $controllerClass ) && is_callable( "$controllerClass::$actionMethod" );
    }
    
    /**
     *  Class Members
     */
    private $controller = '';
    private $action = '';
    private $uri = '';
    private $params = [];
    
    // Calls a given $action on $controller, if it exists, otherwise calls an error
    public function call()
    {
        $controllerClass = self::toClass( $this->controller );
        $actionMethod = self::toMethod( $this->action );
        
        $controllerClass::$actionMethod( $this, $this->params );
    }
    
    // Constructs the route object from the current URI
    public function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'];
        // Get the current URI, clean it up to be ready
        $uri = str_replace( Application::APP_PATH, '', $this->uri );
        $uri = preg_replace( '#\?(.*)$#', '', ltrim( $uri, '/' ) );
        // Explode it like so: ( $controller, $action, $params )
        $split = explode( '/', $uri, 3 );
        $oneWide = false;
        
        // Set $this->controller and $this->action
        if ( ( isset( $split[0] ) && $split[0] != null ) && ( isset( $split[1] ) && $split[1] != null ) ) {   // if the URI was '/controller/action'
            $this->controller = $split[0];
            if ( !self::isAction( $this->controller, $split[1] ) && self::isAction( $this->controller, 'default' ) ) {
                $this->action = 'default';
                $oneWide = true;
            } else
                $this->action = $split[1];
        } else if ( isset( $split[0] ) && $split[0] != null ) {   // if there's no default, assume we're looking for a static page by that name
            if ( self::isAction( $split[0], 'default' ) ) {
                $this->controller = $split[0];
                $this->action = 'default';
            } else {
                $this->controller = 'static-pages';
                $this->action = $split[0];
            }
        } else {   // if the URI was '/'
            $this->controller = 'static-pages';
            $this->action = 'home';
        }
        
        if ( $oneWide )
            $this->params = explode( '/', explode( '/', $uri, 2 )[1] );
        else if ( isset( $split[2] ) )
            $this->params = explode( '/', $split[2] );
        
        if ( !self::isAction( $this->controller, $this->action ) ) {
            $this->params = [ 'code' => '404', 'msg' => 'File not found: /' . $this->controller . '/' . $this->action ];
            $this->controller = 'error';
            $this->action = 'html';
        }
    }
    
    // Return the name of the controller
    public function getController()
    {
        return $this->controller;
    }
    
    // Return the name of the action
    public function getAction()
    {
        return $this->action;
    }
    
    // Return the params
    public function getParams()
    {
        return $this->params;
    }
    
    // Return the params
    public function getURI()
    {
        return $this->uri;
    }
    
    public function getDefaultPath()
    {
        return directory( [ 'view', $this->controller, $this->action . '.php' ], true );
    }
}