<?php
/**
 * Plugin Name: SiteBuilderOne Lite
 * Description: Lightweight WordPress plugin for local business websites. Powered by LiveCanvas.
 * Version: 1.0.0
 * Author: SiteBuilderOne
 */
if (! defined('ABSPATH')) exit;
// ---------------------------------------------------------------------------
// 2. Field Schema (Normalized with Descriptions)
// ---------------------------------------------------------------------------
function sbo_get_field_schema(): array
{
	return [
		'Branding' => [
			'id' => 'branding',
			'description' => 'Core identity elements like logos and SEO keywords used across the site header and metadata[cite: 23].',
			'fields' => [
				'website_name'             => ['label' => 'Website Name',              'type' => 'text'],
				'one_home_url'             => ['label' => 'Home URL',                  'type' => 'text'],
				'one_business_logo'        => ['label' => 'Business Logo URL',         'type' => 'media'],
				'one_business_description' => ['label' => 'Business Description',      'type' => 'textarea'],
				'one_business_keywords'    => ['label' => 'Business Keywords',         'type' => 'text'],
				'one_banner_image'         => ['label' => 'Banner Image URL',          'type' => 'url'],
			]
		],
		'Header' => [
			'id' => 'header',
			'description' => 'Global header information',
			'fields' => [
				'one_header_cta_btn_text'  => ['label' => 'Button text', 'type' => 'text'],
				'one_header_cta_URL'         => ['label' => 'CTA page',              'type' => 'page'],
				'one_header_logo_h'         => ['label' => 'Logo height (px)',       'type' => 'text'],
				'one_header_logo_w'         => ['label' => 'Logo width (px)',       'type' => 'text'],

			]
		],
		'Global Footer' => [
			'id' => 'footer',
			'description' => 'Global footer information',
			'fields' => [
				'one_footer_desc'          => ['label' => 'Footer business description', 'type' => 'textarea', 'raw' => true],
				'one_footer_01_title'      => ['label' => 'Footer header 01 title',      'type' => 'text'],
				'one_footer_02_title'      => ['label' => 'Footer header 02 title',      'type' => 'text'],
			]
		],
		'Sticky Footer' => [
			'id' => 'stickyfooter',
			'description' => 'Design - sticky footer CTA',
			'fields' => [
				'one_footer_sticky_enable' => ['label' => 'Enable Sticky Mobile Footer', 'type' => 'checkbox'],
				'one_footer_sticky_text'   => ['label' => 'Button text', 'type' => 'text'],
				'one_footer_sticky_url'   => ['label' => 'Button URL', 'type' => 'text'],
				'one_footer_sticky_text_2'   => ['label' => 'Button text 2', 'type' => 'text'],
			]
		],		
		'Hero Marketing' => [
			'id' => 'marketing',
			'description' => 'Primary marketing copy and calls to action used in Hero sections[cite: 23].',
			'fields' => [
				'one_headline'         => ['label' => 'Headline',              'type' => 'text'],
				'one_headline_support' => ['label' => 'Headline Support Copy', 'type' => 'textarea'],
				'one_marketing_image'  => ['label' => 'Marketing Image URL',   'type' => 'media'],
				'one_cta_text'         => ['label' => 'CTA text',              'type' => 'text'],
				'one_cta_url'         => ['label' => 'CTA URL',              'type' => 'page'],
				'one_cta_text_02'         => ['label' => 'CTA text (02)',              'type' => 'text'],
				'one_cta_url_02'         => ['label' => 'CTA URL (02)',              'type' => 'page'],
			]
		],
		'Key Web Pages' => [
			'id' => 'businessinfo',
			'description' => 'Select important web pages for links and navigation',
			'fields' => [
				'one_page_about'         => ['label' => 'About',              'type' => 'page'],
				'one_page_blog'         => ['label' => 'Blog',              'type' => 'page'],
				'one_page_contact'         => ['label' => 'Contact',              'type' => 'page'],
				'one_page_sitemap'         => ['label' => 'Sitemap',              'type' => 'page'],
				'one_page_privacy'         => ['label' => 'Privacy',              'type' => 'page'],
				'one_page_terms'           => ['label' => 'Terms',                'type' => 'page'],
			]
		],
		'Business Information (NAP)' => [
			'id' => 'businessinfo',
			'description' => 'Essential contact details. Ensure the web-ready phone contains digits only for click-to-call[cite: 23].',
			'fields' => [
				'one_business_name'  => ['label' => 'Business Name',      'type' => 'text'],
				'one_business_phone' => ['label' => 'Phone (display)',     'type' => 'text'],
				'one_phone_web_ready' => ['label' => 'Phone (digits only)', 'type' => 'text'],
				'one_business_email' => ['label' => 'Business Email',      'type' => 'email'],
			]
		],
		'Physical Address' => [
			'id' => 'physicaladdress',
			'description' => 'Physical location data used for Local SEO and Google Maps integration[cite: 23].',
			'fields' => [
				'one_street_address'   => ['label' => 'Street Address',        'type' => 'text'],
				'one_city'             => ['label' => 'City',                  'type' => 'text'],
				'one_state'            => ['label' => 'State / Province',      'type' => 'text'],
				'one_postal_code'      => ['label' => 'Postal / ZIP Code',     'type' => 'text'],
				'one_country'          => ['label' => 'Country Code',          'type' => 'text'],
				'one_latitude'         => ['label' => 'Latitude',              'type' => 'text'],
				'one_longitude'        => ['label' => 'Longitude',             'type' => 'text'],
				'one_google_map_url'   => ['label' => 'Google Map URL',        'type' => 'url'],
				'one_google_map_embed' => ['label' => 'Google Map Embed Code', 'type' => 'textarea', 'raw' => true],
			]
		],
		'Integrations' => [
			'id' => 'integrations',
			'description' => 'Paste tracking scripts and meta tags here to be inserted into the site header[cite: 23].',
			'fields' => [
				'one_header_code'                    => ['label' => 'Header Code (meta tags)',      'type' => 'textarea', 'raw' => true],
				'one_g-google_analytics'             => ['label' => 'Google Analytics URL',        'type' => 'url'],
				'one_g-google_search_console'        => ['label' => 'Google Search Console URL',   'type' => 'url'],
				'one_looker_studio'                  => ['label' => 'Looker Studio Embed',         'type' => 'textarea', 'raw' => true],
			]
		],
		'Social Media' => [
			'id' => 'socialmedia',
			'description' => 'Links to your official social profiles. These help search engines verify your business authority.',
			'fields' => [
				// Global Styling for Icon Shortcodes
				'social-icon-width'      => ['label' => 'Global Icon Width',  'type' => 'text', 'default' => '2.1em'],
				'social-icon-height'     => ['label' => 'Global Icon Height', 'type' => 'text', 'default' => '2.1em'],
				'social-icon-fill'       => ['label' => 'Global Icon Color',  'type' => 'text', 'default' => 'currentColor'],
				// Profile Links
				'social-facebook'        => ['label' => 'Facebook URL',         'type' => 'url'],
				'social-instagram'       => ['label' => 'Instagram URL',        'type' => 'url'],
				'social-linkedin'        => ['label' => 'LinkedIn URL',         'type' => 'url'],
				'social-youtube'         => ['label' => 'YouTube URL',          'type' => 'url'],
				'social-twitter-x'       => ['label' => 'Twitter / X URL',      'type' => 'url'],
				'social-google-business' => ['label' => 'Google Business URL',  'type' => 'url'],
				'social-pinterest'       => ['label' => 'Pinterest URL',        'type' => 'url'],
				'social-bing'            => ['label' => 'Bing URL',             'type' => 'url'],
				'social-tiktok'          => ['label' => 'TikTok URL',           'type' => 'url'],
				'social-snapchat'        => ['label' => 'Snapchat URL',         'type' => 'url'],
				'social-reddit'          => ['label' => 'Reddit URL',           'type' => 'url'],
				'social-wordpress'       => ['label' => 'WordPress URL',        'type' => 'url'],
				'social-whatsapp'        => ['label' => 'WhatsApp URL',         'type' => 'url'],
				'social-yelp'            => ['label' => 'Yelp URL',             'type' => 'url'],
				'social-tripadvisor'     => ['label' => 'TripAdvisor URL',      'type' => 'url'],
				'social-github'          => ['label' => 'GitHub URL',           'type' => 'url'],
				'social-bbb'             => ['label' => 'BBB URL',              'type' => 'url'],
			]
		],
	];
}
// ---------------------------------------------------------------------------
// 3. Shortcode Handler (The "[sbo_field]" tool)
// ---------------------------------------------------------------------------
add_shortcode('sbo_field', function ($atts) {
	$a = shortcode_atts([
		'name' => '',
		'raw'  => 'false',
	], $atts);
	$val = sbo_get($a['name']);
	return ($a['raw'] === 'true') ? $val : esc_html($val);
});
// ---------------------------------------------------------------------------
// Admin menu - Top Level + Submenus
// ---------------------------------------------------------------------------
add_action('admin_menu', function () {
	// 1. Create the Top Level Menu
	add_menu_page(
		'SiteBuilderOne',                // Page Title
		'SiteBuilderOne',                // Menu Title
		'manage_options',                // Capability
		'sitebuilderone',                // Menu Slug
		'sbo_render_admin_page',         // Callback for the "General" view
		'dashicons-admin-site-alt3',     // Icon
		3                                // Position - directly below Dashboard
	);
	// 2. Add Submenu Items (Optional: break your schema into these)
	add_submenu_page(
		'sitebuilderone',                // Parent Slug
		'General Settings',              // Page Title
		'General Settings',              // Submenu Title
		'manage_options',
		'sitebuilderone',                // Same slug as parent for the first item
		'sbo_render_admin_page'
	);
	add_submenu_page(
		'sitebuilderone',
		'Business Info',
		'Business Info',
		'manage_options',
		'sbo-business-info',             // Unique slug for sub-section
		'sbo_render_admin_page'          // You can use the same renderer!
	);
	add_submenu_page(
		'sitebuilderone',				// Marketing
		'Marketing',
		'Marketing',
		'manage_options',
		'sbo-marketing-info',             // Unique slug for sub-section
		'sbo_render_admin_page'          // You can use the same renderer!
	);

		add_submenu_page(
		'sitebuilderone',
		'Design',
		'Design',
		'manage_options',
		'sbo-settings-design',
		'sbo_render_admin_page'
	);


	add_submenu_page(
		'sitebuilderone',
		'Pages',
		'Pages',
		'manage_options',
		'sbo-website',             // Unique slug for sub-section
		'sbo_render_admin_page'          // You can use the same renderer!
	);
	add_submenu_page(
		'sitebuilderone',
		'Social Media',
		'Social Media',
		'manage_options',
		'sbo-social',
		'sbo_render_admin_page'
	);
	add_submenu_page(
		'sitebuilderone',
		'Set up guide',
		'Set up guide',
		'manage_options',
		'sbo-setup-guide',
		'sbo_render_setup_guide'
	);
});
// ---------------------------------------------------------------------------
// 5. Admin Bar & Notices
// ---------------------------------------------------------------------------
add_action('admin_bar_menu', function (WP_Admin_Bar $bar) {
	if (! current_user_can('manage_options')) return;
	$bar->add_node([
		'id'    => 'sbo-settings',
		'title' => 'SiteBuilderOne',
		'href'  => admin_url('admin.php?page=sitebuilderone') // Changed from options-general.php
	]);
	//	$bar->add_node(['id' => 'sbo-settings', 'title' => 'SiteBuilderOne', 'href' => admin_url('options-general.php?page=wp-sitebuilderone-lite')]);
	$bar->add_node(['id' => 'sbo-edit-header', 'parent' => 'sbo-settings', 'title' => 'Edit Header', 'href' => home_url('/?lc_partial=header&lc_action_launch_editing=1')]);
	$bar->add_node(['id' => 'sbo-edit-footer', 'parent' => 'sbo-settings', 'title' => 'Edit Footer', 'href' => home_url('/?lc_partial=footer&lc_action_launch_editing=1')]);
}, 100);
// ---------------------------------------------------------------------------
// 6. Save Handler (Fixes the TypeError)
// ---------------------------------------------------------------------------
add_action('admin_post_sbo_save_settings', function () {
	if (! current_user_can('manage_options')) wp_die('Unauthorized');
	check_admin_referer('sbo_save_settings', 'sbo_nonce');
	$schema = sbo_get_field_schema();
	$data   = get_option(SBO_OPTION_KEY, []); // preserve fields from other sub-pages
	$posted = $_POST['sbo_fields'] ?? [];
	foreach ($schema as $section) {
		$fields = $section['fields'] ?? [];
		foreach ($fields as $key => $meta) {
			if (! array_key_exists($key, $posted)) continue; // not on this form — leave untouched
			$raw_value = wp_unslash($posted[$key]);
			if (! empty($meta['raw'])) {
				$data[$key] = wp_kses_post($raw_value);
			} else {
				$data[$key] = match ($meta['type']) {
					'url'      => esc_url_raw($raw_value),
					'email'    => sanitize_email($raw_value),
					'textarea' => sanitize_textarea_field($raw_value),
					'checkbox' => $raw_value ? '1' : '0',
					default    => sanitize_text_field($raw_value),
				};
			}
		}
	}
	update_option(SBO_OPTION_KEY, $data);
	$referer = isset($_POST['_wp_http_referer'])
		? wp_unslash($_POST['_wp_http_referer'])
		: admin_url('admin.php?page=sitebuilderone');
	wp_safe_redirect(add_query_arg(['updated' => '1'], $referer));
	exit;
});
// ---------------------------------------------------------------------------
// 7. Admin Page Renderer
// ---------------------------------------------------------------------------
function sbo_render_admin_page()
{
	$schema  = sbo_get_field_schema();
	$options = get_option(SBO_OPTION_KEY, []);
	// Determine which sub-section to show based on the URL 'page' parameter
	$current_page = $_GET['page'] ?? 'sitebuilderone';
	if ($current_page === 'sbo-business-info') {
		$schema = array_intersect_key($schema, [
			'Business Information (NAP)' => '', // Added (NAP) to match schema
			'Physical Address'           => '',
			
		]);
	} elseif ($current_page === 'sbo-social') {
		$schema = array_intersect_key($schema, [
			'Social Media' => ''
		]);
	} elseif ($current_page === 'sbo-website') {
	$schema = array_intersect_key($schema, [
		'Key Web Pages'              => ''  // Added this so your page selectors show up
	]);
	} elseif ($current_page === 'sbo-marketing-info') {
		$schema = array_intersect_key($schema, [
			'Hero Marketing' => '', // Changed from 'Marketing' to match schema
		]);
} elseif ($current_page === 'sbo-settings-design') {
		$schema = array_intersect_key($schema, [
			'Header' => '', // Changed from 'Marketing' to match schema
			'Global Footer' => '', // Changed from 'Marketing' to match schema
			'Sticky Footer' => '', // Changed from 'Marketing' to match schema
		]);		
	} else {
		$schema = array_intersect_key($schema, [
			'Branding'       => '',
			
			'Integrations'   => ''
		]);
	}
	//$schema  = sbo_get_field_schema();
	//$options = get_option(SBO_OPTION_KEY, []);
?>
	<div class="wrap sbo-wrap">
		<h1>SiteBuilderOne Settings</h1>
		<?php if (isset($_GET['updated'])) : ?>
			<div class="notice notice-success is-dismissible">
				<p>Settings saved.</p>
			</div>
		<?php endif; ?>
		<form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
			<input type="hidden" name="action" value="sbo_save_settings">
			<?php wp_nonce_field('sbo_save_settings', 'sbo_nonce'); ?>
			<?php foreach ($schema as $title => $data) : ?>
				<h2 class="sbo-section-heading"><?php echo esc_html($title); ?></h2>
				<?php if (isset($data['description'])) : ?>
					<p class="description" style="margin-bottom:1.5em; font-size:15px; color:#666; font-style:italic;">
						<?php echo esc_html($data['description']); ?>
					</p>
				<?php endif; ?>
				<table class="form-table sbo-fields-table">
					<tbody>
						<?php
						$fields = $data['fields'] ?? [];
						foreach ($fields as $key => $meta) :
							$val     = $options[$key] ?? '';
							$type    = $meta['type'];
							$is_raw  = ! empty($meta['raw']);
							$html_id = 'sbo-field-' . sanitize_html_class($key);
						?>
							<tr>
								<th scope="row">
									<label for="<?php echo esc_attr($html_id); ?>">
										<?php echo esc_html($meta['label']); ?>
									</label>
								</th>
								<td>
									<?php if ('textarea' === $type) : ?>
										<textarea id="<?php echo $html_id; ?>" name="sbo_fields[<?php echo $key; ?>]" rows="4" class="large-text <?php echo $is_raw ? 'code' : ''; ?>"><?php echo esc_textarea($val); ?></textarea>
										<?php if ($is_raw) : ?>
											<p class="description">HTML accepted. Scripts are stripped for security.</p>
										<?php endif; ?>
									<?php elseif ('checkbox' === $type) : ?>
										<input type="checkbox" id="<?php echo $html_id; ?>" name="sbo_fields[<?php echo $key; ?>]" value="1" <?php checked($val, 1); ?>>
									<?php elseif ('page' === $type) :
										$pages = get_pages(['sort_column' => 'menu_order', 'sort_order' => 'asc']); ?>
										<select id="<?php echo $html_id; ?>" name="sbo_fields[<?php echo $key; ?>]" class="regular-text">
											<option value="">— Select a page —</option>
											<?php foreach ($pages as $page) :
												$page_url = get_permalink($page->ID); ?>
												<option value="<?php echo esc_attr($page_url); ?>" <?php selected($val, $page_url); ?>>
													<?php echo esc_html($page->post_title); ?>
												</option>
											<?php endforeach; ?>
										</select>
										<?php if ($val) : ?>
											<a href="<?php echo esc_url($val); ?>" target="_blank" class="button button-small" style="margin-left:5px;">Visit ↗</a>
										<?php endif; ?>
									<?php elseif ('media' === $type) : ?>
										<div style="display:flex; align-items:center; gap:8px;">
											<input type="text" id="<?php echo $html_id; ?>" name="sbo_fields[<?php echo $key; ?>]" value="<?php echo esc_attr($val); ?>" class="regular-text sbo-media-url">
											<button type="button" class="button sbo-media-picker" data-target="<?php echo $html_id; ?>">Choose Image</button>
										</div>
										<?php if ($val) : ?>
											<p><img src="<?php echo esc_url($val); ?>" style="max-width:200px; max-height:80px; margin-top:8px; border:1px solid #ccd0d4; border-radius:4px;"></p>
										<?php endif; ?>
									<?php else : ?>
										<input type="<?php echo esc_attr($type); ?>" id="<?php echo $html_id; ?>" name="sbo_fields[<?php echo $key; ?>]" value="<?php echo esc_attr($val); ?>" class="regular-text">
									<?php endif; ?>
									<?php if ($val !== '') : ?>
										<p class="description sbo-shortcode-ref" style="margin-top:8px;">
											<strong>Shortcode:</strong>
											<tangible class="live-reload">[sbo_field name="<?php echo esc_attr($key); ?>"<?php echo $is_raw ? ' raw="true"' : ''; ?>]</tangible>
											<button type="button" class="button button-small sbo-copy-shortcode" data-shortcode='<tangible class="live-reload">[sbo_field name="<?php echo esc_attr($key); ?>"<?php echo $is_raw ? ' raw="true"' : ''; ?>]</tangible>'>Copy</button>
										</p>
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endforeach; ?>
			<?php submit_button('Save All SiteBuilderOne Settings'); ?>
		</form>
	</div>
<?php
}
// sbo_render_setup_guide() lives in includes/setup-guide.php

add_action('admin_enqueue_scripts', function (string $hook) {
	// Update this check to look for your new menu slugs
	if (strpos($hook, 'sitebuilderone') === false && strpos($hook, 'sbo-') === false) return;
	wp_enqueue_media();
	wp_enqueue_style('sbo-admin', SBO_URL . 'assets/css/admin.css', [], SBO_VERSION);
	wp_enqueue_script('sbo-admin', SBO_URL . 'assets/js/admin.js', ['jquery'], SBO_VERSION, true);
});
