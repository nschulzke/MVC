<?php namespace util\component;

use config\Application;

class NavBar
{
    public static $usedIds = [];

    private $items = [];
    private $id = '';
    private $vars = [];

    public function __construct( $navId, $vars, $default = false )
    {
        if ( $default ) {
            foreach ( Application::NAV_ITEMS as $item )
                $this->addItem( $item['name'], $item['controller'], $item['action'], $item['url'] );
        }
        $this->vars = $vars;
        $this->uniqueId( $navId );
    }

    /**
     * @param integer $id       The id to use
     * @param string  $idPrefix The prefix to attach to the id, if any
     */
    private function uniqueId( $id, $idPrefix = '' )
    {
        $this->id = $idPrefix . strtolower( $id );
        if ( in_array( $this->id, self::$usedIds ) ) {
            $num = 2;
            while ( in_array( $this->id . $num, self::$usedIds ) )
                $num++;
            $this->id = $this->id . $num;
        }
        self::$usedIds[] = $this->id;
    }

    /**
     * @param string $name       The display name for the NavItem
     * @param string $controller The target controller
     * @param string $action     The target action
     * @param string $url        The url, if not just '/controller/action'
     */
    public function addItem( $name, $controller, $action, $url = '' )
    {
        $this->items[] = new NavItem( $name, $controller, $action, $url, $this->getId() );
    }

    /**
     * @return NavItem[] The array of NavItems
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return string The id
     */
    public function getId()
    {
        return $this->id;
    }

    public function display()
    {
        include directory( [ 'view', '_components', 'navbar.php' ], true );
    }
}