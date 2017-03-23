<?php
$back = GlobalConfig::getAppPath() . '/scripture/view?volume=' . $this->vars['volume']->getId();
$url = GlobalConfig::getAppPath() . '/scripture/view';

require_once __DIR__ . '/breadcrumb.php'
?>

<div class="card">
    <div class="card-header" role="tab" id="book_<?= $this->vars['book']->getId() ?>">
        <h5 class="mb-0">
            <a class="fa fa-arrow-left" href="<?= $back ?>">
            </a>
            <?= $this->vars['book']->getTitle() ?>
        </h5>
    </div>
    <div class="card-block chapters-list">
        <?php foreach ( $this->vars['chapters'] as $chapter ): /* @var Chapters $chapter */?>
            <a href="<?= $url ?>/<?= $this->vars['book']->getLdsUrl() ?>/<?= $chapter->getNumber() ?>"><?= $chapter->getNumber() ?></a>
        <?php endforeach ?>
    </div>
</div>
