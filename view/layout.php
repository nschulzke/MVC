<?php
$route = new Route();

// Standard UI on every page
$navbar = __DIR__ . '/navbar.php';
$footer = __DIR__ . '/footer.php';

// Style sheets and other information inside <head> tags
$mainHead = __DIR__ . '/head.php';
$controllerHead = __DIR__ . '/' . $route->getController() . '/_head.php';
$actionHead = __DIR__ . '/' . $route->getController() . '/' . $route->getAction() . '_head.php';

// Scripts that will be loaded at the end of the page
$mainFoot = __DIR__ . '/foot.php';
$controllerFoot = __DIR__ . '/' . $route->getController() . '/_foot.php';
$actionFoot = __DIR__ . '/' . $route->getController() . '/' . $route->getAction() . '_foot.php';

// Title of the page, may be overwriten in $controllerHead or $actionHead
$title = GlobalConfig::getAppName();
$subtitle = ucfirst($route->getAction());
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        require_once $mainHead;
                        
        if (file_exists($controllerHead))
            require_once $controllerHead;
        
        if (file_exists($actionHead))
            require_once $actionHead;
        ?>
        <title><?= $title ?>: <?= $subtitle ?></title>
    </head>
    <body>
        <div id="main-container" class="container">
            <?php require_once $navbar ?>
            
            <?php $route->get(); ?>
            
            <?php require_once $footer ?>
        </div>
        <div id="scripts" class="hidden">
            <?php
            require_once $mainFoot;

            if (file_exists($controllerFoot))
                require_once $controllerFoot;
            
            if (file_exists($actionFoot))
                require_once $actionFoot;
            ?>
        </div>
    </body>
</html>