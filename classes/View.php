<?php

class View
{
    const VALID_LAYOUTS = array(
        'layout', 'none'
    );

    const VALID_NAVBARS = array(
        'navbar', 'none'
    );

    const VALID_MODALS = array(
        'modal', 'none'
    );

    const VALID_FOOTERS = array(
        'footer', 'none'
    );

    private $route;
    private $layout;
    private $vars;

    /**
     * View constructor.
     * @param Route $route
     * @param string $layout
     * @param array $vars
     */
    public function __construct( $route, $layout = 'layout', $vars = array() )
    {
        $this->vars = $vars;
        $this->route = $route;

        // Validate vars
        if ( in_array( $layout, self::VALID_LAYOUTS ) )
            $this->layout = $layout;
        else
            $this->layout = 'layout';

        if ( !isset( $vars['title'] ) )
            $this->vars['title'] = GlobalConfig::getAppName();
        if ( !isset( $vars['subtitle'] ) )
            $this->vars['subtitle'] = ucfirst( $this->route->getAction() );

        if ( !isset( $vars['navbar'] ) || !in_array( $vars['navbar'], self::VALID_NAVBARS ) )
            $this->vars['navbar'] = 'navbar';

        if ( !isset( $vars['footer'] ) || !in_array( $vars['footer'], self::VALID_MODALS ) )
            $this->vars['footer'] = 'footer';

        if ( !isset( $vars['modal'] ) || !in_array( $vars['modal'], self::VALID_MODALS ) )
            $this->vars['modal'] = 'modal';

        // Set up include files
        $this->vars['navbar'] .= '.php';
        $this->vars['viewPath'] = $this->route->getPath();
        $this->vars['footer'] .= '.php';
        $this->vars['modal'] .= '.php';
        $this->vars['head'] = array(
            'head.php',
            $this->route->getController() . '/_head.php',
            $this->route->getController() . '/' . $this->route->getAction() . '_head.php'
        );
        $this->vars['foot'] = array(
            'foot.php',
            $this->route->getController() . '/_foot.php',
            $this->route->getController() . '/' . $this->route->getAction() . '_foot.php'
        );
    }

    /**
     * @param string $path
     * @return bool
     */
    private function requireOnce( $path )
    {
        if ( file_exists( $path ) ) {
            require_once $path;
            return true;
        } else
            return false;
    }

    /**
     * @param mixed $key
     * @param mixed $value
     */
    public function setVar( $key, $value )
    {
        $this->vars[$key] = $value;
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function getVar( $key )
    {
        return $this->vars[$key];
    }

    /**
     * @return Route
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     *
     */
    public function display()
    {
        if ( $this->layout == 'none' )
            require_once $this->route->getPath();
        else
            require_once __DIR__ . '/../view/' . $this->layout . '.php';
    }
}