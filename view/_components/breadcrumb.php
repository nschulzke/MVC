<?php
extract( $this->vars );
/**
 * variables needed here:
 * @var array  $breadcrumb
 */
$activeCrumb = sizeof($breadcrumb) - 1;
?>
<ol class="breadcrumb sticky-top">
    <?php foreach ( $breadcrumb as $num => $crumb ):
        $active = $activeCrumb == $num;
        ?>
        <li class="breadcrumb-item<?= $active ? ' active' : '' ?>">
            <?= $active ? '' : '<a href="' . $crumb['path'] . '">' ?><?= $crumb['name'] ?><?= $active ? '' : '</a>' ?>
        </li>
    <?php endforeach ?>
</ol>