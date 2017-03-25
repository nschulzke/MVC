if ( $( '.chapter-view' ).length > 0 ) {
    function detectSelection() {
        var range;
        var selection;
        var respond = true;
        var highlightMenu = $( '#highlight-menu' );
        if ( window.getSelection ) {
            selection = window.getSelection();
            if ( selection.anchorNode == null )
                respond = false;
            else if ( selection.getRangeAt( 0 ).toString().length == 0 )
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
            highlightMenu.fadeIn();
            highlightMenu.offset( { top: $( range.startContainer ).closest( 'li' ).offset().top } );
        }
        else
            highlightMenu.hide();
    }

    document.onmouseup = function () {
        detectSelection();
    };

    document.onkeyup = function ( e ) {
        if ( Number( e.keyCode ) <= 40 && Number( e.keyCode ) >= 37 )
            detectSelection();
    };
}

function getPopover() {
    var footnote = $( this );
    var book = footnote.data( 'book' );
    var chapter = footnote.data( 'chapter' );
    var verse = footnote.data( 'verse' );
    console.log( book );
    console.log( chapter );
    console.log( verse );
    $.get( "/framework/scripture/lookup/" + book + "/" + chapter + "/" + verse + "?layout=none", function ( data ) {
        footnote.popover( 'dispose' );
        console.log( data );
        footnote.popover( { html: true, content: data, trigger: 'focus' } );
        footnote.popover( 'toggle' );
    } );
}

$( function () {
    var aChar = 97;
    $( '#highlight-menu' ).hide();
    $( 'span.verse-text' ).each( function () {
        var footnotes = 0;
        var char;
        $( this ).find( 'a.footnote' ).each( function () {
            char = String.fromCharCode( aChar + footnotes );
            $( this ).prepend( '<sup>' + char + '</sup>' );
            footnotes++;
        } );
    } );
    $( 'a.footnote' ).each( function () {
        $( this ).popover( { content: getPopover, trigger: 'focus' } );
    } );
} );
// Scroll to active verses
$( window ).on( 'load', function () {
    var padding = 10;
    var first = $( '.verse.highlight' ).first();
    var offset = first.offset().top;
    console.log( first.css( 'margin-bottom' ) );
    var scrollTo = offset - padding - $( '.breadcrumb' ).height() - parseInt( first.css( 'margin-bottom' ) );

    console.log( scrollTo );
    $( 'html, body' ).animate( { scrollTop: scrollTo }, 500 );
} );