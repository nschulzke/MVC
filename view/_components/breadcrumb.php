<?php
extract( $this->vars );
/**
 * variables needed here:
 * @var array  $breadcrumb
 * @var string $activeCrumb
 */
?>
<ol class="breadcrumb sticky-top">
    <?php foreach ( $breadcrumb as $name => $path ):
        $active = $activeCrumb == $name;
        ?>
        <li class="breadcrumb-item<?= $active ? ' active' : '' ?>">
            <?= $active ? '' : '<a href="' . $path . '">' ?><?= $name ?><?= $active ? '' : '</a>' ?>
        </li>
    <?php endforeach ?>
</ol>