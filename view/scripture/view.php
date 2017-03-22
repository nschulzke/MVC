<?php if ( isset( $scripture ) ): ?>
    <ul class="chapter-text">
        <?php foreach ( $scripture->getVerses() as $num => $text ): ?>
            <li class="verse-text">
                <span class="verse-num"><?= $num ?></span>
                <span class="verse-text"><?= $text ?></span>
            </li>
        <?php endforeach ?>
    </ul>
<?php endif ?>