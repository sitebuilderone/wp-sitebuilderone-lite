<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class SBO_Services_Shortcode {

	public static function register() {
		add_shortcode( 'sb1_services', [ __CLASS__, 'render' ] );
	}

	public static function render( $atts ) {
		$atts = shortcode_atts(
			[
				'count'   => -1,
				'tag'     => '',
				'columns' => 3,
				'orderby' => 'menu_order',
				'order'   => 'ASC',
			],
			$atts,
			'sb1_services'
		);

		$query_args = [
			'post_type'      => 'service',
			'posts_per_page' => intval( $atts['count'] ),
			'post_status'    => 'publish',
			'orderby'        => sanitize_key( $atts['orderby'] ),
			'order'          => in_array( strtoupper( $atts['order'] ), [ 'ASC', 'DESC' ], true ) ? strtoupper( $atts['order'] ) : 'ASC',
			'no_found_rows'  => true,
		];

		if ( '' !== trim( $atts['tag'] ) ) {
			$query_args['tax_query'] = [
				[
					'taxonomy' => 'service_tag',
					'field'    => 'slug',
					'terms'    => array_map( 'trim', explode( ',', sanitize_text_field( $atts['tag'] ) ) ),
				],
			];
		}

		$services = new WP_Query( $query_args );

		if ( ! $services->have_posts() ) {
			return '';
		}

		$columns = max( 1, intval( $atts['columns'] ) );

		ob_start();
		include self::locate_template();
		wp_reset_postdata();

		return ob_get_clean();
	}

	private static function locate_template() {
		$theme_template = locate_template( 'sb1-services/services-grid.php' );

		if ( $theme_template ) {
			return $theme_template;
		}

		return SBO_DIR . 'templates/services/services-grid.php';
	}
}
