<?php
namespace WeLabs\EmployeePerformanceTracker;

class ProjectCPT {
	/**
	 * Constructor to initialize hooks
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_cpt' ) );
		add_filter( 'use_block_editor_for_post_type', array( $this, 'disable_gutenberg_for_cpt' ), 10, 2 );
		add_filter( 'manage_ept_project_posts_columns', array( $this, 'add_columns' ) );
		add_action( 'manage_ept_project_posts_custom_column', array( $this, 'render_columns' ), 10, 2 );
	}

	/**
	 * Register the custom post type
	 */
	public function register_cpt() {
		$labels = array(
			'name'               => _x( 'Projects', 'Post type general name', 'employee-performance-tracker' ),
			'singular_name'      => _x( 'Project', 'Post type singular name', 'employee-performance-tracker' ),
			'menu_name'          => _x( 'Projects', 'Admin Menu text', 'employee-performance-tracker' ),
			'name_admin_bar'     => _x( 'Project', 'Add New on Toolbar', 'employee-performance-tracker' ),
			'add_new'            => __( 'Add New', 'employee-performance-tracker' ),
			'add_new_item'       => __( 'Add New Project', 'employee-performance-tracker' ),
			'new_item'           => __( 'New Project', 'employee-performance-tracker' ),
			'edit_item'          => __( 'Edit Project', 'employee-performance-tracker' ),
			'view_item'          => __( 'View Project', 'employee-performance-tracker' ),
			'all_items'          => __( 'Projects', 'employee-performance-tracker' ),
			'search_items'       => __( 'Search Projects', 'employee-performance-tracker' ),
			'parent_item_colon'  => __( 'Parent Projects:', 'employee-performance-tracker' ),
			'not_found'          => __( 'No Projects found.', 'employee-performance-tracker' ),
			'not_found_in_trash' => __( 'No Projects found in Trash.', 'employee-performance-tracker' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => 'performance-tracker',
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'ept-project' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'          => 'dashicons-portfolio',
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
			'show_in_rest'       => true, // Enables Gutenberg support
		);

		register_post_type( 'ept_project', $args );
	}

	/**
	 * Disable Gutenberg for the custom post type
	 */
	public function disable_gutenberg_for_cpt( $use_block_editor, $post_type ) {
		if ( 'ept_project' === $post_type ) {
			return false;
		}

		return $use_block_editor;
	}

	/**
	 * Add custom columns to the post list table
	 */
	public function add_columns( $columns ) {
		// Add new columns
		$new_columns = array(
			'project_start_date' => __( 'Start Date', 'employee-performance-tracker' ),
			'dev_delivery_date'  => __( 'Dev Delivery Date', 'employee-performance-tracker' ),
			'qa_delivery_date'   => __( 'QA Delivery Date', 'employee-performance-tracker' ),
		);

		// Extract the checkbox and title columns
		$checkbox_column = array( 'cb' => $columns['cb'] );
		$title_column    = array( 'title' => $columns['title'] );

		// Unset extracted columns from the original array
		unset( $columns['cb'], $columns['title'], $columns['comments'] );

		// Change title
		$columns['author'] = __( 'Created by', 'employee-performance-tracker' );
		$columns['date']   = __( 'Created at', 'employee-performance-tracker' );

		// Reorder columns: Checkbox -> Title -> Custom Columns -> Remaining Columns
		return array_merge( $checkbox_column, $title_column, $new_columns, $columns );
	}

	/**
	 * Render content for custom columns
	 */
	public function render_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'project_start_date':
				$date = get_post_meta( $post_id, '_project_start_date', true );
				echo ! empty( $date ) ? esc_html( $date ) : __( 'N/A', 'employee-performance-tracker' );
				break;

			case 'dev_delivery_date':
				$date = get_post_meta( $post_id, '_dev_delivery_date', true );
				echo ! empty( $date ) ? esc_html( $date ) : __( 'N/A', 'employee-performance-tracker' );
				break;

			case 'qa_delivery_date':
				$date = get_post_meta( $post_id, '_qa_delivery_date', true );
				echo ! empty( $date ) ? esc_html( $date ) : __( 'N/A', 'employee-performance-tracker' );
				break;
		}
	}
}
