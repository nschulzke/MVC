<?php
require_once __DIR__ . '/NavItem.php';

class Navbar
{
    private $items;

    public function __construct()
    {
        $this->items = array();
    }

    public function addItem( $name, $action, $controller, $url = null )
    {
        $this->items[] = new NavItem( $name, $action, $controller, $url );
    }

    public function getItems()
    {
        return $this->items;
    }
}