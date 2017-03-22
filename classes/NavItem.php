<?php

class NavItem
{
    private $name = '';
    private $action = '';
    private $controller = '';
    private $url = '';

    /**
     * NavItem constructor.
     * @param string $name
     * @param string $controller
     * @param string $action
     * @param string $url
     */
    public function __construct( $name, $controller, $action, $url = '' )
    {
        $this->name = $name;
        $this->action = $action;
        $this->controller = $controller;
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getURL()
    {
        if ( $this->url === '' )
            return GlobalConfig::getAppPath( true ) . $this->controller . '/' . $this->action;
        else return GlobalConfig::getAppPath( true ) . $this->url;
    }

    /**
     * @param string $controller
     * @param string $action
     * @return bool
     */
    public function equals( $controller, $action )
    {
        return $this->controller == $controller && $this->action == $action;
    }
}