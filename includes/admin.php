<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// ---------------------------------------------------------------------------
// Add SiteBuilderOne link to the WP Admin top bar.
// ---------------------------------------------------------------------------
add_action( 'admin_bar_menu', function ( WP_Admin_Bar $bar ) {
    if ( ! current_user_can( 'manage_options' ) ) return;

    $bar->add_node( [
        'id'    => 'sbo-settings',
        'title' => 'SiteBuilderOne',
        'href'  => admin_url( 'options-general.php?page=wp-sitebuilderone-lite' ),
        'meta'  => [
            'title' => 'SiteBuilderOne Settings',
        ],
    ] );
}, 100 );

// ---------------------------------------------------------------------------
// Required plugins notice on the Plugins page.
// ---------------------------------------------------------------------------
add_action( 'admin_notices', function () {
    $screen = get_current_screen();
    if ( ! $screen || 'plugins' !== $screen->id ) return;
    if ( ! current_user_can( 'manage_options' ) ) return;

    $required = [
        [
            'name'   => 'WP Sitemap Page',
            'slug'   => 'wp-sitemap-page',
            'check'  => 'wp-sitemap-page/wp-sitemap-page.php', // folder/main-file.php
			],

		[
    'name'  => 'RankMath SEO',
    'slug'  => 'seo-by-rank-math',
    'check' => 'seo-by-rank-math/rank-math.php',
],
[
    'name'  => 'RankMath Instant Indexing',
    'slug'  => 'fast-indexing-api',
    'check' => 'fast-indexing-api/instant-indexing.php',
],
[
    'name'  => 'SiteKit by Google',
    'slug'  => 'google-site-kit',
    'check' => 'google-site-kit/google-site-kit.php',
],
[
    'name'  => 'Clarity',
    'slug'  => 'microsoft-clarity',
    'check' => 'microsoft-clarity/index.php',
],
[
    'name'  => 'LiteSpeed Cache',
    'slug'  => 'litespeed-cache',
    'check' => 'litespeed-cache/litespeed-cache.php',
],
[
    'name'  => 'Google Reviews by Trustindex',
    'slug'  => 'wp-reviews-plugin-for-google',
    'check' => 'wp-reviews-plugin-for-google/wp-reviews-plugin-for-google.php',
],
[
    'name'  => 'Redirection',
    'slug'  => 'redirection',
    'check' => 'redirection/redirection.php',
],
[
    'name'  => 'ReCaptcha',
    'slug'  => 'advanced-google-recaptcha',
    'check' => 'advanced-google-recaptcha/advanced-google-recaptcha.php',
],


    ];

    $missing = [];
    foreach ( $required as $plugin ) {
        if ( ! is_plugin_active( $plugin['check'] ) ) {
            $install_url = wp_nonce_url(
                admin_url( 'update.php?action=install-plugin&plugin=' . $plugin['slug'] ),
                'install-plugin_' . $plugin['slug']
            );
            $missing[] = sprintf(
                '<strong>%s</strong> — <a href="%s">Install now</a>',
                esc_html( $plugin['name'] ),
                esc_url( $install_url )
            );
        }
    }

    if ( empty( $missing ) ) return;
    ?>
    <div class="notice notice-warning">
        <p><strong>SiteBuilderOne</strong> recommends the following plugin(s):</p>
        <ul style="list-style:disc;margin-left:1.5em;">
            <?php foreach ( $missing as $item ) : ?>
                <li><?php echo $item; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php
} );

// ---------------------------------------------------------------------------
// Field schema — single source of truth used by admin, shortcodes, and CSV.
// ---------------------------------------------------------------------------
function sbo_get_field_schema(): array {
	return [
		'Branding' => [
			'website_name'             => [ 'label' => 'Website Name',              'type' => 'text' ],
			'one_business_logo'        => [ 'label' => 'Business Logo URL',         'type' => 'url' ],
			'one_business_description' => [ 'label' => 'Business Description',      'type' => 'textarea' ],
			'one_business_keywords'    => [ 'label' => 'Business Keywords',         'type' => 'text' ],
			'one_banner_image'         => [ 'label' => 'Banner Image URL',          'type' => 'url' ],
		],
		'Key Web Pages' => [
			'one_page_about'         => [ 'label' => 'About',              'type' => 'page' ],
			'one_page_contact'         => [ 'label' => 'Contact',              'type' => 'page' ],
			'one_page_sitemap'         => [ 'label' => 'Sitemap',              'type' => 'page' ],
			
		],
		'Marketing' => [
			'one_headline'         => [ 'label' => 'Headline',              'type' => 'text' ],
			'one_headline_support' => [ 'label' => 'Headline Support Copy', 'type' => 'textarea' ],
			'one_marketing_image'  => [ 'label' => 'Marketing Image URL',   'type' => 'url' ],
			'one_cta_text'         => [ 'label' => 'CTA text',              'type' => 'text' ],
		],
		'Business Information' => [
			'one_business_name'  => [ 'label' => 'Business Name',      'type' => 'text' ],
			'one_business_phone' => [ 'label' => 'Phone (display)',     'type' => 'text' ],
			'one_phone_web_ready'=> [ 'label' => 'Phone (digits only)', 'type' => 'text' ],
			'one_business_email' => [ 'label' => 'Business Email',      'type' => 'email' ],
		],
		'Physical Address' => [
			'one_street_address'   => [ 'label' => 'Street Address',        'type' => 'text' ],
			'one_city'             => [ 'label' => 'City',                  'type' => 'text' ],
			'one_state'            => [ 'label' => 'State / Province',      'type' => 'text' ],
			'one_postal_code'      => [ 'label' => 'Postal / ZIP Code',     'type' => 'text' ],
			'one_country'          => [ 'label' => 'Country Code',          'type' => 'text' ],
			'one_latitude'         => [ 'label' => 'Latitude',              'type' => 'text' ],
			'one_longitude'        => [ 'label' => 'Longitude',             'type' => 'text' ],
			'one_google_map_url'   => [ 'label' => 'Google Map URL',        'type' => 'url' ],
			'one_google_map_embed' => [ 'label' => 'Google Map Embed Code', 'type' => 'textarea', 'raw' => true ],
		],
		'Social Media' => [
			'social-facebook'  => [ 'label' => 'Facebook',              'type' => 'url' ],
			'social-linkedin'  => [ 'label' => 'LinkedIn',              'type' => 'url' ],
			'social-youtube'   => [ 'label' => 'YouTube',               'type' => 'url' ],
			'social-twitter-x' => [ 'label' => 'Twitter / X',           'type' => 'url' ],
			'social-wordpress' => [ 'label' => 'WordPress.org Profile', 'type' => 'url' ],
			'social-yelp'      => [ 'label' => 'Yelp',                  'type' => 'url' ],
			'social-github'    => [ 'label' => 'GitHub',                'type' => 'url' ],
		],
		'Business Schema Details' => [
			'one_price_range'   => [ 'label' => 'Price Range',    'type' => 'text' ],
			'one_opening_hours' => [ 'label' => 'Opening Hours',  'type' => 'textarea' ],
		],
		'Integrations' => [
			'one_header_code'                    => [ 'label' => 'Header Code (meta tags)',      'type' => 'textarea', 'raw' => true ],
			'one_g-google_analytics'             => [ 'label' => 'Google Analytics URL',        'type' => 'url' ],
			'one_g-google_search_console'        => [ 'label' => 'Google Search Console URL',   'type' => 'url' ],
			'one_google_search_console_insights' => [ 'label' => 'Search Console Insights URL', 'type' => 'url' ],
			'one_looker_studio'                  => [ 'label' => 'Looker Studio Embed',         'type' => 'textarea', 'raw' => true ],
			'one_bing_webmaster'                 => [ 'label' => 'Bing Webmaster URL',          'type' => 'url' ],
		],
	];
}

// ---------------------------------------------------------------------------
// Sanitize a single field value based on its type and raw flag.
// ---------------------------------------------------------------------------
function sbo_sanitize_field( string $value, string $type, bool $raw ): string {
	if ( $raw ) {
		return wp_kses_post( $value );
	}
	return match ( $type ) {
		'url'      => esc_url_raw( $value ),
		'email'    => sanitize_email( $value ),
		'page'     => esc_url_raw( $value ),
		'textarea' => sanitize_textarea_field( $value ),
		default    => sanitize_text_field( $value ),
	};
}

// ---------------------------------------------------------------------------
// Admin menu.
// ---------------------------------------------------------------------------
add_action( 'admin_menu', function () {
	add_options_page(
		'SiteBuilderOne Settings',
		'SiteBuilderOne',
		'manage_options',
		'wp-sitebuilderone-lite',
		'sbo_render_admin_page'
	);
} );

// ---------------------------------------------------------------------------
// Enqueue admin CSS and JavaScript.
// ---------------------------------------------------------------------------
add_action( 'admin_enqueue_scripts', function ( string $hook ) {
	if ( 'settings_page_wp-sitebuilderone-lite' !== $hook ) return;
	wp_enqueue_style( 'sbo-admin', SBO_URL . 'assets/css/admin.css', [], SBO_VERSION );
	wp_enqueue_script( 'sbo-admin', SBO_URL . 'assets/js/admin.js', [], SBO_VERSION, true );
} );

// ---------------------------------------------------------------------------
// Save handler.
// ---------------------------------------------------------------------------
add_action( 'admin_post_sbo_save_settings', function () {
	if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Unauthorized' );
	check_admin_referer( 'sbo_save_settings', 'sbo_nonce' );

	$schema = sbo_get_field_schema();
	$data   = [];

	foreach ( $schema as $fields ) {
		foreach ( $fields as $key => $meta ) {
			$raw_value  = isset( $_POST['sbo_fields'][ $key ] ) ? wp_unslash( $_POST['sbo_fields'][ $key ] ) : '';
			$data[ $key ] = sbo_sanitize_field( (string) $raw_value, $meta['type'], ! empty( $meta['raw'] ) );
		}
	}

	update_option( SBO_OPTION_KEY, $data );

	wp_safe_redirect( add_query_arg(
		[ 'page' => 'wp-sitebuilderone-lite', 'updated' => '1' ],
		admin_url( 'options-general.php' )
	) );
	exit;
} );

// ---------------------------------------------------------------------------
// Admin page render.
// ---------------------------------------------------------------------------
function sbo_render_admin_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) return;

	$schema  = sbo_get_field_schema();
	$options = get_option( SBO_OPTION_KEY, [] );

	// Build export URL (GET, nonce in query string).
	$export_url = wp_nonce_url(
		add_query_arg( 'action', 'sbo_export_csv', admin_url( 'admin-post.php' ) ),
		'sbo_export_csv'
	);
	?>
	<div class="wrap sbo-wrap">
		<h1>SiteBuilderOne Settings</h1>

		<?php if ( isset( $_GET['updated'] ) ) : ?>
			<div class="notice notice-success is-dismissible"><p>Settings saved.</p></div>
		<?php endif; ?>

		<?php if ( isset( $_GET['imported'] ) ) : ?>
			<div class="notice notice-success is-dismissible">
				<p><?php echo esc_html( (int) $_GET['imported'] ) . ' field(s) imported successfully.'; ?></p>
			</div>
		<?php endif; ?>

		<?php if ( isset( $_GET['sbo_error'] ) ) : ?>
			<div class="notice notice-error is-dismissible">
				<p>
				<?php
				$err = sanitize_key( $_GET['sbo_error'] );
				echo 'no_file' === $err ? 'No CSV file was uploaded.' : 'Import failed. Please check your CSV and try again.';
				?>
				</p>
			</div>
		<?php endif; ?>

		<!-- Main settings form -->
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="sbo_save_settings">
			<?php wp_nonce_field( 'sbo_save_settings', 'sbo_nonce' ); ?>

			<?php foreach ( $schema as $section => $fields ) : ?>
				<h2 class="sbo-section-heading"><?php echo esc_html( $section ); ?></h2>
				<table class="form-table sbo-fields-table" role="presentation">
					<tbody>
					<?php foreach ( $fields as $key => $meta ) :
						$val     = $options[ $key ] ?? '';
						$is_raw  = ! empty( $meta['raw'] );
						$type    = $meta['type'];
						$html_id = 'sbo-field-' . sanitize_html_class( $key );
					?>
						<tr>
							<th scope="row">
								<label for="<?php echo esc_attr( $html_id ); ?>">
									<?php echo esc_html( $meta['label'] ); ?>
								</label>
							</th>
							<td>
								<?php if ( 'textarea' === $type ) : ?>
									<textarea
										id="<?php echo esc_attr( $html_id ); ?>"
										name="sbo_fields[<?php echo esc_attr( $key ); ?>]"
										rows="<?php echo $is_raw ? 6 : 4; ?>"
										class="large-text<?php echo $is_raw ? ' code' : ''; ?>"
									><?php echo esc_textarea( $val ); ?></textarea>
									<?php if ( $is_raw ) : ?>
										<p class="description sbo-field-hint">HTML accepted (iframe, meta tags). Scripts are stripped.</p>
									<?php endif; ?>
								<?php elseif ( 'page' === $type ) :
    $pages = get_pages( [ 'sort_column' => 'menu_order', 'sort_order' => 'asc' ] );
?>
    <select
        id="<?php echo esc_attr( $html_id ); ?>"
        name="sbo_fields[<?php echo esc_attr( $key ); ?>]"
        class="regular-text"
    >
        <option value="">— Select a page —</option>
        <?php foreach ( $pages as $page ) :
            $page_url = get_permalink( $page->ID );
        ?>
            <option value="<?php echo esc_attr( $page_url ); ?>"
                <?php selected( $val, $page_url ); ?>>
                <?php echo esc_html( $page->post_title ); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php if ( $val ) : ?>
        <a href="<?php echo esc_url( $val ); ?>" target="_blank" class="button button-small" style="margin-left:6px;">Visit ↗</a>
    <?php endif; ?>

<?php else : ?>
    <input
        type="<?php echo esc_attr( $type ); ?>"
        id="<?php echo esc_attr( $html_id ); ?>"
        name="sbo_fields[<?php echo esc_attr( $key ); ?>]"
        value="<?php echo esc_attr( $val ); ?>"
        class="regular-text"
    >
<?php endif; ?>

								<?php if ( '' !== $val ) : ?>
									<p class="description sbo-shortcode-ref">
										<strong>Shortcode:</strong>
										<code class="sbo-shortcode-code">[sbo_field name="<?php echo esc_attr( $key ); ?>"<?php echo $is_raw ? ' raw="true"' : ''; ?>]</code>
										<button type="button" class="button button-small sbo-copy-shortcode" data-shortcode="[sbo_field name=&quot;<?php echo esc_attr( $key ); ?>&quot;<?php echo $is_raw ? ' raw=&quot;true&quot;' : ''; ?>]">Copy</button>
									</p>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			<?php endforeach; ?>

			<?php submit_button( 'Save All Settings' ); ?>
		</form>

		<!-- CSV import/export -->
		<div class="sbo-csv-box">
			<h2>CSV Import / Export</h2>

			<h3>Export</h3>
			<p>Download all current settings as a CSV file.</p>
			<a href="<?php echo esc_url( $export_url ); ?>" class="button button-secondary">Export CSV</a>

			<h3>Import</h3>
			<p>Upload a CSV file matching the <code>Section,Field,Value</code> format to populate settings. Existing values not present in the CSV are kept.</p>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" enctype="multipart/form-data">
				<input type="hidden" name="action" value="sbo_import_csv">
				<?php wp_nonce_field( 'sbo_import_csv', 'sbo_import_nonce' ); ?>
				<input type="file" name="sbo_csv_file" accept=".csv">
				<?php submit_button( 'Import CSV', 'secondary', 'sbo_import_submit', false ); ?>
			</form>
		</div>
	</div>
	<?php
}
