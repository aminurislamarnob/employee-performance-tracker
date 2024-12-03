<?php
namespace WeLabs\EmployeePerformanceTracker;

class PerformanceLogCPT {
	/**
	 * Constructor to initialize hooks
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_cpt' ) );
		add_filter( 'use_block_editor_for_post_type', array( $this, 'disable_gutenberg_for_cpt' ), 10, 2 );
	}

	/**
	 * Register the custom post type
	 */
	public function register_cpt() {
		$labels = array(
			'name'               => _x( 'Performance Logs', 'Post type general name', 'employee-performance-tracker' ),
			'singular_name'      => _x( 'Performance Log', 'Post type singular name', 'employee-performance-tracker' ),
			'menu_name'          => _x( 'Performance Logs', 'Admin Menu text', 'employee-performance-tracker' ),
			'name_admin_bar'     => _x( 'Performance Log', 'Add New on Toolbar', 'employee-performance-tracker' ),
			'add_new'            => __( 'Add New', 'employee-performance-tracker' ),
			'add_new_item'       => __( 'Add Performance Log', 'employee-performance-tracker' ),
			'new_item'           => __( 'New Performance Log', 'employee-performance-tracker' ),
			'edit_item'          => __( 'Edit Performance Log', 'employee-performance-tracker' ),
			'view_item'          => __( 'View Performance Log', 'employee-performance-tracker' ),
			'all_items'          => __( 'Performance Logs', 'employee-performance-tracker' ),
			'search_items'       => __( 'Search Performance Logs', 'employee-performance-tracker' ),
			'parent_item_colon'  => __( 'Parent Performance Logs:', 'employee-performance-tracker' ),
			'not_found'          => __( 'No Performance Logs found.', 'employee-performance-tracker' ),
			'not_found_in_trash' => __( 'No Performance Logs found in Trash.', 'employee-performance-tracker' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => 'performance-tracker',
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'ept-performance-log' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'          => 'dashicons-portfolio',
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
			'show_in_rest'       => true, // Enables Gutenberg support
		);

		register_post_type( 'ept-performance-log', $args );
	}

	/**
	 * Disable Gutenberg for the custom post type
	 */
	public function disable_gutenberg_for_cpt( $use_block_editor, $post_type ) {
		if ( 'ept-performance-log' === $post_type ) {
			return false;
		}

		return $use_block_editor;
	}
}
