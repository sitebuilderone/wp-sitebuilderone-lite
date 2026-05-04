<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class SBO_Services_Taxonomy {

	public static function register() {
		$labels = [
			'name'              => __( 'Service Tags', 'wp-sitebuilderone-lite' ),
			'singular_name'     => __( 'Service Tag', 'wp-sitebuilderone-lite' ),
			'search_items'      => __( 'Search Service Tags', 'wp-sitebuilderone-lite' ),
			'all_items'         => __( 'All Service Tags', 'wp-sitebuilderone-lite' ),
			'edit_item'         => __( 'Edit Service Tag', 'wp-sitebuilderone-lite' ),
			'update_item'       => __( 'Update Service Tag', 'wp-sitebuilderone-lite' ),
			'add_new_item'      => __( 'Add New Service Tag', 'wp-sitebuilderone-lite' ),
			'new_item_name'     => __( 'New Service Tag Name', 'wp-sitebuilderone-lite' ),
			'menu_name'         => __( 'Service Tags', 'wp-sitebuilderone-lite' ),
		];

		$args = [
			'labels'       => $labels,
			'hierarchical' => false,
			'public'       => true,
			'rewrite'      => [ 'slug' => 'service-tag' ],
			'show_in_rest' => true,
		];

		register_taxonomy( 'service_tag', 'service', $args );
	}
}
