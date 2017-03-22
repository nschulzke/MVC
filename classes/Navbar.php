<?php
require_once __DIR__ . '/NavItem.php';

class Navbar
{
    /**
     * @param string $name The display name for the NavItem
     * @param string $controller The target controller
     * @param string $action The target action
     * @param string $url The url, if not just '/controller/action'
     */
    public function addItem( $name, $controller, $action, $url = '' )
    {
        $this->items[] = new NavItem( $name, $controller, $action, $url );
    }

    private $items = array();

    /**
     * Navbar constructor.
     */
    public function __construct()
    {
        $this->items = array();
    }

    /**
     * @return NavItem[] The array of NavItems
     */
    public function getItems()
    {
        return $this->items;
    }
}