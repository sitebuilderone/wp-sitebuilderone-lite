<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class SBO_FAQ_Schema {

	public static function register() {
		add_action( 'wp_head', [ __CLASS__, 'output_single' ] );
	}

	public static function output_single() {
		if ( ! is_singular( 'faq' ) ) {
			return;
		}

		$schema = self::build_schema( [ get_post( get_the_ID() ) ] );

		if ( $schema ) {
			echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
		}
	}

	public static function build_schema( array $faq_posts ) {
		$entities = [];

		foreach ( $faq_posts as $faq ) {
			if ( ! $faq instanceof WP_Post ) {
				continue;
			}

			$answer = get_post_meta( $faq->ID, '_sb1_faq_answer', true );

			if ( ! $faq->post_title || ! $answer ) {
				continue;
			}

			$entities[] = [
				'@type'          => 'Question',
				'name'           => wp_strip_all_tags( $faq->post_title ),
				'acceptedAnswer' => [
					'@type' => 'Answer',
					'text'  => wp_strip_all_tags( $answer ),
				],
			];
		}

		if ( empty( $entities ) ) {
			return null;
		}

		return [
			'@context'   => 'https://schema.org',
			'@type'      => 'FAQPage',
			'mainEntity' => $entities,
		];
	}
}
