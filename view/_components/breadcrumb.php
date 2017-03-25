<?php
extract( $this->vars );
/**
 * variables needed here:
 * @var array  $breadcrumb
 * @var array $arrows
 */
$activeCrumb = sizeof($breadcrumb) - 1;
?>
<ol class="breadcrumb sticky-top">
    <?php foreach ( $breadcrumb as $num => $crumb ):
        $active = $activeCrumb == $num;
        ?>
        <li class="breadcrumb-item<?= $active ? ' active' : '' ?>">
            <?php if ( $active ): ?>
                <?= $crumb['name'] ?>
            <?php else: ?>
                <a href="<?= $crumb['path'] ?>" class="ajax-link"><?= $crumb['name'] ?></a>
            <?php endif ?>
        </li>
    <?php endforeach ?>
    <?php if ( isset($arrows) ): ?>
        <li class="float-right breadcrumb-arrows">
            <a <?= isset($arrows['left']) ? 'href="' . $arrows['left'] . '"' : '' ?> class="fa fa-arrow-left ajax-link"></a>
            <a <?= isset($arrows['right']) ? 'href="' . $arrows['right'] . '"' : '' ?> class="fa fa-arrow-right ajax-link"></a>
        </li>
    <?php endif ?>
</ol>