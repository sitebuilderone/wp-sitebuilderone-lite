<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class SBO_FAQ_Meta_Boxes {

	public static function add() {
		add_meta_box(
			'sbo-faq-meta',
			__( 'FAQ Details', 'wp-sitebuilderone-lite' ),
			[ __CLASS__, 'render' ],
			'faq',
			'normal',
			'high'
		);
	}

	public static function render( $post ) {
		wp_nonce_field( 'sbo_faq_meta_save', 'sbo_faq_meta_nonce' );

		$answer          = get_post_meta( $post->ID, '_sb1_faq_answer', true );
		$related_service = get_post_meta( $post->ID, '_sb1_faq_related_service', true );
		$services        = post_type_exists( 'service' ) ? get_posts( [
			'post_type'      => 'service',
			'numberposts'    => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
			'post_status'    => 'publish',
		] ) : [];
		?>
		<div id="sbo-faq-meta">
			<div class="sbo-faq-meta-field">
				<label for="sbo_faq_answer"><?php esc_html_e( 'Answer', 'wp-sitebuilderone-lite' ); ?></label>
				<textarea id="sbo_faq_answer" name="sbo_faq_answer" rows="4"><?php echo esc_textarea( $answer ); ?></textarea>
				<p class="description"><?php esc_html_e( 'Plain-text answer used in shortcode output and schema markup.', 'wp-sitebuilderone-lite' ); ?></p>
			</div>

			<div class="sbo-faq-meta-field">
				<label for="sbo_faq_related_service"><?php esc_html_e( 'Related Service', 'wp-sitebuilderone-lite' ); ?></label>
				<?php if ( empty( $services ) ) : ?>
					<p class="description"><?php esc_html_e( 'No services found. Add services to link them here.', 'wp-sitebuilderone-lite' ); ?></p>
				<?php else : ?>
					<select id="sbo_faq_related_service" name="sbo_faq_related_service">
						<option value=""><?php esc_html_e( '- Standalone (no service) -', 'wp-sitebuilderone-lite' ); ?></option>
						<?php foreach ( $services as $service ) : ?>
							<option value="<?php echo esc_attr( $service->ID ); ?>" <?php selected( $related_service, $service->ID ); ?>>
								<?php echo esc_html( $service->post_title ); ?>
							</option>
						<?php endforeach; ?>
					</select>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	public static function save( $post_id ) {
		if ( ! isset( $_POST['sbo_faq_meta_nonce'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sbo_faq_meta_nonce'] ) ), 'sbo_faq_meta_save' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( isset( $_POST['sbo_faq_answer'] ) ) {
			$answer = sanitize_textarea_field( wp_unslash( $_POST['sbo_faq_answer'] ) );
			if ( '' === $answer ) {
				delete_post_meta( $post_id, '_sb1_faq_answer' );
			} else {
				update_post_meta( $post_id, '_sb1_faq_answer', $answer );
			}
		}

		if ( isset( $_POST['sbo_faq_related_service'] ) ) {
			$service_id = absint( $_POST['sbo_faq_related_service'] );
			if ( $service_id ) {
				update_post_meta( $post_id, '_sb1_faq_related_service', $service_id );
			} else {
				delete_post_meta( $post_id, '_sb1_faq_related_service' );
			}
		}
	}

	public static function enqueue_styles( $hook ) {
		global $post;

		if ( ! in_array( $hook, [ 'post.php', 'post-new.php' ], true ) ) {
			return;
		}

		if ( ! $post || 'faq' !== $post->post_type ) {
			return;
		}

		wp_enqueue_style( 'sbo-faq-admin', SBO_URL . 'assets/css/faq-admin.css', [], SBO_VERSION );
	}
}
