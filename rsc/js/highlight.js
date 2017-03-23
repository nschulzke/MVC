if ( $( '.chapter-view' ).length > 0 ) {
    function detectSelection() {
        var range;
        var selection;
        var respond = true;
        if ( window.getSelection ) {
            selection = window.getSelection();
            if ( selection.getRangeAt( 0 ).toString().length == 0 )
                respond = false;
            else
                range = selection.getRangeAt( 0 );
        } else if ( document.selection && document.selection.type != "Control" ) {
            selection = document.selection;
            range = selection.createRange();
        }
        // Only deal with ranges in the same node
        if ( respond && range.startContainer != range.endContainer )
            respond = false;
        else if ( respond && range.toString().match( /^ *[^ ]+ *$/g ) == null )
            respond = false;

        if ( respond ) {
            $( '#highlight-menu' ).fadeIn();
            $( '#highlight-menu' ).offset( { top: $( range.startContainer ).closest('li').offset().top } );
        }
        else
            $( '#highlight-menu' ).hide();
    }

    document.onmouseup = function () {
        detectSelection();
    }

    document.onkeyup = function ( e ) {
        if ( Number( e.keyCode ) <= 40 && Number( e.keyCode ) >= 37 )
            detectSelection();
    }
}

$( function () {
    var aChar = 97;
    $( '#highlight-menu' ).hide();
    $( 'span.verse-text' ).each(function() {
        var footnotes = 0;
        var char;
        $(this).find( 'span.footnote' ).each(function() {
            char = String.fromCharCode(aChar + footnotes);
            $(this).prepend('<sup>' + char + '</sup>');
            footnotes++;
        });
    });
} )