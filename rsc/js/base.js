function initHandlers() {
    // Wait for doc to load
    $( function () {
        $( '.ajax-link' ).click( function ( event ) {
            event.preventDefault();
            loadWorkspace( $( this ).attr( 'href' ) );
        } );

        /**
         *  Input field handling
         */
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

        /**
         *  Modal handling
         */
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
    } )
}

$( function () {
    window.history.replaceState( { "html": $( '#main-container' ).html() }, "", window.location.href );
    window.onpopstate = function ( event ) {
        console.log( event );
        if ( event.state ) {
            initHandlers();
            console.log( "hasState" );
            $( '#main-container' ).html( event.state.html );
        }
    };

    initHandlers();
} );

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
            initHandlers();
            // If we used an href anchor to get here, then replace it
            if ( window.location.href.indexOf( '#' ) == (window.location.href.length - 1) )
                window.history.replaceState( { "html": response }, "", url );
            else
                window.history.pushState( { "html": response }, "", url );
        }
    } );
}