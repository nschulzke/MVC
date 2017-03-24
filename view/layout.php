<?php
$components = __DIR__ . '/_components/';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        foreach ( $this->vars['head'] as $head )
                  $this->requireOnce( $components . $head )
        ?>
        <title><?= htmlspecialchars( $this->vars['title'] ) ?>
            : <?= htmlspecialchars( $this->vars['subtitle'] ) ?></title>
    </head>
    <body>
        <?php $this->requireOnce( $components . $this->vars['navbar'] ) ?>

        <article id="main-container" class="container">
            <?php $this->requireOnce($this->vars['viewPath']) ?>
        </article>

        <?php $this->requireOnce( $components . $this->vars['footer'] ) ?>
        <?php $this->requireOnce( $components . $this->vars['modal'] ) ?>

        <div id="scripts" class="hidden">
            <?php
            foreach ( $this->vars['foot'] as $foot )
                      $this->requireOnce( $components . $foot )
            ?>
        </div>
    </body>
</html>