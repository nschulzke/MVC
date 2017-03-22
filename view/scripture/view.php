<?php if ( isset( $this->vars['scripture'] ) ): ?>
    <ul class="chapter-text">
        <?php foreach ( $this->vars['scripture']->getVerses() as $num => $text ): ?>
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
