<?php
$url = \config\Application::APP_PATH . '/scripture';

extract( $this->vars );
/**
 * variables needed here:
 * @var array  $volumes
 * @var string $active
 */
?>
<div class="card card-block">
    <div id="books-accordion" class="card accordion" role="tablist" aria-multiselectable="true">
    <?php foreach ( $volumes as $volId => $data ): ?>
        <div class="card-header" role="tab" id="volume_<?= $volId ?>" href="#books_<?= $volId ?>" data-toggle="collapse" data-parent="#books-accordion" aria-controls="books_<?= $volId ?>">
            <h5 class="mb-0">
                <?= $data['name'] ?>
            </h5>
        </div>
        <div class="collapse<?= $active == $volId ? ' show' : '' ?> card-block books-list" role="tabpanel" id="books_<?= $volId ?>" aria-labelledby="volume_<?= $volId ?>">
        <?php foreach ( $data['books'] as $id => $book ): ?>
            <a href="<?= $url ?>/<?= $id ?>" class="ajax-link"><?= $book ?></a>
        <?php endforeach ?>
        </div>
    <?php endforeach ?>
    </div>
</div>
