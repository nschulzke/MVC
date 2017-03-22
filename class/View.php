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
     * @param array $vars
     */
    public function __construct( $route, $vars = array() )
    {
        $this->vars = $vars;
        $this->route = $route;

        if ( isset( $_GET['layout'] ) && in_array( $_GET['layout'], self::VALID_LAYOUTS ) )
            $this->layout = $_GET['layout'];
        else
            $this->layout = 'layout';

        $this->vars['action'] = $this->route->getAction();
        $this->vars['controller'] = $this->route->getController();
        if (!isset($this->vars['viewPath']))
            $this->vars['viewPath'] = $this->route->getDefaultPath();

        // Validate vars
        if ( !isset( $vars['title'] ) )
            $this->vars['title'] = GlobalConfig::getAppName();
        if ( !isset( $vars['subtitle'] ) )
            $this->vars['subtitle'] = ucfirst( $this->vars['action'] );

        if ( !isset( $vars['navbar'] ) || !in_array( $vars['navbar'], self::VALID_NAVBARS ) )
            $this->vars['navbar'] = 'navbar';

        if ( !isset( $vars['footer'] ) || !in_array( $vars['footer'], self::VALID_MODALS ) )
            $this->vars['footer'] = 'footer';

        if ( !isset( $vars['modal'] ) || !in_array( $vars['modal'], self::VALID_MODALS ) )
            $this->vars['modal'] = 'modal';

        // Set up include files
        $this->vars['navbar'] .= '.php';
        $this->vars['footer'] .= '.php';
        $this->vars['modal'] .= '.php';
        $this->vars['head'] = array(
            'head.php',
            $this->vars['controller'] . '/_head.php',
            $this->vars['controller'] . '/' . $this->vars['action'] . '_head.php'
        );
        $this->vars['foot'] = array(
            'foot.php',
            $this->vars['controller'] . '/_foot.php',
            $this->vars['controller'] . '/' . $this->vars['action'] . '_foot.php'
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
     * @return string
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
            require_once $this->vars['viewPath'];
        else
            require_once __DIR__ . '/../view/' . $this->layout . '.php';
    }
}