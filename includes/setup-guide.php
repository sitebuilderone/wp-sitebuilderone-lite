<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// ---------------------------------------------------------------------------
// Set Up Guide Page Renderer
// ---------------------------------------------------------------------------

/**
 * Returns an HTML status block showing which fields in $fields are empty.
 * $fields = [ 'option_key' => 'Label', ... ]
 * $page_slug = the admin sub-page to link to for fixing them.
 */
function sbo_guide_field_status( array $fields, string $page_slug ): string {
	$opts    = get_option( SBO_OPTION_KEY, [] );
	$missing = [];
	$filled  = 0;
	foreach ( $fields as $key => $label ) {
		if ( isset( $opts[ $key ] ) && $opts[ $key ] !== '' ) {
			$filled++;
		} else {
			$missing[] = esc_html( $label );
		}
	}
	$total = count( $fields );
	$url   = esc_url( admin_url( 'admin.php?page=' . $page_slug ) );

	if ( empty( $missing ) ) {
		return '<p class="sbo-status sbo-status-ok">&#10003; All ' . $total . ' field' . ( $total !== 1 ? 's' : '' ) . ' complete.</p>';
	}

	$items = '<ul class="sbo-missing-list"><li>' . implode( '</li><li>', $missing ) . '</li></ul>';
	return '<div class="sbo-status sbo-status-warn">'
		. '<strong>&#9888; ' . count( $missing ) . ' of ' . $total . ' field' . ( $total !== 1 ? 's' : '' ) . ' still empty:</strong>'
		. $items
		. '<a href="' . $url . '" class="button button-small" style="margin-top:.4em;">Fill in now ↗</a>'
		. '</div>';
}

function sbo_render_setup_guide() {
	// Fetch saved options once for the status helper.
	// (helper calls get_option internally, but WP caches it — no extra DB hit)
?>
<div class="wrap sbo-wrap">
	<h1>SiteBuilderOne — Set Up Guide</h1>
	<p style="color:#666;font-size:15px;margin-bottom:2em;">Follow these steps to get your new site build configured from scratch.</p>

	<style>
		.sbo-guide { max-width: 860px; }
		.sbo-guide h2 { font-size: 1.3em; margin-top: 2em; padding-bottom: .3em; border-bottom: 2px solid #2271b1; color: #2271b1; }
		.sbo-guide h3 { font-size: 1.05em; margin-top: 1.4em; color: #1d2327; }
		.sbo-guide p, .sbo-guide li { font-size: 14px; line-height: 1.7; color: #3c434a; }
		.sbo-guide ul, .sbo-guide ol { margin-left: 1.5em; }
		.sbo-guide code { background: #f0f0f1; padding: 2px 6px; border-radius: 3px; font-size: 13px; }
		.sbo-guide .sbo-step { background: #fff; border: 1px solid #c3c4c7; border-radius: 6px; padding: 1.2em 1.5em; margin-bottom: 1.2em; }
		.sbo-guide .sbo-step-num { display: inline-block; background: #2271b1; color: #fff; border-radius: 50%; width: 28px; height: 28px; line-height: 28px; text-align: center; font-weight: 700; font-size: 13px; margin-right: 8px; }
		.sbo-guide .sbo-tip { background: #f0f6fc; border-left: 4px solid #2271b1; padding: .7em 1em; margin: 1em 0; border-radius: 0 4px 4px 0; }
		.sbo-guide .sbo-warning { background: #fcf9e8; border-left: 4px solid #dba617; padding: .7em 1em; margin: 1em 0; border-radius: 0 4px 4px 0; }
		.sbo-guide a { color: #2271b1; }
		.sbo-guide .sbo-shortcode-tag { background: #edf7ed; color: #1a6b2a; padding: 2px 7px; border-radius: 3px; font-family: monospace; font-size: 13px; }
		.sbo-guide table.sbo-ref { border-collapse: collapse; width: 100%; margin-top: .5em; }
		.sbo-guide table.sbo-ref th, .sbo-guide table.sbo-ref td { border: 1px solid #c3c4c7; padding: .5em .8em; font-size: 13px; text-align: left; }
		.sbo-guide table.sbo-ref th { background: #f6f7f7; font-weight: 600; }
		.sbo-guide .sbo-status { margin-top: 1em; padding: .6em 1em; border-radius: 4px; font-size: 13px; }
		.sbo-guide .sbo-status-ok { background: #edfaef; border-left: 4px solid #1a9e37; color: #155724; font-weight: 600; }
		.sbo-guide .sbo-status-warn { background: #fff8e5; border-left: 4px solid #dba617; color: #5a4000; }
		.sbo-guide .sbo-missing-list { margin: .3em 0 .5em 1.2em; }
		.sbo-guide .sbo-missing-list li { color: #5a4000; font-size: 13px; }
	</style>

	<div class="sbo-guide">

		<!-- ── STEP 1 ────────────────────────────────────────────── -->
		<h2>Step 1 — Activate &amp; confirm the plugin is running</h2>
		<div class="sbo-step">
			<p><span class="sbo-step-num">1</span> Go to <strong>Plugins → Installed Plugins</strong> and confirm <em>WP SiteBuilderOne Lite</em> is <strong>Active</strong>.</p>
			<p><span class="sbo-step-num">2</span> You should see the <strong>SiteBuilderOne</strong> menu item in the left sidebar — you're already here!</p>
			<p><span class="sbo-step-num">3</span> No build step is required. There is no <code>npm install</code> or <code>composer install</code> — just activate and go.</p>
		</div>

		<!-- ── STEP 2 ────────────────────────────────────────────── -->
		<h2>Step 2 — Fill in Branding</h2>
		<div class="sbo-step">
			<p>Go to <a href="<?php echo esc_url( admin_url('admin.php?page=sitebuilderone') ); ?>">General Settings</a> and complete the <strong>Branding</strong> section:</p>
			<ul>
				<li><strong>Website Name</strong> — used in titles and meta tags.</li>
				<li><strong>Home URL</strong> — the full URL of your homepage (e.g. <code>https://example.com</code>).</li>
				<li><strong>Business Logo URL</strong> — upload via the <em>Choose Image</em> button.</li>
				<li><strong>Business Description</strong> — a short paragraph about the business (used in footers and schema).</li>
				<li><strong>Business Keywords</strong> — comma-separated, used for meta keywords.</li>
				<li><strong>Banner Image URL</strong> — a wide hero/banner image for the homepage.</li>
			</ul>
			<p>Click <strong>Save All SiteBuilderOne Settings</strong> when done.</p>
			<?php echo sbo_guide_field_status( [
				'website_name'             => 'Website Name',
				'one_home_url'             => 'Home URL',
				'one_business_logo'        => 'Business Logo URL',
				'one_business_description' => 'Business Description',
				'one_business_keywords'    => 'Business Keywords',
				'one_banner_image'         => 'Banner Image URL',
			], 'sitebuilderone' ); ?>
		</div>

		<!-- ── STEP 3 ────────────────────────────────────────────── -->
		<h2>Step 3 — Enter Business Information (NAP)</h2>
		<div class="sbo-step">
			<p>Go to <a href="<?php echo esc_url( admin_url('admin.php?page=sbo-business-info') ); ?>">Business Info</a> and fill in:</p>
			<ul>
				<li>Business name, phone, and email address.</li>
				<li>Physical address (street, city, state, ZIP, country).</li>
				<li>Google Maps embed code — paste the full <code>&lt;iframe&gt;</code> from Google Maps.</li>
			</ul>
			<div class="sbo-tip">NAP (Name, Address, Phone) consistency is critical for local SEO. Make sure these match exactly what appears on Google Business Profile.</div>
			<?php echo sbo_guide_field_status( [
				'one_business_name'    => 'Business Name',
				'one_business_phone'   => 'Phone (display)',
				'one_phone_web_ready'  => 'Phone (digits only)',
				'one_business_email'   => 'Business Email',
				'one_street_address'   => 'Street Address',
				'one_city'             => 'City',
				'one_state'            => 'State / Province',
				'one_postal_code'      => 'Postal / ZIP Code',
				'one_country'          => 'Country Code',
				'one_google_map_embed' => 'Google Map Embed Code',
			], 'sbo-business-info' ); ?>
		</div>

		<!-- ── STEP 4 ────────────────────────────────────────────── -->
		<h2>Step 4 — Set up Key Web Pages</h2>
		<div class="sbo-step">
			<p>Go to <strong>Pages → All Pages</strong> and create (or verify) the following standard pages exist:</p>
			<ul>
				<li>Home, About, Contact, Blog, Services, Sitemap, Privacy Policy, Terms of Service, Brand Style Guide</li>
			</ul>
			<p>If any are missing, WordPress will show a notice at the top of the Pages screen with a <em>Create now</em> link for each missing page.</p>
			<p>Once the pages exist, go to <a href="<?php echo esc_url( admin_url('admin.php?page=sbo-website') ); ?>">Pages</a> in this menu and assign each page using the dropdowns. These values power <code>[sbo_field name="one_page_contact"]</code> and similar shortcodes.</p>
			<?php echo sbo_guide_field_status( [
				'one_page_about'   => 'About',
				'one_page_blog'    => 'Blog',
				'one_page_contact' => 'Contact',
				'one_page_sitemap' => 'Sitemap',
				'one_page_privacy' => 'Privacy',
				'one_page_terms'   => 'Terms',
			], 'sbo-website' ); ?>
		</div>

		<!-- ── STEP 5 ────────────────────────────────────────────── -->
		<h2>Step 5 — Configure Marketing &amp; Hero copy</h2>
		<div class="sbo-step">
			<p>Go to <a href="<?php echo esc_url( admin_url('admin.php?page=sbo-marketing-info') ); ?>">Marketing</a> and fill in:</p>
			<ul>
				<li><strong>Headline</strong> — primary H1 for the homepage hero.</li>
				<li><strong>Headline Support Copy</strong> — the supporting paragraph beneath the headline.</li>
				<li><strong>Marketing Image URL</strong> — hero image shown alongside the headline.</li>
				<li><strong>CTA Text</strong> — the call-to-action button label (e.g. "Get a Free Quote").</li>
			</ul>
			<?php echo sbo_guide_field_status( [
				'one_headline'         => 'Headline',
				'one_headline_support' => 'Headline Support Copy',
				'one_marketing_image'  => 'Marketing Image URL',
				'one_cta_text'         => 'CTA Text',
			], 'sbo-marketing-info' ); ?>
		</div>

		<!-- ── STEP 6 ────────────────────────────────────────────── -->
		<h2>Step 6 — Add Social Media URLs</h2>
		<div class="sbo-step">
			<p>Go to <a href="<?php echo esc_url( admin_url('admin.php?page=sbo-social') ); ?>">Social Media</a> and paste the full profile URLs for each platform the business uses.</p>
			<p>Only fill in platforms that are actually active. Leave unused platforms blank — their icon shortcodes will silently output nothing.</p>
			<p>Use the social icon shortcodes in your templates:</p>
			<code>[sbo_social_facebook]</code>&nbsp;
			<code>[sbo_social_instagram]</code>&nbsp;
			<code>[sbo_social_linkedin]</code>&nbsp;
			<code>[sbo_social_youtube]</code>
			<p style="margin-top:.7em;">Each shortcode accepts <code>width</code>, <code>height</code>, <code>fill</code>, and <code>class</code> attributes.</p>
			<?php echo sbo_guide_field_status( [
				'social-facebook'        => 'Facebook URL',
				'social-instagram'       => 'Instagram URL',
				'social-linkedin'        => 'LinkedIn URL',
				'social-youtube'         => 'YouTube URL',
				'social-twitter-x'       => 'Twitter / X URL',
				'social-google-business' => 'Google Business URL',
				'social-yelp'            => 'Yelp URL',
				'social-github'          => 'GitHub URL',
			], 'sbo-social' ); ?>
		</div>

		<!-- ── STEP 7 ────────────────────────────────────────────── -->
		<h2>Step 7 — Design: Header, Footer &amp; Sticky Footer</h2>
		<div class="sbo-step">
			<p>Go to <a href="<?php echo esc_url( admin_url('admin.php?page=sbo-settings-design') ); ?>">Design</a> to set:</p>
			<ul>
				<li><strong>Header CTA button text and target page</strong> — the primary action button in the nav.</li>
				<li><strong>Logo dimensions</strong> — width and height in pixels for consistent header rendering.</li>
				<li><strong>Footer description</strong> — the business blurb shown in the footer widget area (HTML allowed).</li>
				<li><strong>Footer column headers</strong> — titles for the two link columns in the footer.</li>
				<li><strong>Sticky mobile footer</strong> — enable and configure a bottom CTA bar for mobile visitors.</li>
			</ul>
			<?php echo sbo_guide_field_status( [
				'one_header_cta_btn_text' => 'Header Button Text',
				'one_header_cta_URL'      => 'Header CTA Page',
				'one_header_logo_h'       => 'Logo Height (px)',
				'one_header_logo_w'       => 'Logo Width (px)',
				'one_footer_desc'         => 'Footer Business Description',
				'one_footer_01_title'     => 'Footer Header 01 Title',
				'one_footer_02_title'     => 'Footer Header 02 Title',
			], 'sbo-settings-design' ); ?>
		</div>

		<!-- ── STEP 8 ────────────────────────────────────────────── -->
		<h2>Step 8 — Use shortcodes in your templates</h2>
		<div class="sbo-step">
			<p>All stored values are available as shortcodes anywhere in pages, posts, or template HTML:</p>
			<table class="sbo-ref">
				<thead><tr><th>Shortcode</th><th>Output</th></tr></thead>
				<tbody>
					<tr><td><code>[sbo_field name="one_business_name"]</code></td><td>Plain text value, HTML-escaped</td></tr>
					<tr><td><code>[sbo_field name="one_google_map_embed" raw="true"]</code></td><td>Raw HTML (e.g. iframes)</td></tr>
					<tr><td><code>[sbo_url name="one_home_url"]</code></td><td>A sanitised URL string</td></tr>
					<tr><td><code>[sbo_link name="one_page_contact"]Link text[/sbo_link]</code></td><td>An anchor tag</td></tr>
					<tr><td><code>[sbo_social_facebook]</code></td><td>Inline SVG icon (if URL is set)</td></tr>
				</tbody>
			</table>
			<p style="margin-top:.8em;">In PHP templates use: <code>echo esc_html( sbo_get( 'one_business_name' ) );</code></p>
			<div class="sbo-tip">After saving any field, the shortcode reference appears directly below the input in the settings screen. Use the <strong>Copy</strong> button to grab it instantly.</div>
		</div>

		<!-- ── STEP 9 ────────────────────────────────────────────── -->
		<h2>Step 9 — Export / Import via CSV</h2>
		<div class="sbo-step">
			<p>SiteBuilderOne stores all values in a single WordPress option (<code>sbo_options</code>). You can transfer or back up data using CSV:</p>
			<ol>
				<li>Go to <a href="<?php echo esc_url( admin_url('admin.php?page=sitebuilderone') ); ?>">General Settings</a> and scroll to the <strong>Import / Export</strong> section.</li>
				<li>Click <strong>Export CSV</strong> to download a snapshot of all current values.</li>
				<li>Edit the CSV if needed, then use <strong>Import CSV</strong> on another site to populate the same fields.</li>
			</ol>
			<div class="sbo-warning">Import <em>merges</em> with existing data — fields absent from the CSV are left untouched. Unknown field keys are silently ignored (they are whitelisted against the schema).</div>
		</div>

		<!-- ── STEP 10 ────────────────────────────────────────────── -->
		<h2>Step 10 — Verify everything is working</h2>
		<div class="sbo-step">
			<ol>
				<li>Visit the front end of the site and confirm the header logo, business name, and phone number appear correctly.</li>
				<li>Check the footer — description, social icons, and column headings should all reflect the saved values.</li>
				<li>Test the hero section on the homepage — headline, support copy, and CTA button.</li>
				<li>Visit a page that uses a map embed and confirm the <code>&lt;iframe&gt;</code> renders correctly.</li>
				<li>On a mobile device, confirm the sticky footer CTA appears (if enabled).</li>
			</ol>
			<div class="sbo-tip">If a shortcode outputs nothing, double-check that the field has been saved — the shortcode reference only appears in settings once the field has a value.</div>
		</div>

		<p style="margin-top:2.5em;padding-top:1em;border-top:1px solid #c3c4c7;color:#666;font-size:13px;">
			Plugin version <?php echo esc_html( SBO_VERSION ); ?> &nbsp;|&nbsp;
			<a href="https://www.sitebuilderone.com" target="_blank" rel="noopener">sitebuilderone.com</a>
		</p>

	</div><!-- .sbo-guide -->
</div><!-- .wrap -->
<?php
}
