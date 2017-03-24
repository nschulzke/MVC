<?php namespace util;

use config\Application;

class View
{
    const VALID_LAYOUTS = array(
        'layout.php', 'none'
    );

    const VALID_NAVBARS = array(
        'navbar.php', 'none'
    );

    const VALID_MODALS = array(
        'modal.php', 'none'
    );

    const VALID_FOOTERS = array(
        'footer.php', 'none'
    );

    private $viewRoot;

    private $route;
    private $layout;
    private $vars;

    /**
     * View constructor.
     * @param Route $route The Route object for this page
     */
    public function __construct( $route )
    {
        $this->viewRoot = directory( array( 'view' ), true );
        $this->route = $route;
        if ( isset( $_GET['layout'] ) && in_array( $_GET['layout'], self::VALID_LAYOUTS ) )
            $this->layout = $_GET['layout'];
        else
            $this->layout = 'layout';

        $this->vars = array(
            'action'     => $this->route->getAction(),
            'controller' => $this->route->getController(),
            'viewPath'   => $this->route->getDefaultPath(),
            'title'      => Application::getAppName()
        );
        $this->vars += array(
            'subtitle' => ucfirst( $this->vars['action'] ),
            'navbar'   => 'navbar.php',
            'footer'   => 'footer.php',
            'modal'    => 'modal.php',
            'head'     => array(
                'head.php',
                directory( array( $this->vars['controller'], '_components', '_head.php' ) ),
                directory( array( $this->vars['controller'], '_components', $this->vars['action'] . '_head.php' ) )
            ),
            'foot'     => array(
                'foot.php',
                directory( array( $this->vars['controller'], '_components', '_foot.php' ) ),
                directory( array( $this->vars['controller'], '_components', $this->vars['action'] . '_foot.php' ) )
            ),
        );
    }

    /**
     * @param string $path The path to the view file
     * @return bool True if the path was able to be included, false otherwise
     */
    public function requireOnce( $path )
    {
        if ( file_exists( $path ) ) {
            require_once $path;
            return true;
        } else
            return false;
    }

    /**
     * Create or update a var item to be passed to the view
     * @param mixed $key
     * @param mixed $value
     * @return View $this
     */
    public function setVar( $key, $value )
    {
        $this->vars[$key] = $value;

        if ( $key == 'navbar' && !in_array( $value, self::VALID_NAVBARS ) )
            $this->vars['navbar'] = 'navbar.php';
        else if ( $key == 'footer' && !in_array( $value, self::VALID_FOOTERS ) )
            $this->vars['footer'] = 'footer.php';
        else if ( $key == 'modal' && !in_array( $value, self::VALID_MODALS ) )
            $this->vars['modal'] = 'modal.php';
        else if ( $key == 'viewPath' )
            $this->vars['viewPath'] = directory( array( $this->viewRoot, $value ) );
        return $this;
    }

    /**
     * Get the var item that will be passed to the view
     * @param mixed $key
     * @return mixed The value
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
     * Call the .php view for based on the viewPath
     */
    public function display()
    {
        if ( $this->layout == 'none' )
            require_once $this->vars['viewPath'];
        else
            require_once directory( array( $this->viewRoot, $this->layout . '.php' ) );
    }
}