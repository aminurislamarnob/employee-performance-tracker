<?php
namespace WeLabs\EmployeePerformanceTracker;

class KPACPT {
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
			'name'               => _x( 'KPAs', 'Post type general name', 'employee-performance-tracker' ),
			'singular_name'      => _x( 'KPA', 'Post type singular name', 'employee-performance-tracker' ),
			'menu_name'          => _x( 'KPAs', 'Admin Menu text', 'employee-performance-tracker' ),
			'name_admin_bar'     => _x( 'KPA', 'Add New on Toolbar', 'employee-performance-tracker' ),
			'add_new'            => __( 'Add New', 'employee-performance-tracker' ),
			'add_new_item'       => __( 'Add New KPA', 'employee-performance-tracker' ),
			'new_item'           => __( 'New KPA', 'employee-performance-tracker' ),
			'edit_item'          => __( 'Edit KPA', 'employee-performance-tracker' ),
			'view_item'          => __( 'View KPA', 'employee-performance-tracker' ),
			'all_items'          => __( 'KPAs', 'employee-performance-tracker' ),
			'search_items'       => __( 'Search KPAs', 'employee-performance-tracker' ),
			'parent_item_colon'  => __( 'Parent KPAs:', 'employee-performance-tracker' ),
			'not_found'          => __( 'No KPAs found.', 'employee-performance-tracker' ),
			'not_found_in_trash' => __( 'No KPAs found in Trash.', 'employee-performance-tracker' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => 'performance-tracker',
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'ept-kpa' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'          => 'dashicons-portfolio',
			'supports'           => array( 'title', 'editor', 'author' ),
			'show_in_rest'       => true,
		);

		register_post_type( 'ept_kpa', $args );
	}

	/**
	 * Disable Gutenberg for the custom post type
	 */
	public function disable_gutenberg_for_cpt( $use_block_editor, $post_type ) {
		if ( 'ept_kpa' === $post_type ) {
			return false;
		}

		return $use_block_editor;
	}
}
