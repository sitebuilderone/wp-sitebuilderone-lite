<?php
if ( ! defined( 'ABSPATH' ) ) exit;

require_once SBO_DIR . 'includes/faq/class-admin-settings.php';
require_once SBO_DIR . 'includes/faq/class-cpt.php';
require_once SBO_DIR . 'includes/faq/class-howto-cpt.php';
require_once SBO_DIR . 'includes/faq/class-meta-boxes.php';
require_once SBO_DIR . 'includes/faq/class-howto-meta-boxes.php';
require_once SBO_DIR . 'includes/faq/class-rest-fields.php';
require_once SBO_DIR . 'includes/faq/class-howto-rest-fields.php';
require_once SBO_DIR . 'includes/faq/class-shortcode.php';
require_once SBO_DIR . 'includes/faq/class-howto-shortcode.php';
require_once SBO_DIR . 'includes/faq/class-schema.php';
require_once SBO_DIR . 'includes/faq/class-howto-schema.php';

add_action( 'admin_init', [ 'SBO_FAQ_Admin_Settings', 'register' ] );
add_action( 'admin_menu', [ 'SBO_FAQ_Admin_Settings', 'add_menu' ], 99 );
add_action( 'init', [ 'SBO_FAQ_CPT', 'register' ] );
add_action( 'init', [ 'SBO_FAQ_HowTo_CPT', 'register' ] );
add_action( 'init', [ 'SBO_FAQ_Rest_Fields', 'register' ] );
add_action( 'init', [ 'SBO_FAQ_HowTo_Rest_Fields', 'register' ] );
add_action( 'init', [ 'SBO_FAQ_Shortcode', 'register' ] );
add_action( 'init', [ 'SBO_FAQ_HowTo_Shortcode', 'register' ] );
add_action( 'init', [ 'SBO_FAQ_Schema', 'register' ] );
add_action( 'init', [ 'SBO_FAQ_HowTo_Schema', 'register' ] );
add_action( 'add_meta_boxes', [ 'SBO_FAQ_Meta_Boxes', 'add' ] );
add_action( 'add_meta_boxes', [ 'SBO_FAQ_HowTo_Meta_Boxes', 'add' ] );
add_action( 'save_post_faq', [ 'SBO_FAQ_Meta_Boxes', 'save' ] );
add_action( 'save_post_howto', [ 'SBO_FAQ_HowTo_Meta_Boxes', 'save' ] );
add_action( 'admin_enqueue_scripts', [ 'SBO_FAQ_Meta_Boxes', 'enqueue_styles' ] );
add_action( 'admin_enqueue_scripts', [ 'SBO_FAQ_HowTo_Meta_Boxes', 'enqueue_styles' ] );

add_action( 'init', 'sbo_faq_maybe_flush_rewrites', 20 );
function sbo_faq_maybe_flush_rewrites() {
	if ( get_option( 'sbo_faq_rewrite_version' ) === SBO_VERSION ) {
		return;
	}

	flush_rewrite_rules();
	update_option( 'sbo_faq_rewrite_version', SBO_VERSION, false );
}
