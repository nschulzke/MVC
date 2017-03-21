<?php
$route = new Route();
?>
<html>
    <head>
        <?php
        require_once __DIR__ . '/_includes.php';
                        
        $allIncludes = __DIR__ . '/view/' . $route->getController() . '/_includes.php';
        $actionIncludes = __DIR__ . '/view/' . $route->getController() . '/' . $route->getAction() . '_includes.php';

        if (file_exists($allIncludes))
        {
            require_once $allIncludes;
        }
        if (file_exists($actionIncludes))
        {
            require_once $actionIncludes;
        }
        ?>
    </head>
    <body>
        <?php require_once __DIR__ . '/header.php'; ?>
        
        <?php $route->get(); ?>
        
        <?php require_once __DIR__ . '/footer.php'; ?>
    </body>
</html>