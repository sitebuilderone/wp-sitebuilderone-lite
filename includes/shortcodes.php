<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Retrieve a single business field value.
 *
 * Uses a static cache so get_option() is called only once per request,
 * regardless of how many times sbo_get() or [sbo_field] is used on a page.
 *
 * @param string $field   The field key (e.g. 'one_business_name').
 * @param string $default Fallback value when the field is empty or not set.
 * @return string Raw stored value (unsanitized — caller decides escaping context).
 */
function sbo_get( string $field, string $default = '' ): string {
	static $opts = null;
	if ( null === $opts ) {
		$opts = get_option( SBO_OPTION_KEY, [] );
	}
	return isset( $opts[ $field ] ) && '' !== $opts[ $field ] ? (string) $opts[ $field ] : $default;
}

/**
 * [sbo_field] shortcode.
 *
 * Attributes:
 *   name    (required) — field key.
 *   default            — fallback string (default: '').
 *   raw                — set to "true" to output HTML embed fields without esc_html.
 *                        Values are already wp_kses_post()'d on save, so this is safe.
 *
 * Examples:
 *   [sbo_field name="one_business_name"]
 *   [sbo_field name="one_business_phone" default="Call us"]
 *   [sbo_field name="one_google_map_embed" raw="true"]
 */
add_action( 'init', function () {
	add_shortcode( 'sbo_field', function ( $atts ) {
		$atts = shortcode_atts(
			[
				'name'    => '',
				'default' => '',
				'raw'     => 'false',
			],
			$atts,
			'sbo_field'
		);

		if ( '' === $atts['name'] ) return '';

		$value = sbo_get( $atts['name'], $atts['default'] );

		if ( 'true' === strtolower( $atts['raw'] ) ) {
			return $value; // Already kses'd on save — safe to output directly.
		}

		return esc_html( $value );
	} );

	add_shortcode( 'sbo_url', function( $atts ) {
    $atts = shortcode_atts( [ 'name' => '' ], $atts, 'sbo_url' );
    if ( '' === $atts['name'] ) return '';
    return esc_url( sbo_get( $atts['name'] ) );
} );


} );




add_action( 'init', function() {
    if ( function_exists( 'tangible_template' ) ) {
        tangible_template()->set_variable( 
            'sbo_marketing_image', 
            esc_url( sbo_get( 'one_marketing_image' ) ) 
        );
    }
});


add_action( 'plugins_loaded', function() {
    add_filter( 'tangible_template_variable', function( $value, $name ) {
        // Allow any sbo_ field to be accessed as {sbo_one_marketing_image} etc.
        if ( str_starts_with( $name, 'sbo_' ) ) {
            $field = substr( $name, 4 ); // strip "sbo_" prefix
            return esc_url( sbo_get( $field ) );
        }
        return $value;
    }, 10, 2 );
} );




// In includes/shortcodes.php
add_shortcode( 'sbo_link', function( $atts, $content ) {
    $atts = shortcode_atts( ['name' => '', 'default' => '#'], $atts, 'sbo_link' );
    $url  = sbo_get( $atts['name'], $atts['default'] );
    return '<a href="' . esc_url( $url ) . '">' . esc_html( $content ) . '</a>';
}, 10, 2 );

/**
 * [sbo_custom_logo] shortcode.
 * Returns just the URL to the Customizer logo image.
 *
 * Attributes:
 *   size — image size (default: 'full')
 *
 * Examples:
 *   [sbo_custom_logo]
 *   [sbo_custom_logo size="medium"]
 */
add_shortcode( 'sbo_custom_logo', function ( $atts ) {
    $atts = shortcode_atts(
        [ 'size' => 'full' ],
        $atts,
        'sbo_custom_logo'
    );

    $logo_id = get_theme_mod( 'custom_logo' );
    if ( ! $logo_id ) return '';

    $url = wp_get_attachment_image_url( $logo_id, $atts['size'] );
    if ( ! $url ) return '';

    // Strip the scheme + host so LiveCanvas doesn't double-prefix it.
    $parsed = wp_parse_url( $url );
    return $parsed['path'] ?? $url;
} );


