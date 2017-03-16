<html>
    <head>
        <?php
        require_once __DIR__ . '/_includes.php';
        $allIncludes = __DIR__ . '/view/' . $controller . '/_includes.php';
        $actionIncludes = __DIR__ . '/view/' . $controller . '/' . $action . '_includes.php';
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
        
        <?php require_once __DIR__ . '/../routes.php'; ?>
        
        <?php require_once __DIR__ . '/footer.php'; ?>
    </body>
</html>