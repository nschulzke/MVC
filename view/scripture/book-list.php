<?php
$url = \config\Application::getAppPath() . '/scripture/view';

extract( $this->vars );
/**
 * variables needed here:
 * @var array  $volumes
 * @var string $active
 */
?>
<div id="books-accordion" role="tablist" aria-multiselectable="true">
    <?php foreach ( $volumes as $volId => $data ): ?>
        <div class="card">
            <div class="card-header" role="tab" id="volume_<?= $volId ?>">
                <h5 class="mb-0">
                    <a data-toggle="collapse" data-parent="#books-accordion" href="#books_<?= $volId ?>" aria-expanded="true" aria-controls="books_<?= $volId ?>">
                        <?= $data['name'] ?>
                    </a>
                </h5>
            </div>
            <div class="collapse<?= $active == $volId ? ' show' : '' ?>" role="tabpanel" id="books_<?= $volId ?>" aria-labelledby="volume_<?= $volId ?>">
                <div class="card-block books-list">
                    <?php foreach ( $data['books'] as $id => $book ): ?>
                        <a href="<?= $url ?>/<?= $id ?>" class="ajax-link"><?= $book ?></a>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>