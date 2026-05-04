<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class SBO_Services_Meta_Boxes {

	public static function add() {
		add_meta_box(
			'sbo-services-meta',
			__( 'Service Details', 'wp-sitebuilderone-lite' ),
			[ __CLASS__, 'render' ],
			'service',
			'normal',
			'high'
		);
	}

	public static function render( $post ) {
		wp_nonce_field( 'sbo_services_meta_save', 'sbo_services_meta_nonce' );

		$short_description = get_post_meta( $post->ID, '_sb1_short_description', true );
		$icon              = get_post_meta( $post->ID, '_sb1_icon', true );
		$cta_url           = get_post_meta( $post->ID, '_sb1_cta_url', true );
		$service_area      = get_post_meta( $post->ID, '_sb1_service_area', true );
		$service_type      = get_post_meta( $post->ID, '_sb1_service_type', true );
		?>
		<div id="sbo-services-meta">
			<div class="sbo-service-meta-field">
				<label for="sbo_short_description"><?php esc_html_e( 'Short Description', 'wp-sitebuilderone-lite' ); ?></label>
				<textarea id="sbo_short_description" name="sbo_short_description" rows="3"><?php echo esc_textarea( $short_description ); ?></textarea>
			</div>

			<div class="sbo-service-meta-field">
				<label for="sbo_icon"><?php esc_html_e( 'Icon (URL or CSS class)', 'wp-sitebuilderone-lite' ); ?></label>
				<input type="text" id="sbo_icon" name="sbo_icon" value="<?php echo esc_attr( $icon ); ?>" />
				<p class="description"><?php esc_html_e( 'Enter an image URL or a CSS class, e.g. fa-solid fa-gear.', 'wp-sitebuilderone-lite' ); ?></p>
			</div>

			<div class="sbo-service-meta-field">
				<label for="sbo_cta_url"><?php esc_html_e( 'CTA Button URL', 'wp-sitebuilderone-lite' ); ?></label>
				<input type="url" id="sbo_cta_url" name="sbo_cta_url" value="<?php echo esc_attr( $cta_url ); ?>" />
			</div>

			<div class="sbo-service-meta-field">
				<label for="sbo_service_type"><?php esc_html_e( 'Service Type', 'wp-sitebuilderone-lite' ); ?></label>
				<input type="text" id="sbo_service_type" name="sbo_service_type" value="<?php echo esc_attr( $service_type ); ?>" />
				<p class="description"><?php esc_html_e( 'Used in Schema.org markup, e.g. Web Design, Consulting, Photography.', 'wp-sitebuilderone-lite' ); ?></p>
			</div>

			<div class="sbo-service-meta-field">
				<label for="sbo_service_area"><?php esc_html_e( 'Area Served', 'wp-sitebuilderone-lite' ); ?></label>
				<input type="text" id="sbo_service_area" name="sbo_service_area" value="<?php echo esc_attr( $service_area ); ?>" />
				<p class="description"><?php esc_html_e( 'Used in Schema.org markup, e.g. New York or Nationwide.', 'wp-sitebuilderone-lite' ); ?></p>
			</div>
		</div>
		<?php
	}

	public static function save( $post_id ) {
		if ( ! isset( $_POST['sbo_services_meta_nonce'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sbo_services_meta_nonce'] ) ), 'sbo_services_meta_save' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		self::update_text_meta( $post_id, '_sb1_short_description', 'sbo_short_description', 'textarea' );
		self::update_text_meta( $post_id, '_sb1_icon', 'sbo_icon' );
		self::update_url_meta( $post_id, '_sb1_cta_url', 'sbo_cta_url' );
		self::update_text_meta( $post_id, '_sb1_service_type', 'sbo_service_type' );
		self::update_text_meta( $post_id, '_sb1_service_area', 'sbo_service_area' );
	}

	private static function update_text_meta( $post_id, $meta_key, $post_key, $type = 'text' ) {
		if ( ! isset( $_POST[ $post_key ] ) ) {
			return;
		}

		$value = wp_unslash( $_POST[ $post_key ] );
		$value = 'textarea' === $type ? sanitize_textarea_field( $value ) : sanitize_text_field( $value );

		if ( '' === $value ) {
			delete_post_meta( $post_id, $meta_key );
			return;
		}

		update_post_meta( $post_id, $meta_key, $value );
	}

	private static function update_url_meta( $post_id, $meta_key, $post_key ) {
		if ( ! isset( $_POST[ $post_key ] ) ) {
			return;
		}

		$value = esc_url_raw( wp_unslash( $_POST[ $post_key ] ) );
		if ( '' === $value ) {
			delete_post_meta( $post_id, $meta_key );
			return;
		}

		update_post_meta( $post_id, $meta_key, $value );
	}

	public static function enqueue_styles( $hook ) {
		global $post;

		if ( ! in_array( $hook, [ 'post.php', 'post-new.php' ], true ) ) {
			return;
		}

		if ( ! $post || 'service' !== $post->post_type ) {
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
