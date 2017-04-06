<?php
use model\orm\entity\Verse;

/* @var Verse $verse */
$verse = $this->vars['verse'];
$delimiter = "/( |--)/";
$split = preg_split( $delimiter, $verse->getText(), -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY );
?>

<div id="footnote-picker">
    <div id="pick-word">
        <div class="explanation">
            Pick a word to link from:
        </div>
        <div class="verse">
            <?php $words = 0;
            foreach ( $split as $word ): ?>
                <?php
                if ( preg_match( $delimiter, $word ) == 0 ):
                    $words++;
                    ?>
                    <a class="word-link" href="<?= $words ?>"><?= $word ?></a>
                    <?php
                else:
                    echo $word;
                endif;
                ?>
            <?php endforeach ?>
        </div>
    </div>
</div>
<div id="footnote-hidden" class="hidden">
    <form id="footnote-form" class="hidden" aria-hidden="true" method="POST" action="<?= Config\Application::APP_PATH ?> /scripture/save-footnote">
        <input type="hidden" name="verseId" value="<?= $verse->getId() ?>"/>
        <input type="hidden" id="word-number" name="wordNumber"/>
        <input type="hidden" id="target-verse" name="targetVerseId"/>
    </form>
    <div id="pick-target" class="form-wrap">
        <div class="explanation">
            Pick the verse(s) to link to:
        </div>
        <?php include directory( [ 'view', '_components', 'form', 'selectScripture.php' ], true ); ?>
    </div>
</div>
<script>
    $( function () {
        var saveBtn = $( '#dynamic-modal-save-btn' );
        var form = $( '#footnote-form' );
        saveBtn.hide();
        $( '.word-link' ).click( function ( event ) {
            event.preventDefault();
            $( '#word-number' ).val( $( this ).attr( 'href' ) );
            $( '#pick-word' ).appendTo( '#footnote-hidden' );
            $( '#pick-target' ).appendTo( '#footnote-picker' );
            saveBtn.show();
        } );
        form.submit( function () {
            $.post( $( this ).attr( 'action' ), $( this ).serialize(), function ( response ) {
                var obj = JSON.parse( response );
                if ( obj.code != 200 )
                    alert( obj.msg );
                else {
                    $( '#dynamic-modal' ).hideModal();
                    alert( obj.msg );
                }
            } );
            return false;
        } );
        saveBtn.click( function ( event ) {
            
            form.submit();
        } );
    } );
    function submitFootnote() {

    }
</script>