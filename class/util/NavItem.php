<?php namespace util;

use config\Application;

class NavItem
{
    private $name = '';
    private $action = '';
    private $controller = '';
    private $url = '';

    /**
     * NavItem constructor.
     * @param string $name The display name for the NavItem
     * @param string $controller The target controller
     * @param string $action The target action
     * @param string|null $url The url, if not just '/controller/action'
     */
    public function __construct( $name, $controller, $action, $url = '' )
    {
        $this->name = $name;
        $this->action = $action;
        $this->controller = $controller;
        if ( !isset($url) || $url == '' )
            $this->url = $this->controller . '/' . $this->action;
        else if ($url == '/')
            $this->url = '';
        else
            $this->url = $url;
    }

    /**
     * @return string The display name for the NavItem
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string The target controller
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return string The target action
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return string The target URL
     */
    public function getURL()
    {
        return Application::getAppPath( true ) . $this->url;
    }

    /**
     * @param string $controller The controller to compare to
     * @param string $action The action to compare to
     * @return bool True if we point to the same controller and action
     */
    public function equals( $controller, $action )
    {
        return $this->controller == $controller && $this->action == $action;
    }
}