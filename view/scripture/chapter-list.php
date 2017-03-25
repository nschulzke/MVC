<?php
use model\orm\entity\Books;
use model\orm\entity\Chapters;

$url = \config\Application::getAppPath() . '/scripture';

extract( $this->vars );
/**
 * variables needed here:
 * @var Books $book
 */

require_once __DIR__ . '/../_components/breadcrumb.php'

?>

<div class="card chapters-list">
    <div class="card-header" role="tab" id="book_<?= $book->getId() ?>">
        <h5 class="mb-0">
            <?= $book->getTitle() ?>
        </h5>
    </div>
    <div class="card-block">
        <?php foreach ( $this->vars['chapters'] as $chapter ): /* @var Chapters $chapter */ ?>
            <a href="<?= $url ?>/<?= $book->getLdsUrl() ?>/<?= $chapter->getNumber() ?>" class="ajax-link"><?= $chapter->getNumber() ?></a>
        <?php endforeach ?>
    </div>
</div>
