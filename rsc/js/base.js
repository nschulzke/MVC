$( function () {
    window.history.replaceState( { "html": $( '#main-container' ).html() }, "", window.location.href );
    window.onpopstate = function ( event ) {
        console.log( event );
        if ( event.state ) {
            initDynamicOnReady();
            console.log( "hasState" );
            $( '#main-container' ).html( event.state.html );
        }
    };

    initModals();
    initDynamicOnReady();
} );

function initDynamicOnReady() {
    // Wait for doc to load
    $( function () {
        $( '.ajax-link' ).click( function ( event ) {
            event.preventDefault();
            loadWorkspace( $( this ).attr( 'href' ) );
        } );

        if ( $( '.chapter-view' ).length > 0 )
            initHighlighter();
        initFormValidation();
    } )
}

function initHighlighter() {
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

    // Scroll to active verses
    var $activeVerse = $( '.verse.highlight' ).first();
    if ($activeVerse.length > 0) {
        setTimeout( function () {
            var padding = 10;
            var offset = $activeVerse.offset().top;
            var scrollTo = offset - padding - $( '.breadcrumb' ).height() - parseInt( $activeVerse.css( 'margin-bottom' ) );
            $( 'html, body' ).animate( { scrollTop: scrollTo }, 500 );
        }, 500 );
    }

    document.onmouseup = function () {
        detectSelection();
    };

    document.onkeyup = function ( e ) {
        if ( Number( e.keyCode ) <= 40 && Number( e.keyCode ) >= 37 )
            detectSelection();
    };

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
}

function initModals() {
    $( '#dynamic-modal' ).on( 'show.bs.modal', function ( event ) {
        // Get the data from the button
        var button = $( event.relatedTarget );
        var url = button.data( 'url' );
        var title = button.data( 'title' );
        var saveBtn = button.data( 'saveBtn' );
        var closeBtn = button.data( 'closeBtn' );
        var params = button.data( 'params' );
        // Validate the data
        if ( saveBtn == undefined )
            saveBtn = 'Save';
        if ( closeBtn == undefined )
            closeBtn = 'Close';

        if ( params != undefined ) {
            for ( var i = 0; i < params.length; i++ ) {
                url += '/' + $( '#' + params[i] ).val();
            }
        }

        // Set the HTML based on the button's data
        var modal = $( this );
        modal.find( '#dynamic-modal-title' ).html( title );
        modal.find( '#dynamic-modal-close-btn' ).html( closeBtn );
        modal.find( '#dynamic-modal-save-btn' ).html( saveBtn );

        // Hide or show save-btn based on button data
        if ( saveBtn == false )
            modal.find( '#dynamic-modal-save-btn' ).hide();
        else
            modal.find( '#dynamic-modal-save-btn' ).show();

        // Run Ajax query
        $.get( url, { layout: 'none' }, function ( data ) {
            modal.find( '#dynamic-modal-body' ).html( data );
        } );
    } );
}

function initFormValidation() {
    var input_number = $( 'input[type=number]' );
    var input_number_list = $( 'input[type=number-list]' );
    // Ensure that only '0-9', '.' and '-' are allowed, and restrict '.' and '-' to the right place
    input_number.keypress( function ( e ) {
        if ( Number( e.which ) > 32 ) {
            var ch = String.fromCharCode( Number( e.which ) );

            // Reject dot if we already have one, or if it's an integer
            var rejectDot = $( this ).val().indexOf( '.' ) > -1 || $( this ).hasClass( 'integer' );
            // Reject minus if it's not the first character, or it's positive-only
            var rejectMinus = $( this ).val().length > 0 || $( this ).hasClass( 'positive' );

            // Only allow 0-9 - .
            if ( ch.match( /[^0-9\-.]/g ) )
                e.preventDefault();
            if ( ch.match( /[\-]/g ) && rejectMinus )
                e.preventDefault();
            if ( ch.match( /[.]/g ) && rejectDot )
                e.preventDefault();
        }
    } );
    // Make sure numbers stay within their min and max
    input_number.change( function () {
        var min = $( this ).attr( 'min' );
        var max = $( this ).attr( 'max' );

        if ( min != undefined && parseInt( $( this ).val() ) < min )
            $( this ).val( min );
        if ( max != undefined && parseInt( $( this ).val() ) > max )
            $( this ).val( max );
    } );
    // Ensure that only '0-9', '.' ',', and '-' are allowed
    input_number_list.keypress( function ( e ) {
        if ( Number( e.which ) > 32 ) {
            var ch = String.fromCharCode( Number( e.which ) );

            // Only allow 0-9 - . , space
            if ( ch.match( /[^0-9\-., ]/g ) )
                e.preventDefault();
            if ( ch.match( /[.]/g ) && $( this ).hasClass( 'integer' ) )
                e.preventDefault();
        }
    } );
    // Clean up input
    input_number_list.change( function () {
        // Replace spaces between numbers with commas
        $( this ).val( $( this ).val().replace( /([0-9])[ ]+(?=[0-9])/g, '$1, ' ) );
        // Remove all other spaces
        $( this ).val( $( this ).val().replace( /[ ]*/g, '' ) );
        // Replace duplicate characters
        $( this ).val( $( this ).val().replace( /([,.\-])\1+/g, '$1' ) );
        // If positive, replace all dashes that aren't found between numbers
        if ( $( this ).hasClass( 'positive' ) )
            $( this ).val( $( this ).val().replace( /[\-]([^0-9]|$)|([^0-9]|^)[\-]/g, '$1' ) );
        // Replace
        $( this ).val( $( this ).val().replace( /([0-9]-)[0-9]+-([0-9])/g, '$1$2' ) );
        // Remove commas not between numbers
        $( this ).val( $( this ).val().replace( /[,]([^0-9]|$)|([^0-9]|^)[,]/g, '$1' ) );
        // Add spaces back after commas
        $( this ).val( $( this ).val().replace( /[,]/g, ', ' ) );
    } );
}

function loadWorkspace( url ) {
    var useUrl = url;
    if ( url.indexOf( '?' ) > -1 )
        useUrl += '&layout=none';
    else
        useUrl += '?layout=none';
    $.ajax( {
        url: useUrl,
        success: function ( response ) {
            $( '#main-container' ).html( response );
            initDynamicOnReady();
            // If we used an href anchor to get here, then replace it
            if ( window.location.href.indexOf( '#' ) == (window.location.href.length - 1) )
                window.history.replaceState( { "html": response }, "", url );
            else
                window.history.pushState( { "html": response }, "", url );
        }
    } );
}