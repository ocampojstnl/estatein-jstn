<?php
/**
 * Custom post types powering the Slider Section block (properties, testimonials, FAQs).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function estatein_register_post_types() {
	register_post_type( 'property', array(
		'labels' => array(
			'name'               => __( 'Properties', 'estatein' ),
			'singular_name'      => __( 'Property', 'estatein' ),
			'add_new_item'       => __( 'Add New Property', 'estatein' ),
			'edit_item'          => __( 'Edit Property', 'estatein' ),
			'new_item'           => __( 'New Property', 'estatein' ),
			'view_item'          => __( 'View Property', 'estatein' ),
			'search_items'       => __( 'Search Properties', 'estatein' ),
			'not_found'          => __( 'No properties found', 'estatein' ),
			'all_items'          => __( 'Properties', 'estatein' ),
		),
		'public'       => true,
		'has_archive'  => true,
		'rewrite'      => array( 'slug' => 'properties' ),
		'menu_icon'    => 'dashicons-admin-home',
		'supports'     => array( 'title', 'thumbnail' ),
		'show_in_rest' => true,
	) );

	register_post_type( 'testimonial', array(
		'labels' => array(
			'name'               => __( 'Testimonials', 'estatein' ),
			'singular_name'      => __( 'Testimonial', 'estatein' ),
			'add_new_item'       => __( 'Add New Testimonial', 'estatein' ),
			'edit_item'          => __( 'Edit Testimonial', 'estatein' ),
			'new_item'           => __( 'New Testimonial', 'estatein' ),
			'view_item'          => __( 'View Testimonial', 'estatein' ),
			'search_items'       => __( 'Search Testimonials', 'estatein' ),
			'not_found'          => __( 'No testimonials found', 'estatein' ),
			'all_items'          => __( 'Testimonials', 'estatein' ),
		),
		'public'       => true,
		'has_archive'  => true,
		'rewrite'      => array( 'slug' => 'testimonials' ),
		'menu_icon'    => 'dashicons-format-quote',
		'supports'     => array( 'title' ),
		'show_in_rest' => true,
	) );

	register_post_type( 'faq', array(
		'labels' => array(
			'name'               => __( 'FAQs', 'estatein' ),
			'singular_name'      => __( 'FAQ', 'estatein' ),
			'add_new_item'       => __( 'Add New FAQ', 'estatein' ),
			'edit_item'          => __( 'Edit FAQ', 'estatein' ),
			'new_item'           => __( 'New FAQ', 'estatein' ),
			'view_item'          => __( 'View FAQ', 'estatein' ),
			'search_items'       => __( 'Search FAQs', 'estatein' ),
			'not_found'          => __( 'No FAQs found', 'estatein' ),
			'all_items'          => __( 'FAQs', 'estatein' ),
		),
		'public'       => true,
		'has_archive'  => true,
		'rewrite'      => array( 'slug' => 'faqs' ),
		'menu_icon'    => 'dashicons-editor-help',
		'supports'     => array( 'title' ),
		'show_in_rest' => true,
	) );
}
add_action( 'init', 'estatein_register_post_types' );
