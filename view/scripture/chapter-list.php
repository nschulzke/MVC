<?php
use model\orm\entity\Book;
use model\orm\entity\Chapter;

$url = \config\Application::APP_PATH . '/scripture';

$book = $this->vars['book'];
/* @var Book $book */

require_once __DIR__ . '/../_components/breadcrumb.php'
?>

<div class="card chapters-list">
    <div class="card-header" role="tab" id="book_<?= $book->getId() ?>">
        <h5 class="mb-0">
            <?= $book->getTitle() ?>
        </h5>
    </div>
    <div class="card-block">
        <?php foreach ( $book->getChapters() as $chapter ): /* @var Chapter $chapter */ ?>
            <a href="<?= $url ?>/<?= $book->getLdsUrl() ?>/<?= $chapter->getNumber() ?>" class="ajax-link"><?= $chapter->getNumber() ?></a>
        <?php endforeach ?>
    </div>
</div>
