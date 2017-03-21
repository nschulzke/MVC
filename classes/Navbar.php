<?php
class Navitem
{
    private $name;
    private $action;
    private $controller;
    private $url;
    
    public function __construct($name, $controller, $action, $url = null)
    {
        $this->name = $name;
        $this->action = $action;
        $this->controller = $controller;
        $this->url = $url;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getAction()
    {
        return $this->action;
    }
    
    public function getController()
    {
        return $this->controller;
    }
    
    public function getURL()
    {
        if ($this->url === null)
            return GlobalConfig::getAppPath(true) . $this->controller . '/' . $this->action;
        else return GlobalConfig::getAppPath(true) . $this->url;
    }
    
    public function equals($controller, $action)
    {
        return $this->controller == $controller && $this->action == $action;
    }
}

class Navbar
{
    private $items;
    
    public function __construct()
    {
        $this->items = array();
    }
    
    public function addItem($name, $action, $controller, $url = null)
    {
        $this->items[] = new Navitem($name, $action, $controller, $url);
    }
    
    public function getItems()
    {
        return $this->items;
    }
}
?>