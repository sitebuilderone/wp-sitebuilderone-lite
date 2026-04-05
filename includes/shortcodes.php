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
} );
