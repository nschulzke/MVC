<?php
$volumesRepo = MScripture::getVolumesRepo();
$booksRepo = MScripture::getBooksRepo();
$chaptersRepo = MScripture::getChaptersRepo();
?>


<form class="form-inline">
    <div class="form-group">
        <label for="book">Book:</label>
        <select class="custom-select" id="book">
            <?php foreach ( $volumesRepo->findAll() as $volume ): /* @var Volumes $volume */ ?>
                <optgroup label="<?= $volume->getTitle() ?>">
                    <?php foreach ( $booksRepo->findBy( array( 'volumeId' => $volume->getId() ) ) as $book ): /* @var Books $book */?>
                        <option value="<?= $book->getLdsUrl() ?>" data-chapters="<?= sizeof( $chaptersRepo->findBy( array( 'bookId' => $book->getId() ) ) ) ?>"><?= $book->getTitle() ?></option>
                    <?php endforeach; ?>
                </optgroup>
            <?php endforeach; ?>
        </select>
        <label for="chapter">Chapter:</label><input id="chapter" class="form-control positive integer" type="number" min="1">
        <label for="verses">Verses:</label><input id="verses" class="form-control positive integer" type="number-list">
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