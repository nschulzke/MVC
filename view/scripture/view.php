<?php
require_once __DIR__ . '/../_components/breadcrumb.php'
?>

<div id="highlight-menu" class="card">
    <div class="card-block">
        <a class="fa fa-link"></a>
        <a class="fa fa-bookmark"></a>
    </div>
</div>
<div class="container chapter-view">
    <ul class="chapter-text">
        <?php foreach ( $this->vars['scripture']->getText() as $num => $text ): ?>
        <li class="verse<?= in_array($num, $this->vars['verses']) ? ' highlight' : ''?>">
            <span class="verse-num"><?= $num ?></span>
            <span class="verse-text"><?= $text ?></span>
        </li>
        <?php endforeach ?>
    </ul>
</div>
<script src="<?= GlobalConfig::getAppPath() ?>/rsc/js/highlight.js"></script>