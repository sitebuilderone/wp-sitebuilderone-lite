<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class SBO_Services_Rest_Fields {

	public static function register() {
		$meta_fields = [
			'_sb1_short_description' => [
				'type'        => 'string',
				'description' => 'Short description for the service.',
			],
			'_sb1_icon'              => [
				'type'        => 'string',
				'description' => 'Icon URL or CSS class for the service.',
			],
			'_sb1_cta_url'           => [
				'type'        => 'string',
				'description' => 'Call-to-action button URL for the service.',
			],
			'_sb1_service_type'      => [
				'type'        => 'string',
				'description' => 'Service type used in Schema.org markup.',
			],
			'_sb1_service_area'      => [
				'type'        => 'string',
				'description' => 'Area served, used in Schema.org markup.',
			],
		];

		foreach ( $meta_fields as $key => $config ) {
			register_post_meta( 'service', $key, [
				'type'              => $config['type'],
				'description'       => $config['description'],
				'single'            => true,
				'show_in_rest'      => true,
				'sanitize_callback' => '_sb1_cta_url' === $key ? 'esc_url_raw' : 'sanitize_text_field',
			] );
		}
	}
}
