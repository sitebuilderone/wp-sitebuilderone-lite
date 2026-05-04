<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class SBO_FAQ_HowTo_Shortcode {

	public static function register() {
		add_shortcode( 'sb1_howto', [ __CLASS__, 'render' ] );
	}

	public static function render( $atts ) {
		$atts = shortcode_atts(
			[
				'count'   => -1,
				'tag'     => '',
				'tags'    => '',
				'orderby' => 'menu_order',
				'order'   => 'ASC',
			],
			$atts,
			'sb1_howto'
		);

		$query_args = [
			'post_type'      => 'howto',
			'posts_per_page' => intval( $atts['count'] ),
			'post_status'    => 'publish',
			'orderby'        => sanitize_key( $atts['orderby'] ),
			'order'          => in_array( strtoupper( $atts['order'] ), [ 'ASC', 'DESC' ], true ) ? strtoupper( $atts['order'] ) : 'ASC',
			'no_found_rows'  => true,
		];

		$tag_terms = self::parse_tag_terms( $atts['tag'] ? $atts['tag'] : $atts['tags'] );

		if ( ! empty( $tag_terms['slugs'] ) || ! empty( $tag_terms['ids'] ) ) {
			$tax_queries = [];

			if ( ! empty( $tag_terms['slugs'] ) ) {
				$tax_queries[] = [
					'taxonomy' => 'post_tag',
					'field'    => 'slug',
					'terms'    => $tag_terms['slugs'],
				];
			}

			if ( ! empty( $tag_terms['ids'] ) ) {
				$tax_queries[] = [
					'taxonomy' => 'post_tag',
					'field'    => 'term_id',
					'terms'    => $tag_terms['ids'],
				];
			}

			$query_args['tax_query'] = array_merge( [ 'relation' => 'OR' ], $tax_queries );
		}

		$howtos = new WP_Query( $query_args );

		if ( ! $howtos->have_posts() ) {
			return '';
		}

		$howto_posts = $howtos->posts;

		ob_start();
		include self::locate_template();

		$schema = SBO_FAQ_HowTo_Schema::build_graph( $howto_posts );
		if ( $schema ) {
			echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
		}

		wp_reset_postdata();

		return ob_get_clean();
	}

	private static function parse_tag_terms( $value ) {
		$terms = [
			'ids'   => [],
			'slugs' => [],
		];

		if ( ! $value ) {
			return $terms;
		}

		$tags = array_filter( array_map( 'trim', explode( ',', $value ) ) );

		foreach ( $tags as $tag ) {
			if ( is_numeric( $tag ) ) {
				$terms['ids'][] = absint( $tag );
			} else {
				$terms['slugs'][] = sanitize_title( $tag );
			}
		}

		$terms['ids']   = array_values( array_unique( array_filter( $terms['ids'] ) ) );
		$terms['slugs'] = array_values( array_unique( array_filter( $terms['slugs'] ) ) );

		return $terms;
	}

	private static function locate_template() {
		$theme_template = locate_template( 'sb1-faq/howto-list.php' );

		if ( $theme_template ) {
			return $theme_template;
		}

		return SBO_DIR . 'templates/faq/howto-list.php';
	}
}
