<?php /* @var util\View $this */
use component\NavBar;

$components = __DIR__ . '/_components/';
extract( $this->vars );
/**
 * extracted variables used here:
 * @var NavBar $navbar
 * @var string $head
 * @var string $title
 * @var string $subtitle
 * @var string $viewPath
 * @var string $footer
 * @var string $modal
 */
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $this->includeFile( $components . $head ) ?>
        <title><?= htmlspecialchars( $title ) ?>
            : <?= htmlspecialchars( $subtitle ) ?></title>
    </head>
    <body>
        <div class="container-fluid">
            <?php $navbar->display() ?>
            
            <article id="main-container" class="container">
                <?php $this->includeFile( $viewPath ) ?>
            </article>
            
            <?php $this->includeFile( $components . $footer ) ?>
            <?php $this->includeFile( $components . $modal ) ?>
        </div>
    </body>
</html>