<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class SBO_FAQ_Admin_Settings {

	const OPTION_FAQ_SLUG    = 'sb1_faq_slug';
	const OPTION_HOWTO_SLUG  = 'sb1_howto_slug';
	const DEFAULT_FAQ_SLUG   = 'faq';
	const DEFAULT_HOWTO_SLUG = 'howto';

	public static function register() {
		register_setting(
			'sbo_faq_settings',
			self::OPTION_FAQ_SLUG,
			[
				'type'              => 'string',
				'sanitize_callback' => [ __CLASS__, 'sanitize_faq_slug' ],
				'default'           => self::DEFAULT_FAQ_SLUG,
			]
		);

		register_setting(
			'sbo_faq_settings',
			self::OPTION_HOWTO_SLUG,
			[
				'type'              => 'string',
				'sanitize_callback' => [ __CLASS__, 'sanitize_howto_slug' ],
				'default'           => self::DEFAULT_HOWTO_SLUG,
			]
		);

		add_action( 'update_option_' . self::OPTION_FAQ_SLUG, [ __CLASS__, 'flush_rewrites_after_slug_change' ], 10, 2 );
		add_action( 'update_option_' . self::OPTION_HOWTO_SLUG, [ __CLASS__, 'flush_rewrites_after_slug_change' ], 10, 2 );
		add_action( 'add_option_' . self::OPTION_FAQ_SLUG, [ __CLASS__, 'flush_rewrites_after_slug_added' ], 10, 2 );
		add_action( 'add_option_' . self::OPTION_HOWTO_SLUG, [ __CLASS__, 'flush_rewrites_after_slug_added' ], 10, 2 );
	}

	public static function add_menu() {
		add_submenu_page(
			'sitebuilderone',
			__( 'FAQ & HowTo', 'wp-sitebuilderone-lite' ),
			__( 'FAQ & HowTo', 'wp-sitebuilderone-lite' ),
			'manage_options',
			'sbo-faq-settings',
			[ __CLASS__, 'render_page' ]
		);
	}

	public static function render_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$faq_slug   = self::get_faq_slug();
		$howto_slug = self::get_howto_slug();
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'FAQ & HowTo Options', 'wp-sitebuilderone-lite' ); ?></h1>
			<p><?php esc_html_e( 'Manage the URL bases used by the FAQ and HowTo content types.', 'wp-sitebuilderone-lite' ); ?></p>

			<form method="post" action="options.php">
				<?php settings_fields( 'sbo_faq_settings' ); ?>

				<table class="form-table" role="presentation">
					<tr>
						<th scope="row">
							<label for="<?php echo esc_attr( self::OPTION_FAQ_SLUG ); ?>"><?php esc_html_e( 'FAQ URL Base', 'wp-sitebuilderone-lite' ); ?></label>
						</th>
						<td>
							<input id="<?php echo esc_attr( self::OPTION_FAQ_SLUG ); ?>" name="<?php echo esc_attr( self::OPTION_FAQ_SLUG ); ?>" type="text" class="regular-text" value="<?php echo esc_attr( $faq_slug ); ?>" />
							<p class="description">
								<?php
								printf(
									esc_html__( 'Example: %s', 'wp-sitebuilderone-lite' ),
									esc_html( home_url( '/' . $faq_slug . '/sample-faq/' ) )
								);
								?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="<?php echo esc_attr( self::OPTION_HOWTO_SLUG ); ?>"><?php esc_html_e( 'HowTo URL Base', 'wp-sitebuilderone-lite' ); ?></label>
						</th>
						<td>
							<input id="<?php echo esc_attr( self::OPTION_HOWTO_SLUG ); ?>" name="<?php echo esc_attr( self::OPTION_HOWTO_SLUG ); ?>" type="text" class="regular-text" value="<?php echo esc_attr( $howto_slug ); ?>" />
							<p class="description">
								<?php
								printf(
									esc_html__( 'Example: %s', 'wp-sitebuilderone-lite' ),
									esc_html( home_url( '/' . $howto_slug . '/how-to-register-a-domain-name/' ) )
								);
								?>
							</p>
						</td>
					</tr>
				</table>

				<?php submit_button(); ?>
			</form>

			<h2><?php esc_html_e( 'Shortcodes', 'wp-sitebuilderone-lite' ); ?></h2>
			<p><code>[sb1_faq]</code></p>
			<p><code>[sb1_howto tag="smart-thermostats"]</code></p>
			<p><code>[sb1_howto tags="smart-thermostats,42" count="3" orderby="title" order="ASC"]</code></p>
		</div>
		<?php
	}

	public static function get_faq_slug() {
		return self::get_slug_option( self::OPTION_FAQ_SLUG, self::DEFAULT_FAQ_SLUG );
	}

	public static function get_howto_slug() {
		return self::get_slug_option( self::OPTION_HOWTO_SLUG, self::DEFAULT_HOWTO_SLUG );
	}

	public static function sanitize_faq_slug( $value ) {
		return self::sanitize_slug( $value, self::DEFAULT_FAQ_SLUG );
	}

	public static function sanitize_howto_slug( $value ) {
		return self::sanitize_slug( $value, self::DEFAULT_HOWTO_SLUG );
	}

	public static function flush_rewrites_after_slug_change( $old_value, $value ) {
		if ( $old_value === $value ) {
			return;
		}

		SBO_FAQ_CPT::register();
		SBO_FAQ_HowTo_CPT::register();
		flush_rewrite_rules();
		update_option( 'sbo_faq_rewrite_version', SBO_VERSION, false );
	}

	public static function flush_rewrites_after_slug_added( $option, $value ) {
		SBO_FAQ_CPT::register();
		SBO_FAQ_HowTo_CPT::register();
		flush_rewrite_rules();
		update_option( 'sbo_faq_rewrite_version', SBO_VERSION, false );
	}

	private static function sanitize_slug( $value, $default ) {
		$value = sanitize_title( $value );
		return $value ? $value : $default;
	}

	private static function get_slug_option( $option, $default ) {
		$value = get_option( $option, $default );
		$value = sanitize_title( $value );

		return $value ? $value : $default;
	}
}
