<?php

use model\MScripture;
use model\orm\entity\Book;
use model\orm\entity\Volume;

$volumeRepo = MScripture::getVolumeRepo();
?>


<div class="form-group">
    <label for="book" class="fixed-tiny">Book:</label>
    <select class="custom-select fixed-small" id="book" name="book">
        <?php foreach ( $volumeRepo->findAll() as $volume ): /* @var Volume $volume */ ?>
            <optgroup label="<?= $volume->getTitle() ?>">
                <?php foreach ( $volume->getBooks() as $book ): /* @var Book $book */ ?>
                    <option value="<?= $book->getLdsUrl() ?>" data-chapters="<?= sizeof( $book->getChapters() ) ?>"><?= $book->getTitle() ?></option>
                <?php endforeach; ?>
            </optgroup>
        <?php endforeach; ?>
    </select>
</div>
<div class="form-group">
    <label for="chapter" class="fixed-tiny">Chapter:</label>
    <input id="chapter" name="chapter" class="form-control positive integer fixed-small" type="number" min="1">
</div>
<div class="form-group">
    <label for="verses" class="fixed-tiny">Verses:</label>
    <input id="verses" name="verses" class="form-control positive integer fixed-small" type="number-list">
</div>

<script>
    $( function () {
        var book = $( '#book' );
        var chapter = $( '#chapter' );
        var max = book.find( 'option:selected' ).data( 'chapters' );
        chapter.attr( 'max', max );
        book.change( function () {
            console.log( 'book changed' );
            var max = $( '#book' ).find( 'option:selected' ).data( 'chapters' );
            if ( chapter.val() > max )
                chapter.val( max );
            chapter.attr( 'max', max );
        } )
    } )
</script>
