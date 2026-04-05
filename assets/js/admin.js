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
