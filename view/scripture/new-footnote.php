<?php
use model\orm\entity\Verse;

/* @var Verse $verse */
$verse = $this->vars['verse'];
$split = explode( ' ', $verse->getText() );
?>

<div>
    <div>
        Pick a word to link from:
    </div>
    <div class="verse">
    <?php foreach ( $split as $index => $word ): ?>
        <a href="#<?= $index ?>"><?= $word ?></a>
    <?php endforeach ?>
    </div>
</div>
