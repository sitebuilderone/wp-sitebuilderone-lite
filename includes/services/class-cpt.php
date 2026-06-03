<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class SBO_Services_CPT {

	public static function register() {
		$labels = [
			'name'               => __( 'Services', 'wp-sitebuilderone-lite' ),
			'singular_name'      => __( 'Service', 'wp-sitebuilderone-lite' ),
			'add_new'            => __( 'Add New', 'wp-sitebuilderone-lite' ),
			'add_new_item'       => __( 'Add New Service', 'wp-sitebuilderone-lite' ),
			'edit_item'          => __( 'Edit Service', 'wp-sitebuilderone-lite' ),
			'new_item'           => __( 'New Service', 'wp-sitebuilderone-lite' ),
			'view_item'          => __( 'View Service', 'wp-sitebuilderone-lite' ),
			'search_items'       => __( 'Search Services', 'wp-sitebuilderone-lite' ),
			'parent_item_colon'  => __( 'Parent Service:', 'wp-sitebuilderone-lite' ),
			'not_found'          => __( 'No services found', 'wp-sitebuilderone-lite' ),
			'not_found_in_trash' => __( 'No services found in trash', 'wp-sitebuilderone-lite' ),
			'menu_name'          => __( 'Services', 'wp-sitebuilderone-lite' ),
		];

		$args = [
			'labels'       => $labels,
			'public'       => true,
			'hierarchical' => true,
			'has_archive'  => false,
			'rewrite'      => [ 'slug' => 'services', 'hierarchical' => true ],
			'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ],
			'menu_icon'    => 'dashicons-hammer',
			'show_in_menu' => true,
			'menu_position'=> 4,
			'show_in_rest' => true,
			'rest_base'    => 'services',
		];

		register_post_type( 'service', $args );
	}
}
