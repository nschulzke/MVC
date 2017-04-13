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
        <div id="highlight-menu" class="card">
            <input type="hidden" id="activeVerse" name="verse" value="<?= $scripture->getVerses()[0]->getId() ?>">
            <div class="card-block">
                <a class="fa fa-link" data-toggle="modal" data-target="#dynamic-modal" data-url="<?= \config\Application::APP_PATH ?>/scripture/new-footnote" data-title="Scripture" data-params='["verse"]'></a>
                <a class="fa fa-eye" data-toggle="modal" data-target="#dynamic-modal" data-url="<?= \config\Application::APP_PATH ?>/scripture/view-footnotes" data-params='["verse"]'></a>
                <a class="fa fa-bookmark"></a>
            </div>
        </div>
        <ul class="chapter-text">
            <?php foreach ( $scripture->getVerses() as $verse ): ?>
                <li id="verse_<?= $verse->getNumber() ?>" data-verse="<?= $verse->getId() ?>" class="verse<?= in_array( $verse->getNumber(), $verses ) ? ' highlight' : '' ?>">
                    <span class="verse-num"><?= $verse->getNumber() ?></span>
                    <span class="verse-text"><?= $verse->getText() ?></span>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
</div>