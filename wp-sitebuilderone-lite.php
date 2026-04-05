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
