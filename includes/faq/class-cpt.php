<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class SBO_FAQ_CPT {

	public static function register() {
		$labels = [
			'name'               => __( 'FAQs', 'wp-sitebuilderone-lite' ),
			'singular_name'      => __( 'FAQ', 'wp-sitebuilderone-lite' ),
			'add_new'            => __( 'Add New', 'wp-sitebuilderone-lite' ),
			'add_new_item'       => __( 'Add New FAQ', 'wp-sitebuilderone-lite' ),
			'edit_item'          => __( 'Edit FAQ', 'wp-sitebuilderone-lite' ),
			'new_item'           => __( 'New FAQ', 'wp-sitebuilderone-lite' ),
			'view_item'          => __( 'View FAQ', 'wp-sitebuilderone-lite' ),
			'search_items'       => __( 'Search FAQs', 'wp-sitebuilderone-lite' ),
			'not_found'          => __( 'No FAQs found', 'wp-sitebuilderone-lite' ),
			'not_found_in_trash' => __( 'No FAQs found in trash', 'wp-sitebuilderone-lite' ),
			'menu_name'          => __( 'FAQs', 'wp-sitebuilderone-lite' ),
		];

		$args = [
			'labels'       => $labels,
			'public'       => true,
			'has_archive'  => false,
			'rewrite'      => [ 'slug' => SBO_FAQ_Admin_Settings::get_faq_slug() ],
			'supports'     => [ 'title', 'editor', 'thumbnail', 'page-attributes' ],
			'taxonomies'   => [ 'post_tag' ],
			'menu_icon'    => 'dashicons-editor-help',
			'show_in_menu' => 'sitebuilderone',
			'show_in_rest' => true,
			'rest_base'    => 'faqs',
		];

		register_post_type( 'faq', $args );
	}
}
