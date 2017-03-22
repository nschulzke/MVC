<?php
require_once __DIR__ . '/NavItem.php';

class Navbar
{
    private $items = array();

    /**
     * Navbar constructor.
     */
    public function __construct()
    {
        $this->items = array();
    }

    /**
     * @param string $name
     * @param string $action
     * @param string $controller
     * @param string $url
     */
    public function addItem( $name, $action, $controller, $url = '' )
    {
        $this->items[] = new NavItem( $name, $action, $controller, $url );
    }

    /**
     * @return NavItem[]
     */
    public function getItems()
    {
        return $this->items;
    }
}