<?php namespace util;

use component\NavBar;
use config\Application;

class View
{
    const VALID_LAYOUTS = [
        'layout.php', 'none',
    ];
    
    const VALID_NAVBARS = [
        'navbar.php', 'none',
    ];
    
    const VALID_MODALS = [
        'modal.php', 'none',
    ];
    
    const VALID_FOOTERS = [
        'footer.php', 'none',
    ];
    
    private $viewRoot;
    private $layout;
    private $vars;
    
    /**
     * View constructor.
     *
     * @param Route $route The Route object for this page
     */
    public function __construct( $route )
    {
        $this->viewRoot = directory( [ 'view' ], true );
        if ( isset( $_GET['layout'] ) && in_array( $_GET['layout'], self::VALID_LAYOUTS ) )
            $this->layout = $_GET['layout'];
        else
            $this->layout = 'layout';
        
        $this->vars = [
            'action'     => $route->getAction(),
            'controller' => $route->getController(),
            'viewPath'   => $route->getDefaultPath(),
            'title'      => Application::APP_NAME,
            'footer'     => 'footer.php',
            'modal'      => 'modal.php',
            'head'       => 'head.php',
        ];
        $this->vars += [ 'subtitle' => ucfirst( $this->vars['action'] ) ];
        $this->vars['navbar'] = new NavBar( 'nav-main', [ 'controller' => $this->vars['controller'], 'action' => $this->vars['action'] ], true );
    }
    
    /**
     * @param string $path The path to the view file
     *
     * @return bool True if the path was able to be included, false otherwise
     */
    public function includeFile( $path )
    {
        if ( file_exists( $path ) ) {
            include $path;
            
            return true;
        } else
            return false;
    }
    
    /**
     * Create or update a var item to be passed to the view
     *
     * @param mixed $key
     * @param mixed $value
     *
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
            $this->vars['viewPath'] = directory( [ $this->viewRoot, $value ] );
        
        return $this;
    }
    
    /**
     * @param array $array
     *
     * @return View $this
     */
    public function setVars( $array )
    {
        foreach ( $array as $key => $value )
            $this->setVar( $key, $value );
        
        return $this;
    }
    
    /**
     * Get the var item that will be passed to the view
     *
     * @param mixed $key
     *
     * @return mixed The value
     */
    public function getVar( $key )
    {
        return $this->vars[$key];
    }
    
    /**
     * Call the .php view for based on the viewPath
     */
    public function display()
    {
        if ( $this->layout == 'none' )
            include $this->vars['viewPath'];
        else
            include directory( [ $this->viewRoot, $this->layout . '.php' ] );
    }
}