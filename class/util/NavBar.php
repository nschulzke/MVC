<?php namespace util;

class NavBar
{
    private $items = array();

    /**
     * @param string $name       The display name for the NavItem
     * @param string $controller The target controller
     * @param string $action     The target action
     * @param string $url        The url, if not just '/controller/action'
     */
    public function addItem( $name, $controller, $action, $url = '' )
    {
        $this->items[] = new NavItem( $name, $controller, $action, $url );
    }

    /**
     * @return NavItem[] The array of NavItems
     */
    public function getItems()
    {
        return $this->items;
    }
}