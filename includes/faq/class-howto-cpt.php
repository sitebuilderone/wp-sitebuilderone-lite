<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class SBO_FAQ_HowTo_CPT {

	public static function register() {
		$labels = [
			'name'               => __( 'HowTos', 'wp-sitebuilderone-lite' ),
			'singular_name'      => __( 'HowTo', 'wp-sitebuilderone-lite' ),
			'add_new'            => __( 'Add New', 'wp-sitebuilderone-lite' ),
			'add_new_item'       => __( 'Add New HowTo', 'wp-sitebuilderone-lite' ),
			'edit_item'          => __( 'Edit HowTo', 'wp-sitebuilderone-lite' ),
			'new_item'           => __( 'New HowTo', 'wp-sitebuilderone-lite' ),
			'view_item'          => __( 'View HowTo', 'wp-sitebuilderone-lite' ),
			'search_items'       => __( 'Search HowTos', 'wp-sitebuilderone-lite' ),
			'not_found'          => __( 'No HowTos found', 'wp-sitebuilderone-lite' ),
			'not_found_in_trash' => __( 'No HowTos found in trash', 'wp-sitebuilderone-lite' ),
			'menu_name'          => __( 'HowTos', 'wp-sitebuilderone-lite' ),
		];

		$args = [
			'labels'       => $labels,
			'public'       => true,
			'has_archive'  => false,
			'rewrite'      => [ 'slug' => SBO_FAQ_Admin_Settings::get_howto_slug() ],
			'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ],
			'taxonomies'   => [ 'post_tag' ],
			'menu_icon'    => 'dashicons-list-view',
			'show_in_menu' => true,
			'menu_position'=> 4,
			'show_in_rest' => true,
			'rest_base'    => 'howtos',
		];

		register_post_type( 'howto', $args );
	}
}
