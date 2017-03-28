<?php /* @var component\NavBar $this */
extract( $this->vars );
/**
 * variables needed here:
 * @var string $controller
 * @var string $action
 */
?>
<header id="navbar-container" class="container">
    <nav id="<?= $this->getId() ?>" class="navbar navbar-toggleable-sm">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#<?= $this->getId() ?>-collapse" aria-controls="<?= $this->getId() ?>-collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand"><?= \config\Application::APP_NAME ?></a>
        <div id="<?= $this->getId() ?>-collapse" class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <?php foreach ( $this->getItems() as $item ):
                    $active = $item->equals( $controller, $action );
                    ?>
                    <li class="nav-item<?= $active ? ' active' : '' ?>">
                        <a id="<?= $item->getId() ?>" class="nav-link" href="<?= $active ? '#' : $item->getURL() ?>">
                            <?= $item->getName() ?>
                        </a>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </nav>
</header>