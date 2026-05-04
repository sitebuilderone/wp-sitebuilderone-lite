<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class SBO_FAQ_HowTo_Meta_Boxes {

	const MAX_STEPS = 10;

	public static function add() {
		add_meta_box(
			'sbo-howto-meta',
			__( 'HowTo Details', 'wp-sitebuilderone-lite' ),
			[ __CLASS__, 'render' ],
			'howto',
			'normal',
			'high'
		);
	}

	public static function render( $post ) {
		wp_nonce_field( 'sbo_howto_meta_save', 'sbo_howto_meta_nonce' );

		$description = get_post_meta( $post->ID, '_sb1_howto_description', true );
		$total_time  = get_post_meta( $post->ID, '_sb1_howto_total_time', true );
		$supplies    = get_post_meta( $post->ID, '_sb1_howto_supplies', true );
		$steps       = get_post_meta( $post->ID, '_sb1_howto_steps', true );
		$steps       = is_array( $steps ) ? $steps : [];
		?>
		<div id="sbo-howto-meta">
			<div class="sbo-faq-meta-field">
				<label for="sbo_howto_description"><?php esc_html_e( 'Description', 'wp-sitebuilderone-lite' ); ?></label>
				<textarea id="sbo_howto_description" name="sbo_howto_description" rows="3"><?php echo esc_textarea( $description ); ?></textarea>
				<p class="description"><?php esc_html_e( 'Short summary used in HowTo schema. If empty, the post excerpt is used.', 'wp-sitebuilderone-lite' ); ?></p>
			</div>

			<div class="sbo-faq-meta-field">
				<label for="sbo_howto_total_time"><?php esc_html_e( 'Total Time', 'wp-sitebuilderone-lite' ); ?></label>
				<input id="sbo_howto_total_time" name="sbo_howto_total_time" type="text" value="<?php echo esc_attr( $total_time ); ?>" placeholder="PT10M" />
				<p class="description"><?php esc_html_e( 'Use ISO 8601 duration format, for example PT10M, PT1H, or PT1H30M.', 'wp-sitebuilderone-lite' ); ?></p>
			</div>

			<div class="sbo-faq-meta-field">
				<label for="sbo_howto_supplies"><?php esc_html_e( 'Supplies', 'wp-sitebuilderone-lite' ); ?></label>
				<textarea id="sbo_howto_supplies" name="sbo_howto_supplies" rows="4"><?php echo esc_textarea( $supplies ); ?></textarea>
				<p class="description"><?php esc_html_e( 'Enter one supply per line.', 'wp-sitebuilderone-lite' ); ?></p>
			</div>

			<div class="sbo-faq-meta-field">
				<h3><?php esc_html_e( 'Steps', 'wp-sitebuilderone-lite' ); ?></h3>
				<p class="description"><?php esc_html_e( 'Fill in as many steps as needed. Each step needs at least a name or instructions.', 'wp-sitebuilderone-lite' ); ?></p>

				<?php for ( $index = 0; $index < self::MAX_STEPS; $index++ ) : ?>
					<?php $step = isset( $steps[ $index ] ) && is_array( $steps[ $index ] ) ? $steps[ $index ] : []; ?>
					<div class="sbo-howto-step">
						<h4><?php echo esc_html( sprintf( __( 'Step %d', 'wp-sitebuilderone-lite' ), $index + 1 ) ); ?></h4>

						<label for="sbo_howto_steps_<?php echo esc_attr( $index ); ?>_name"><?php esc_html_e( 'Step Name', 'wp-sitebuilderone-lite' ); ?></label>
						<input id="sbo_howto_steps_<?php echo esc_attr( $index ); ?>_name" name="sbo_howto_steps[<?php echo esc_attr( $index ); ?>][name]" type="text" value="<?php echo esc_attr( $step['name'] ?? '' ); ?>" />

						<label for="sbo_howto_steps_<?php echo esc_attr( $index ); ?>_text"><?php esc_html_e( 'Instructions', 'wp-sitebuilderone-lite' ); ?></label>
						<textarea id="sbo_howto_steps_<?php echo esc_attr( $index ); ?>_text" name="sbo_howto_steps[<?php echo esc_attr( $index ); ?>][text]" rows="3"><?php echo esc_textarea( $step['text'] ?? '' ); ?></textarea>

						<label for="sbo_howto_steps_<?php echo esc_attr( $index ); ?>_url"><?php esc_html_e( 'Step URL', 'wp-sitebuilderone-lite' ); ?></label>
						<input id="sbo_howto_steps_<?php echo esc_attr( $index ); ?>_url" name="sbo_howto_steps[<?php echo esc_attr( $index ); ?>][url]" type="url" value="<?php echo esc_url( $step['url'] ?? '' ); ?>" />

						<label for="sbo_howto_steps_<?php echo esc_attr( $index ); ?>_image"><?php esc_html_e( 'Step Image URL', 'wp-sitebuilderone-lite' ); ?></label>
						<input id="sbo_howto_steps_<?php echo esc_attr( $index ); ?>_image" name="sbo_howto_steps[<?php echo esc_attr( $index ); ?>][image]" type="url" value="<?php echo esc_url( $step['image'] ?? '' ); ?>" />
					</div>
				<?php endfor; ?>
			</div>
		</div>
		<?php
	}

	public static function save( $post_id ) {
		if ( ! isset( $_POST['sbo_howto_meta_nonce'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sbo_howto_meta_nonce'] ) ), 'sbo_howto_meta_save' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		self::update_text_meta( $post_id, '_sb1_howto_description', 'sbo_howto_description', 'textarea' );
		self::update_text_meta( $post_id, '_sb1_howto_total_time', 'sbo_howto_total_time' );
		self::update_text_meta( $post_id, '_sb1_howto_supplies', 'sbo_howto_supplies', 'textarea' );
		self::update_steps_meta( $post_id );
	}

	private static function update_text_meta( $post_id, $meta_key, $post_key, $type = 'text' ) {
		$value = isset( $_POST[ $post_key ] ) ? wp_unslash( $_POST[ $post_key ] ) : '';
		$value = 'textarea' === $type ? sanitize_textarea_field( $value ) : sanitize_text_field( $value );

		if ( '' === $value ) {
			delete_post_meta( $post_id, $meta_key );
			return;
		}

		update_post_meta( $post_id, $meta_key, $value );
	}

	private static function update_steps_meta( $post_id ) {
		$steps = [];

		if ( isset( $_POST['sbo_howto_steps'] ) && is_array( $_POST['sbo_howto_steps'] ) ) {
			foreach ( array_slice( wp_unslash( $_POST['sbo_howto_steps'] ), 0, self::MAX_STEPS ) as $step ) {
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
		}

		if ( empty( $steps ) ) {
			delete_post_meta( $post_id, '_sb1_howto_steps' );
			return;
		}

		update_post_meta( $post_id, '_sb1_howto_steps', $steps );
	}

	public static function enqueue_styles( $hook ) {
		global $post;

		if ( ! in_array( $hook, [ 'post.php', 'post-new.php' ], true ) ) {
			return;
		}

		if ( ! $post || 'howto' !== $post->post_type ) {
			return;
		}

		wp_enqueue_style( 'sbo-faq-admin', SBO_URL . 'assets/css/faq-admin.css', [], SBO_VERSION );
	}
}
