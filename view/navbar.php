<?php
$bar = new Navbar();
$bar->addItem('Home', 'static-pages', 'home', '');
$bar->addItem('About', 'static-page', 'about', 'about');
?>
<header class="navbar navbar-default">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span> 
        </button>
        <a class="navbar-brand" href="#"><?= GlobalConfig::getAppName() ?></a>
    </div>
    <nav id="main-navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
        <?php foreach ($bar->getItems() as $item):
            $active = $item->equals($route->getController(), $route->getAction());
        ?>
            <li <?= $active ? 'class="active"' : '' ?>>
                <a href="<?= $active ? '#' : $item->getURL() ?>">
                    <?= $item->getName() ?>
                </a>
            </li>
        <?php endforeach ?>
        </ul>
    </nav>
</header>