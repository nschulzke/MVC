<?php /* @var util\View $this */
$components = __DIR__ . '/_components/';
extract( $this->vars );
/**
 * extracted variables used here:
 * @var util\NavBar $navbar
 * @var string[]    $head
 * @var string      $title
 * @var string      $subtitle
 * @var string      $viewPath
 * @var string      $footer
 * @var string      $modal
 * @var string[]    $foot
 */
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        foreach ( $head as $item )
                  $this->includeFile( $components . $item )
        ?>
        <title><?= htmlspecialchars( $title ) ?>
            : <?= htmlspecialchars( $subtitle ) ?></title>
    </head>
    <body>
        <?php $navbar->display() ?>

        <article id="main-container" class="container">
            <?php $this->includeFile( $viewPath ) ?>
        </article>

        <?php $this->includeFile( $components . $footer ) ?>
        <?php $this->includeFile( $components . $modal ) ?>

        <div id="scripts-container" class="hidden">
            <?php
            foreach ( $foot as $item )
                      $this->includeFile( $components . $item )
            ?>
        </div>
    </body>
</html>