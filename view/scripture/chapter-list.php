<?php
$url = GlobalConfig::getAppPath() . '/scripture/view';

require_once __DIR__ . '/breadcrumb.php'
?>

<div class="card chapters-list">
    <div class="card-header" role="tab" id="book_<?= $this->vars['book']->getId() ?>">
        <h5 class="mb-0">
            <?= $this->vars['book']->getTitle() ?>
        </h5>
    </div>
    <div class="card-block">
        <?php foreach ( $this->vars['chapters'] as $chapter ): /* @var Chapters $chapter */?>
            <a href="<?= $url ?>/<?= $this->vars['book']->getLdsUrl() ?>/<?= $chapter->getNumber() ?>"><?= $chapter->getNumber() ?></a>
        <?php endforeach ?>
    </div>
</div>
