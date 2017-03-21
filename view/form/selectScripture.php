<?php
$volumesRepo = MScripture::getVolumesRepo();
$booksRepo = MScripture::getBooksRepo();
$chaptersRepo = MScripture::getChaptersRepo();
?>


<form class="form-inline">
    <div class="form-group">
        <label for="book">Book:</label>
        <select class="custom-select" id="book">
            <?php foreach ($volumesRepo->findAll() as $volume): ?>
            <optgroup label="<?= $volume->getVolumeTitle() ?>">
                <?php foreach ($booksRepo->findBy(array('volumeId' => $volume->getId())) as $book): ?>
                    <option value="<?= $book->getId() ?>" data-chapters="<?= sizeof($chaptersRepo->findBy(array('bookId' => $book->getId())))?>"><?= $book->getBookTitle() ?></option>
                <?php endforeach; ?>
            </optgroup>
            <?php endforeach; ?>
        </select>
        <label for="chapter">Chapter:</label><input id="chapter" type="number" class="form-control"></input>
        <label for="verse">Verses:</label><input id="verses" class="form-control"></input>
    </div>
</div>

<script>
$(function() {
    var max = $('#book option:selected').data('chapters');
    $('#chapter').attr('max', max);
    $('#book').change(function() {
        var max = $('#book option:selected').data('chapters');
        if ($('#chapter').val() > max)
            $('#chapter').val(max);
        $('#chapter').attr('max', max);
    })
    $('#chapter').change(function() {
        console.log("test");
        var max = $('#chapter').attr('max');
        if ($('#chapter').val() > max)
            $('#chapter').val(max);
    })
})
</script>