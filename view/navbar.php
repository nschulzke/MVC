<?php
$bar = new Navbar();
$bar->addItem( 'Home', 'static-pages', 'home', '/' );
$bar->addItem( 'About', 'static-pages', 'about', 'about' );
$bar->addItem( 'Test', 'static-pages', 'test', 'test' );
?>
<header id="navbar-container" class="container bg-faded">
    <nav class="navbar navbar-toggleable-sm navbar-light">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#main-navbar" aria-controls="main-navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand"><?= GlobalConfig::getAppName() ?></a>
        <div id="main-navbar" class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <?php foreach ( $bar->getItems() as $item ):
                    $active = $item->equals( $this->vars['controller'], $this->vars['action'] );
                    ?>
                    <li class="nav-item<?= $active ? ' active' : '' ?>">
                        <a class="nav-link" href="<?= $active ? '#' : $item->getURL() ?>">
                            <?= $item->getName() ?>
                        </a>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </nav>
</header>