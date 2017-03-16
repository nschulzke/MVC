<?php
/**
 *  Functions
 */
function getClass($controller)
{
    return str_replace(' ', '', ucwords(str_replace('-', ' ', $controller)));
}

function getMethod($action)
{
    return 'action_' . $action;
}

function error()
{
    call('static-pages', 'error');
}

function call($controller, $action) {
    require_once __DIR__ . '/controller/' . $controller . '.php';
    
    $controllerClass = getClass($controller);
    $actionMethod = getMethod($action);
    
    if (method_exists($controllerClass, $actionMethod))
    {
        $controllerClass::$actionMethod();
    }
    else
    {
        $viewFile = __DIR__ . '/view/' . $controller . '/' . $action . '.php';
        if (file_exists($viewFile))
        {
            require_once $viewFile;
        }
        else
        {
            error();
        }
    }
}

call($controller, $action);

?>