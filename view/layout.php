<?php
$route = new Route();
?>
<html>
    <head>
        <?php
        require_once __DIR__ . '/_includes.php';
                        
        $controllerIncludes = __DIR__ . '/' . $route->getController() . '/_includes.php';
        $actionIncludes = __DIR__ . '/' . $route->getController() . '/' . $route->getAction() . '_includes.php';

        if (file_exists($controllerIncludes))
            require_once $controllerIncludes;
        
        if (file_exists($actionIncludes))
            require_once $actionIncludes;
        ?>
    </head>
    <body>
        <div class="container">
            <header>
            </header>
            
            <?php $route->get(); ?>
            
            <footer>
            </footer>
        </div>
    </body>
</html>