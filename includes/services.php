<?php
if ( ! defined( 'ABSPATH' ) ) exit;

require_once SBO_DIR . 'includes/services/class-cpt.php';
require_once SBO_DIR . 'includes/services/class-taxonomy.php';
require_once SBO_DIR . 'includes/services/class-admin-columns.php';
require_once SBO_DIR . 'includes/services/class-meta-boxes.php';
require_once SBO_DIR . 'includes/services/class-rest-fields.php';
require_once SBO_DIR . 'includes/services/class-shortcode.php';
require_once SBO_DIR . 'includes/services/class-schema.php';

add_action( 'init', [ 'SBO_Services_CPT', 'register' ] );
add_action( 'init', [ 'SBO_Services_Taxonomy', 'register' ] );
add_action( 'init', [ 'SBO_Services_Rest_Fields', 'register' ] );
add_filter( 'manage_service_posts_columns', [ 'SBO_Services_Admin_Columns', 'add_columns' ] );
add_action( 'manage_service_posts_custom_column', [ 'SBO_Services_Admin_Columns', 'render_column' ], 10, 2 );
add_filter( 'manage_edit-service_sortable_columns', [ 'SBO_Services_Admin_Columns', 'sortable_columns' ] );
add_action( 'add_meta_boxes', [ 'SBO_Services_Meta_Boxes', 'add' ] );
add_action( 'save_post_service', [ 'SBO_Services_Meta_Boxes', 'save' ] );
add_action( 'admin_enqueue_scripts', [ 'SBO_Services_Meta_Boxes', 'enqueue_styles' ] );
add_action( 'admin_enqueue_scripts', [ 'SBO_Services_Admin_Columns', 'enqueue_styles' ] );
add_action( 'init', [ 'SBO_Services_Shortcode', 'register' ] );
add_action( 'init', [ 'SBO_Services_Schema', 'register' ] );

add_action( 'init', 'sbo_services_maybe_flush_rewrites', 20 );
function sbo_services_maybe_flush_rewrites() {
	if ( get_option( 'sbo_services_rewrite_version' ) === SBO_VERSION ) {
		return;
	}

	flush_rewrite_rules();
	update_option( 'sbo_services_rewrite_version', SBO_VERSION, false );
}
