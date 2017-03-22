<div class="chapter-view">
    <ul class="chapter-text">
        <?php foreach ( $this->vars['scripture']->getVerses() as $num => $text ): ?>
        <li class="verse<?= in_array($num, $this->vars['verses']) ? ' highlight' : ''?>">
            <span class="verse-num"><?= $num ?></span>
            <span class="verse-text"><?= $text ?></span>
        </li>
        <?php endforeach ?>
    </ul>
</div>