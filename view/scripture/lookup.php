<?php
extract( $this->vars );
/**
 * variables needed here:
 * @var model\MScripture $scripture
 */
?>
<?php if ( isset( $scripture ) ): ?>
    <ul class="chapter-text">
        <?php foreach ( $scripture->getText() as $num => $text ): ?>
            <li class="verse">
                <span class="verse-num"><?= $num ?></span>
                <span class="verse-text"><?= $text ?></span>
            </li>
        <?php endforeach ?>
    </ul>
<?php else: ?>
    <ul class="chapter-text">
        <li class="verse">
            <span class="verse-text">No chapter requested.</span>
        </li>
    </ul>
<?php endif ?>
