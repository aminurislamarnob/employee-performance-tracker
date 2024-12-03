<?php
namespace WeLabs\EmployeePerformanceTracker;

class PerformanceLogMetabox {
	/**
	 * Constructor to initialize hooks
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'register_metaboxes' ) );
		add_action( 'save_post', array( $this, 'save_metaboxes' ) );
	}

	/**
	 * Register the metaboxes
	 */
	public function register_metaboxes() {
		add_meta_box(
			'performance_log_metabox',
			__( 'Log Informations', 'employee-performance-tracker' ),
			array( $this, 'render_metabox' ),
			'ept_performance_log',
			'normal',
			'high'
		);
	}

	/**
	 * Render the metabox
	 */
	public function render_metabox( $post ) {
		require welabs_employee_performance_tracker()->get_template( 'performance-log-metaboxes.php' );
	}

	/**
	 * Save the metabox fields
	 */
	public function save_metaboxes( $post_id ) {
		// Check nonce.
		if ( ! isset( $_POST['performance_log_nonce'] ) || ! wp_verify_nonce( $_POST['performance_log_nonce'], 'performance_log_nonce_action' ) ) {
			return;
		}

		// Prevent autosave.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check user permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		error_log( wp_json_encode( $_POST['assigned_scopes'] ) );

		// Save repeater fields: Assigned Scopes.
		if ( isset( $_POST['assigned_scopes'] ) && is_array( $_POST['assigned_scopes'] ) ) {
			$assigned_scopes = array_map(
				function ( $scope ) {
					return array(
						'issue_link' => isset( $scope['issue_link'] ) ? esc_url_raw( $scope['issue_link'] ) : '',
						'due_date'   => isset( $scope['due_date'] ) ? sanitize_text_field( $scope['due_date'] ) : '',
						'start_date' => isset( $scope['start_date'] ) ? sanitize_text_field( $scope['start_date'] ) : '',
						'end_date'   => isset( $scope['end_date'] ) ? sanitize_text_field( $scope['end_date'] ) : '',
					);
				},
				$_POST['assigned_scopes']
			);

			update_post_meta( $post_id, '_assigned_scopes', $assigned_scopes );
		} else {
			delete_post_meta( $post_id, '_assigned_scopes' );
		}

		// Save meta fields.
		$fields = array(
			'project',
			'assignee',
			// Add other fields
		);

		foreach ( $fields as $field ) {
			if ( isset( $_POST[ $field ] ) ) {
				update_post_meta( $post_id, "_$field", $_POST[ $field ] );
			}
		}
	}
}
