<?php
$back = GlobalConfig::getAppPath() . '/scripture/book-list?volume=' . $this->vars['volume'];
$url = GlobalConfig::getAppPath() . '/scripture/chapter-list';
?>

<div class="card">
    <div class="card-header" role="tab" id="volume_<?= str_replace(' ', '', $this->vars['book']) ?>">
        <h5 class="mb-0">
            <a class="fa fa-arrow-left" href="<?= $back ?>">
            </a>
            <?= $this->vars['book'] ?>
        </h5>
    </div>
    <div class="card-block chapters-list">
        <?php foreach ( $this->vars['chapters'] as $chapter ): /* @var Chapters $chapter */?>
            <a href="<?= $url ?>?chapter=<?= $chapter->getId() ?>"><?= $chapter->getNumber() ?></a>
        <?php endforeach ?>
    </div>
</div>
