<div id="books-accordion" role="tablist" aria-multiselectable="true">
<?php
foreach ($this->vars['volumes'] as $volume => $books): /* @var Books[] $books */
$volId = str_replace(' ', '', $volume);
?>
    <div class="card">
        <div class="card-header" role="tab" id="volume_<?= $volId ?>">
            <h5 class="mb-0">
                <a data-toggle="collapse" data-parent="#books-accordion" href="#books_<?= $volId ?>" aria-expanded="true" aria-controls="books_<?= $volId ?>">
                    <?= $volume ?>
                </a>
            </h5>
        </div>
        <div class="collapse" role="tabpanel" id="books_<?= $volId ?>" aria-labelledby="volume_<?= $volId ?>">
            <div class="card-block books-list">
            <?php foreach ( $books as $id => $book ): ?>
                <a href="/scripture/chapter-list?book=<?= $id ?>"><?= $book ?></a>
            <?php endforeach ?>
            </div>
        </div>
    </div>
<?php endforeach ?>
</div>