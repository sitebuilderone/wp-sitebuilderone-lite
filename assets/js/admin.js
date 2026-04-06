/**
 * WP SiteBuilderOne Lite — Admin JavaScript
 * Handles copy-to-clipboard for shortcode references.
 */

document.addEventListener( 'DOMContentLoaded', function() {
	const copyButtons = document.querySelectorAll( '.sbo-copy-shortcode' );

	copyButtons.forEach( button => {
		button.addEventListener( 'click', function( e ) {
			e.preventDefault();

			const shortcode = this.getAttribute( 'data-shortcode' );
			const decoded = shortcode
				.replace( /&quot;/g, '"' )
				.replace( /&#039;/g, "'" )
				.replace( /&amp;/g, '&' );

			// Copy to clipboard using modern API.
			navigator.clipboard.writeText( decoded ).then( () => {
				const originalText = this.textContent;
				this.textContent = 'Copied!';
				this.disabled = true;

				setTimeout( () => {
					this.textContent = originalText;
					this.disabled = false;
				}, 2000 );
			} ).catch( err => {
				console.error( 'Failed to copy:', err );
				alert( 'Failed to copy shortcode. Please copy manually.' );
			} );
		} );
	} );
} );


// Media library picker
document.querySelectorAll( '.sbo-media-picker' ).forEach( button => {
    button.addEventListener( 'click', function () {
        const targetId = this.getAttribute( 'data-target' );
        const input    = document.getElementById( targetId );

        const frame = wp.media( {
            title:    'Select or Upload Image',
            button:   { text: 'Use this image' },
            multiple: false,
            library:  { type: 'image' },
        } );

        frame.on( 'select', function () {
            const attachment = frame.state().get( 'selection' ).first().toJSON();
            input.value = attachment.url;
            // Refresh the preview without a full page reload
            let preview = input.closest( 'div' ).nextElementSibling;
            if ( preview && preview.tagName === 'P' ) {
                preview.querySelector( 'img' ).src = attachment.url;
            }
        } );

        frame.open();
    } );
} );
