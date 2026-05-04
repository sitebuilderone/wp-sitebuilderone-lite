<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class SBO_FAQ_HowTo_Rest_Fields {

	public static function register() {
		register_post_meta( 'howto', '_sb1_howto_description', [
			'type'              => 'string',
			'description'       => 'Short description for HowTo schema.',
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => 'sanitize_textarea_field',
		] );

		register_post_meta( 'howto', '_sb1_howto_total_time', [
			'type'              => 'string',
			'description'       => 'ISO 8601 duration for the full HowTo.',
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => 'sanitize_text_field',
		] );

		register_post_meta( 'howto', '_sb1_howto_supplies', [
			'type'              => 'string',
			'description'       => 'Supplies for the HowTo, one per line.',
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => 'sanitize_textarea_field',
		] );

		register_post_meta( 'howto', '_sb1_howto_steps', [
			'type'              => 'array',
			'description'       => 'Ordered HowTo steps.',
			'single'            => true,
			'sanitize_callback' => [ __CLASS__, 'sanitize_steps' ],
			'show_in_rest'      => [
				'schema' => [
					'type'  => 'array',
					'items' => [
						'type'       => 'object',
						'properties' => [
							'name'  => [ 'type' => 'string' ],
							'text'  => [ 'type' => 'string' ],
							'url'   => [ 'type' => 'string' ],
							'image' => [ 'type' => 'string' ],
						],
					],
				],
			],
		] );
	}

	public static function sanitize_steps( $value ) {
		if ( ! is_array( $value ) ) {
			return [];
		}

		$steps = [];
		foreach ( array_slice( $value, 0, SBO_FAQ_HowTo_Meta_Boxes::MAX_STEPS ) as $step ) {
			if ( ! is_array( $step ) ) {
				continue;
			}

			$clean_step = [
				'name'  => isset( $step['name'] ) ? sanitize_text_field( $step['name'] ) : '',
				'text'  => isset( $step['text'] ) ? sanitize_textarea_field( $step['text'] ) : '',
				'url'   => isset( $step['url'] ) ? esc_url_raw( $step['url'] ) : '',
				'image' => isset( $step['image'] ) ? esc_url_raw( $step['image'] ) : '',
			];

			if ( $clean_step['name'] || $clean_step['text'] ) {
				$steps[] = $clean_step;
			}
		}

		return $steps;
	}
}
