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
            <ul class="pagination float-right">
                <li class="page-item<?= !isset($arrows['left']) ? ' disabled' : '' ?>">
                    <a class="page-link ajax-link" <?= isset($arrows['left']) ? 'href="' . $arrows['left'] . '"' : '' ?> aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
                <li class="page-item<?= !isset($arrows['right']) ? ' disabled' : '' ?>">
                    <a class="page-link ajax-link" <?= isset($arrows['right']) ? 'href="' . $arrows['right'] . '"' : '' ?> aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            </ul>
    <?php endif ?>
</ol>