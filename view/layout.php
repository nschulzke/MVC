<?php
$route = new Route();

$controllerHead = __DIR__ . '/' . $route->getController() . '/_head.php';
$actionHead = __DIR__ . '/' . $route->getController() . '/' . $route->getAction() . '_head.php';

$controllerFoot = __DIR__ . '/' . $route->getController() . '/_foot.php';
$actionFoot = __DIR__ . '/' . $route->getController() . '/' . $route->getAction() . '_foot.php';
?>
<html>
    <head>
        <?php
        require_once __DIR__ . '/head.php';
                        
        if (file_exists($controllerHead))
            require_once $controllerHead;
        
        if (file_exists($actionHead))
            require_once $actionHead;
        ?>
    </head>
    <body>
        <div id="main-container" class="container">
            <header>
            </header>
            
            <?php $route->get(); ?>
            
            <footer>
            </footer>
        </div>
        <div id="scripts" class="hidden">
        <?php
        require_once __DIR__ . '/foot.php';

        if (file_exists($controllerFoot))
            require_once $controllerFoot;
        
        if (file_exists($actionFoot))
            require_once $actionFoot;
        ?>
        </div>
    </body>
</html>