<?php
$dir = __DIR__ . '/';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        foreach ( $this->vars['head'] as $head )
                  $this->requireOnce( $dir . $head )
        ?>
        <title><?= htmlspecialchars( $this->vars['title'] ) ?>
            : <?= htmlspecialchars( $this->vars['subtitle'] ) ?></title>
    </head>
    <body>
        <?php $this->requireOnce( $dir . $this->vars['navbar'] ) ?>

        <article id="main-container" class="container">
            <?php $this->requireOnce($this->vars['viewPath']) ?>
        </article>

        <?php $this->requireOnce( $dir . $this->vars['footer'] ) ?>
        <?php $this->requireOnce( $dir . $this->vars['modal'] ) ?>

        <div id="scripts" class="hidden">
            <?php
            foreach ( $this->vars['foot'] as $foot )
                      $this->requireOnce( $dir . $foot )
            ?>
        </div>
    </body>
</html>