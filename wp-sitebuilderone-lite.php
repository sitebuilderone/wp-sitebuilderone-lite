<?php
/**
 * Plugin Name:  WP SiteBuilderOne Lite
 * Plugin URI:   https://github.com/sitebuilderone/wp-sitebuilderone-lite
 * Description:  Stores local business data in wp_options. No dependencies required.
 * Version:      1.0.1
 * Author:       SiteBuilderOne
 * Author URI:   https://www.sitebuilderone.com
 * License:      GPL-2.0-or-later
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:  wp-sitebuilderone-lite
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'SBO_VERSION',    '1.0.0' );
define( 'SBO_DIR',        plugin_dir_path( __FILE__ ) );
define( 'SBO_URL',        plugin_dir_url( __FILE__ ) );
define( 'SBO_OPTION_KEY', 'sbo_options' );

add_action( 'plugins_loaded', function () {
	require_once SBO_DIR . 'includes/admin.php';
	require_once SBO_DIR . 'includes/shortcodes.php';
	require_once SBO_DIR . 'includes/csv.php';
} );

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

