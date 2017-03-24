<?php
extract( $this->vars );
/**
 * variables needed here:
 * @var model\MScripture $scripture
 * @var array            $verses
 */

include __DIR__ . '/../_components/breadcrumb.php'
?>

<div id="highlight-menu" class="card">
    <div class="card-block">
        <a class="fa fa-link"></a>
        <a class="fa fa-bookmark"></a>
    </div>
</div>
<div class="container chapter-view">
    <ul class="chapter-text">
        <?php foreach ( $scripture->getText() as $num => $text ): ?>
            <li class="verse<?= in_array( $num, $verses ) ? ' highlight' : '' ?>">
                <span class="verse-num"><?= $num ?></span>
                <span class="verse-text"><?= $text ?></span>
            </li>
        <?php endforeach ?>
    </ul>
</div>
<script src="<?= \config\Application::getAppPath() ?>/rsc/js/highlight.js"></script>