<?php namespace component;

use config\Application;

class NavItem
{
    public static $usedIds = [];

    private $name = '';
    private $action = '';
    private $controller = '';
    private $url = '';
    private $id = '';

    /**
     * NavItem constructor.
     *
     * @param string      $name       The display name for the NavItem
     * @param string      $controller The target controller
     * @param string      $action     The target action
     * @param string|null $url        The url, if not just '/controller/action'
     * @param string      $idPrefix   The prefix to put onto the id, typically the nav name
     */
    public function __construct( $name, $controller, $action, $url = '', $idPrefix = '' )
    {
        $this->name = $name;
        $this->action = $action;
        $this->controller = $controller;
        if ( !isset( $url ) || $url == '' )
            $this->url = $this->controller . '/' . $this->action;
        else if ( $url == '/' )
            $this->url = '';
        else
            $this->url = $url;

        $this->uniqueId( $name, $idPrefix );
    }

    /**
     * @param integer $id       The id to use
     * @param string  $idPrefix The prefix to attach to the id, if any
     */
    private function uniqueId( $id, $idPrefix = '' )
    {
        $this->id = $idPrefix . '-' . strtolower( $id );
        if ( in_array( $this->id, self::$usedIds ) ) {
            $num = 2;
            while ( in_array( $this->id . $num, self::$usedIds ) )
                $num++;
            $this->id = $this->id . $num;
        }
        self::$usedIds[] = $this->id;
    }

    /**
     * @return string The id
     */
    public function getId()
    {
        return $this->id;
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
     * @param string $action     The action to compare to
     *
     * @return bool True if we point to the same controller and action
     */
    public function equals( $controller, $action )
    {
        return $this->controller == $controller && $this->action == $action;
    }
}