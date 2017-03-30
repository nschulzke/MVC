<?php
use model\orm\entity\Book;
use model\orm\entity\Volume;

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
    <?php foreach ( $volumes as $volume ): /* @var Volume $volume */ ?>
        <div class="card-header" role="tab" id="volume_<?= $volume->getId() ?>" href="#books_<?= $volume->getId() ?>" data-toggle="collapse" data-parent="#books-accordion" aria-controls="books_<?= $volume->getId() ?>">
            <h5 class="mb-0">
                <?= $volume->getTitle(); ?>
            </h5>
        </div>
        <div class="collapse<?= $active == $volume->getLdsUrl() ? ' show' : '' ?> card-block books-list" role="tabpanel" id="books_<?= $volume->getId() ?>" aria-labelledby="volume_<?= $volume->getId() ?>">
        <?php foreach ( $volume->getBooks() as $book ): /* @var Book $book */ ?>
            <a href="<?= $url ?>/<?= $book->getLdsUrl() ?>" class="ajax-link"><?= $book->getTitle() ?></a>
        <?php endforeach ?>
        </div>
    <?php endforeach ?>
    </div>
</div>
