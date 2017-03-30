<?php
extract( $this->vars );
/**
 * variables needed here:
 * @var model\MScripture $scripture
 */
?>
<?php if ( isset( $scripture ) ): ?>
    <div class="chapter-text">
        <?php foreach ( $scripture->getVerses() as $verse ): ?>
            <div class="verse">
                <span class="verse-num"><?= $verse->getNumber() ?></span>
                <span class="verse-text"><?= $verse->getText() ?></span>
            </div>
        <?php endforeach ?>
    </div>
<?php else: ?>
    <ul class="chapter-text">
        <li class="verse">
            <span class="verse-text">No chapter requested.</span>
        </li>
    </ul>
<?php endif ?>
