<?php
extract( $this->vars );
/**
 * variables needed here:
 * @var model\orm\entity\Verse $verse
 */
?>
<?php if ( isset( $verse ) ): ?>
    <div class="chapter-text">
        <ul>
        <?php foreach ( $verse->getFootnotes() as $footnote ): ?>
            <li><?= $footnote->getScripture()->getReference() ?></li>
        <?php endforeach ?>
        </ul>
    </div>
<?php else: ?>
    <ul class="chapter-text">
        <li class="verse">
            <span class="verse-text">No verse requested.</span>
        </li>
    </ul>
<?php endif ?>
