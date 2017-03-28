<?php
extract( $this->vars );
/**
 * variables needed here:
 * @var model\MScripture $scripture
 * @var array            $verses
 */

include __DIR__ . '/../_components/breadcrumb.php'
?>
<div class="container chapter-view card">
    <div class="card-block">
        <div id="highlight-menu" class="card" data-verse="1">
            <input type="hidden" name="book" value="<?= $scripture->getBook()->getLdsUrl() ?>">
            <input type="hidden" name="chapter" value="<?= $scripture->getChapterNumber() ?>">
            <input type="hidden" id="activeVerse" name="verse" value="1">
            <div class="card-block">
                <a class="fa fa-link" data-toggle="modal" data-target="#dynamic-modal" data-url="<?= \config\Application::APP_PATH ?>/scripture/lookup" data-title="Scripture" data-params='["book","chapter","verse"]'></a>
                <a class="fa fa-bookmark"></a>
            </div>
        </div>
        <ul class="chapter-text">
            <?php foreach ( $scripture->getText() as $num => $text ): ?>
                <li id="verse_<?= $num ?>" data-verse="<?= $num ?>" class="verse<?= in_array( $num, $verses ) ? ' highlight' : '' ?>">
                    <span class="verse-num"><?= $num ?></span>
                    <span class="verse-text"><?= $text ?></span>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
</div>