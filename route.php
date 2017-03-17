<?php

class Route {
    /**
     *  Static Helper Functions
     */
    // Takes a hyphen-format controller name and returns it in CamelCase
    private static function toClass($controller)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $controller)));
    }
    // Takes an action name and converts it to the method format (usually appending a prefix)
    private static function toMethod($action)
    {
        return 'action_' . $action;
    }
    // Returns whether or not $action can be found in $controller, based on the ACTIONS constant
    private static function isAction($controller, $action)
    {
        $controllerClass = self::toClass($controller);
        
        return defined("$controllerClass::ACTIONS") && in_array($action, $controllerClass::ACTIONS);
    }
    // Calls a given $action on $controller, if it exists, otherwise calls an error
    private static function call($controller, $action, $params = array())
    {
        if (self::isAction($controller, $action))
        {
            $controllerClass = self::toClass($controller);
            $actionMethod = self::toMethod($action);
            
            $controllerClass::$actionMethod($params);
        }
        else
        {
            $viewFile = __DIR__ . '/view/' . $controller . '/' . $action . '.php';
            if (file_exists($viewFile))
            {
                require_once $viewFile;
            }
            else
            {
                self::call('error', 'html', array('code' => '404', 'msg' => 'Not found.'));
            }
        }
    }
    
    /**
     *  Class Members
     */
    private $controller = "";
    private $action = "";
    private $params = array();
    // Constructs the route object from the current URI
    public function __construct()
    {
        // Get the current URI
        $uri = str_replace(GlobalConfig::getAppPath(), '', $_SERVER["REQUEST_URI"]);
        // Explode it like so: ( $controller, $action, $params )
        $uri = explode( '/', $uri, 3 );
        // Set $params
        $this->params = array();
        if (isset($uri[2]) && $uri[2] != NULL)
        {
            $this->params = explode('/', $uri[2]);
        }

        // Set $this->controller and $this->action
        if ((isset($uri[0]) && $uri[0] != NULL) && (isset($uri[1]) && $uri[1] != NULL))
        {   // if the URI was '/controller/action'
            $this->controller = $uri[0];
            $this->action = $uri[1];
        }
        else if (isset($uri[0]) && $uri[0] != NULL)
        {   // if the URI was just '/controller'
            if (self::isAction($uri[0], 'default'))
            {   // if there's a default action, use it
                $this->controller = $uri[0];
                $this->action = 'default';
            }
            else
            {   // if there's no default, assume we're looking for a static page by that name
                $this->controller = 'static-pages';
                $this->action = $uri[0];
            }
        }
        else
        {   // if the URI was '/'
            $this->controller = 'static-pages';
            $this->action = 'home';
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
    // Call the controller and action
    public function get()
    {
        $this->call($this->controller, $this->action, $this->params);
    }
}
?>