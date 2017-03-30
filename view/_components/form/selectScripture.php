<?php

use model\MScripture;
use model\orm\entity\Book;
use model\orm\entity\Volumes;

$volumesRepo = MScripture::getVolumesRepo();
$booksRepo = MScripture::getBookRepo();
$chaptersRepo = MScripture::getChaptersRepo();
?>


<form class="form-inline">
    <div class="form-group">
        <label for="book">Book:</label>
        <select class="custom-select" id="book" name="book">
            <?php foreach ( $volumesRepo->findAll() as $volume ): /* @var Volumes $volume */ ?>
                <optgroup label="<?= $volume->getTitle() ?>">
                    <?php foreach ( $booksRepo->findBy( [ 'volumeId' => $volume->getId() ] ) as $book ): /* @var Book $book */ ?>
                        <option value="<?= $book->getLdsUrl() ?>" data-chapters="<?= sizeof( $chaptersRepo->findBy( [ 'bookId' => $book->getId() ] ) ) ?>"><?= $book->getTitle() ?></option>
                    <?php endforeach; ?>
                </optgroup>
            <?php endforeach; ?>
        </select>
        <label for="chapter">Chapter:</label><input id="chapter" name="chapter" class="form-control positive integer" type="number" min="1">
        <label for="verses">Verses:</label><input id="verses" name="verses" class="form-control positive integer" type="number-list">
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
</form>