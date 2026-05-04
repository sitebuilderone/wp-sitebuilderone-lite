<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class SBO_Services_Admin_Columns {

	public static function add_columns( $columns ) {
		$updated_columns = [];

		foreach ( $columns as $key => $label ) {
			$updated_columns[ $key ] = $label;

			if ( 'cb' === $key ) {
				$updated_columns['sbo_featured_image'] = __( 'Image', 'wp-sitebuilderone-lite' );
			}

			if ( 'title' === $key ) {
				$updated_columns['sbo_service_tags'] = __( 'Tags', 'wp-sitebuilderone-lite' );
				$updated_columns['sbo_menu_order'] = __( 'Order', 'wp-sitebuilderone-lite' );
			}
		}

		if ( ! isset( $updated_columns['sbo_featured_image'] ) ) {
			$updated_columns['sbo_featured_image'] = __( 'Image', 'wp-sitebuilderone-lite' );
		}

		if ( ! isset( $updated_columns['sbo_service_tags'] ) ) {
			$updated_columns['sbo_service_tags'] = __( 'Tags', 'wp-sitebuilderone-lite' );
		}

		if ( ! isset( $updated_columns['sbo_menu_order'] ) ) {
			$updated_columns['sbo_menu_order'] = __( 'Order', 'wp-sitebuilderone-lite' );
		}

		return $updated_columns;
	}

	public static function render_column( $column, $post_id ) {
		if ( 'sbo_featured_image' === $column ) {
			self::render_featured_image( $post_id );
			return;
		}

		if ( 'sbo_service_tags' === $column ) {
			self::render_service_tags( $post_id );
			return;
		}

		if ( 'sbo_menu_order' === $column ) {
			echo esc_html( get_post_field( 'menu_order', $post_id ) );
		}
	}

	public static function sortable_columns( $columns ) {
		$columns['sbo_menu_order'] = 'menu_order';
		return $columns;
	}

	private static function render_featured_image( $post_id ) {
		if ( has_post_thumbnail( $post_id ) ) {
			echo get_the_post_thumbnail(
				$post_id,
				[ 64, 64 ],
				[
					'class' => 'sbo-service-list-image',
					'alt'   => esc_attr( get_the_title( $post_id ) ),
				]
			);
			return;
		}

		echo '<span class="sbo-service-list-image-placeholder" aria-hidden="true">&mdash;</span>';
	}

	private static function render_service_tags( $post_id ) {
		$terms = get_the_terms( $post_id, 'service_tag' );

		if ( empty( $terms ) || is_wp_error( $terms ) ) {
			echo '<span aria-hidden="true">&mdash;</span>';
			return;
		}

		$links = [];

		foreach ( $terms as $term ) {
			$url = add_query_arg(
				[
					'post_type'   => 'service',
					'service_tag' => $term->slug,
				],
				admin_url( 'edit.php' )
			);

			$links[] = sprintf(
				'<a href="%s">%s</a>',
				esc_url( $url ),
				esc_html( $term->name )
			);
		}

		echo implode( ', ', $links );
	}

	public static function enqueue_styles( $hook ) {
		if ( 'edit.php' !== $hook ) {
			return;
		}

		$screen = get_current_screen();

		if ( ! $screen || 'service' !== $screen->post_type ) {
			return;
		}

		wp_enqueue_style(
			'sbo-services-admin',
			SBO_URL . 'assets/css/services-admin.css',
			[],
			SBO_VERSION
		);
	}
}
