<?php
/**
 * Plugin Name:  WP SiteBuilderOne Lite
 * Plugin URI:   https://github.com/sitebuilderone/wp-sitebuilderone-lite
 * Description:  Stores local business data in wp_options. No dependencies required. Additional custom post types included for services and FAQs. Designed for maximum compatibility with page builders and themes. Ideal for agencies building sites for local businesses.
 * Version:      1.0.8
 * Author:       SiteBuilderOne
 * Author URI:   https://www.sitebuilderone.com
 * License:      GPL-2.0-or-later
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:  wp-sitebuilderone-lite
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'SBO_VERSION',    '1.0.8' );
define( 'SBO_DIR',        plugin_dir_path( __FILE__ ) );
define( 'SBO_URL',        plugin_dir_url( __FILE__ ) );
define( 'SBO_OPTION_KEY', 'sbo_options' );
define( 'SBO_CLIENT_BRIEF_OPTION_KEY', 'sbo_client_brief' );

function sbo_activate() {
	require_once SBO_DIR . 'includes/services/class-cpt.php';
	require_once SBO_DIR . 'includes/services/class-taxonomy.php';
	require_once SBO_DIR . 'includes/faq/class-admin-settings.php';
	require_once SBO_DIR . 'includes/faq/class-cpt.php';
	require_once SBO_DIR . 'includes/faq/class-howto-cpt.php';

	SBO_Services_CPT::register();
	SBO_Services_Taxonomy::register();
	SBO_FAQ_CPT::register();
	SBO_FAQ_HowTo_CPT::register();
	flush_rewrite_rules();
	update_option( 'sbo_services_rewrite_version', SBO_VERSION, false );
	update_option( 'sbo_faq_rewrite_version', SBO_VERSION, false );
}
register_activation_hook( __FILE__, 'sbo_activate' );

add_action( 'plugins_loaded', function () {
	require_once SBO_DIR . 'includes/admin.php';
	require_once SBO_DIR . 'includes/client-brief.php';
	require_once SBO_DIR . 'includes/shortcodes.php';
	require_once SBO_DIR . 'includes/csv.php';
    require_once SBO_DIR . 'includes/social-shortcodes.php';
    require_once SBO_DIR . 'includes/plugins.php';
    require_once SBO_DIR . 'includes/pages.php';
    require_once SBO_DIR . 'includes/schema-org.php';
    require_once SBO_DIR . 'includes/services.php';
    require_once SBO_DIR . 'includes/faq.php';
    require_once SBO_DIR . 'includes/setup-guide.php';
} 
);

// DEFINE THE HELPER ONLY ONCE HERE
function sbo_get( $key, $default = '' ) {
    $options = get_option( SBO_OPTION_KEY, [] );
    return isset( $options[$key] ) && $options[$key] !== '' ? $options[$key] : $default;
}

// Disable Gutenberg globally — force Classic Editor for all post types.
add_filter( 'use_block_editor_for_post', '__return_false', 10 );
add_filter( 'use_block_editor_for_post_type', '__return_false', 10 );

function move_admin_bar_to_bottom() {
    echo '
    <style type="text/css">
        html { margin-top: 0 !important; margin-bottom: 32px !important; }
        #wpadminbar { top: auto !important; bottom: 0; position: fixed; }
        #wpadminbar .menupop .ab-sub-wrapper { bottom: 32px; }
        @media screen and (max-width: 782px) {
            html { margin-bottom: 46px !important; }
            #wpadminbar .menupop .ab-sub-wrapper { bottom: 46px; }
        }
    </style>';
}
add_action('wp_head', 'move_admin_bar_to_bottom');
add_action('admin_head', 'move_admin_bar_to_bottom');


add_action('init', 'sbo_enable_tags_for_pages');
function sbo_enable_tags_for_pages() {
    register_taxonomy_for_object_type('post_tag', 'page');
    register_taxonomy_for_object_type('post_tag', 'faq');
    register_taxonomy_for_object_type('post_tag', 'howto');
}

// Optional: Ensure tags are included in search results for pages
add_action('pre_get_posts', function($query) {
    if ($query->is_tag() && $query->is_main_query()) {
        $query->set('post_type', ['post', 'page', 'faq', 'howto']);
    }
});
