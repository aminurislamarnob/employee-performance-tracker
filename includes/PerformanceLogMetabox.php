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
			__( 'Project Scopes & Assignee', 'employee-performance-tracker' ),
			array( $this, 'render_project_specific_metabox' ),
			'ept_performance_log',
			'normal',
			'high'
		);

		add_meta_box(
			'performance_log_qa_metabox',
			__( 'QA Related Informations', 'employee-performance-tracker' ),
			array( $this, 'render_qa_specific_metabox' ),
			'ept_performance_log',
			'normal',
			'high'
		);

		add_meta_box(
			'performance_log_client_metabox',
			__( 'Client Feedback', 'employee-performance-tracker' ),
			array( $this, 'render_client_specific_metabox' ),
			'ept_performance_log',
			'normal',
			'high'
		);

		add_meta_box(
			'performance_log_comments_metabox',
			__( 'Comments/Feedback', 'employee-performance-tracker' ),
			array( $this, 'render_comment_specific_metabox' ),
			'ept_performance_log',
			'normal',
			'high'
		);

		add_meta_box(
			'performance_log_kpa_metabox',
			__( 'KPA for Developer (Manually)', 'employee-performance-tracker' ),
			array( $this, 'render_kpa_for_dev_specific_metabox' ),
			'ept_performance_log',
			'normal',
			'high'
		);
	}

	/**
	 * Render the metabox
	 */
	public function render_project_specific_metabox( $post ) {
		// Add nonce for security.
		wp_nonce_field( 'performance_log_nonce_action', 'performance_log_nonce' );

		require welabs_employee_performance_tracker()->get_template( 'performance-log-metaboxes.php' );
	}

	/**
	 * Render the metabox
	 */
	public function render_qa_specific_metabox( $post ) {
		require welabs_employee_performance_tracker()->get_template( 'performance-log-qa-metaboxes.php' );
	}

	/**
	 * Render the metabox
	 */
	public function render_client_specific_metabox( $post ) {
		require welabs_employee_performance_tracker()->get_template( 'performance-log-client-metaboxes.php' );
	}

	/**
	 * Render the metabox
	 */
	public function render_comment_specific_metabox( $post ) {
		require welabs_employee_performance_tracker()->get_template( 'performance-log-comment-metaboxes.php' );
	}

	/**
	 * Render the metabox
	 */
	public function render_kpa_for_dev_specific_metabox( $post ) {
		require welabs_employee_performance_tracker()->get_template( 'performance-log-kpa-for-dev-metaboxes.php' );
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

		// Save repeater fields: Assigned Scopes.
		if ( isset( $_POST['assigned_scopes'] ) && is_array( $_POST['assigned_scopes'] ) ) {
			$assigned_scopes = array(); // Initialize an empty array to hold the processed data.

			foreach ( $_POST['assigned_scopes'] as $scope ) {
				$assigned_scopes[] = array(
					'task_link'  => isset( $scope['task_link'] ) ? esc_url_raw( $scope['task_link'] ) : '',
					'due_date'   => isset( $scope['due_date'] ) ? sanitize_text_field( $scope['due_date'] ) : '',
					'start_date' => isset( $scope['start_date'] ) ? sanitize_text_field( $scope['start_date'] ) : '',
					'end_date'   => isset( $scope['end_date'] ) ? sanitize_text_field( $scope['end_date'] ) : '',
				);
			}

			update_post_meta( $post_id, '_assigned_scopes', $assigned_scopes );
		} else {
			delete_post_meta( $post_id, '_assigned_scopes' );
		}

		// Save repeater fields: QA Issues.
		if ( isset( $_POST['qa_issues'] ) && is_array( $_POST['qa_issues'] ) ) {
			$qa_issues = array(); // Initialize an empty array to hold the processed data.

			foreach ( $_POST['qa_issues'] as $scope ) {
				$qa_issues[] = array(
					'task_link'  => isset( $scope['task_link'] ) ? esc_url_raw( $scope['task_link'] ) : '',
					'due_date'   => isset( $scope['due_date'] ) ? sanitize_text_field( $scope['due_date'] ) : '',
					'start_date' => isset( $scope['start_date'] ) ? sanitize_text_field( $scope['start_date'] ) : '',
					'end_date'   => isset( $scope['end_date'] ) ? sanitize_text_field( $scope['end_date'] ) : '',
				);
			}

			update_post_meta( $post_id, '_qa_issues', $qa_issues );
		} else {
			delete_post_meta( $post_id, '_qa_issues' );
		}

		// Save repeater fields: Client Issues.
		if ( isset( $_POST['client_issues'] ) && is_array( $_POST['client_issues'] ) ) {
			$client_issues = array(); // Initialize an empty array to hold the processed data.

			foreach ( $_POST['client_issues'] as $scope ) {
				$client_issues[] = array(
					'task_link'  => isset( $scope['task_link'] ) ? esc_url_raw( $scope['task_link'] ) : '',
					'due_date'   => isset( $scope['due_date'] ) ? sanitize_text_field( $scope['due_date'] ) : '',
					'start_date' => isset( $scope['start_date'] ) ? sanitize_text_field( $scope['start_date'] ) : '',
					'end_date'   => isset( $scope['end_date'] ) ? sanitize_text_field( $scope['end_date'] ) : '',
				);
			}

			update_post_meta( $post_id, '_client_issues', $client_issues );
		} else {
			delete_post_meta( $post_id, '_client_issues' );
		}

		// Save meta fields.
		$fields = array(
			'project',
			'assignee',
			'qa_comments',
			'team_lead_comments',
			'developer_comments',
		);

		foreach ( $fields as $field ) {
			if ( isset( $_POST[ $field ] ) ) {
				update_post_meta( $post_id, "_$field", $_POST[ $field ] );
			}
		}

		// Save fields: KPA for developer informations.
		if ( isset( $_POST['project'] ) ) {
			$project_id   = sanitize_text_field( wp_unslash( $_POST['project'] ) );
			$_kpa_entries = get_post_meta( $project_id, '_kpa_entries', true );
		} else {
			$_kpa_entries = array();
		}

		$_kpa_for_dev = isset( $_POST['kpa_for_dev'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['kpa_for_dev'] ) ) : array();

		$_kpa_for_dev = isset( $_POST['kpa_for_dev'] ) ? wp_unslash( $_POST['kpa_for_dev'] ) : array();
		foreach ( $_kpa_for_dev as $index => $kpa ) {
			$_kpa_for_dev[ $index ]['kpa_score'] = isset( $kpa['kpa_score'] ) ? sanitize_text_field( $kpa['kpa_score'] ) : '';
		}

		if ( ! empty( $_kpa_entries ) && is_array( $_kpa_entries ) ) {
			$kpa_for_dev = array(); // Initialize an empty array to hold the processed data.

			foreach ( $_kpa_entries as $index => $kpa ) {
				// Process each entry in $_kpa_entries and associate with data in $_kpa_for_dev.
				$kpa_for_dev[] = array(
					'kpa_title'  => isset( $kpa['kpa_title'] ) ? sanitize_text_field( $kpa['kpa_title'] ) : '',
					'kpa_weight' => isset( $kpa['kpa_weight'] ) ? sanitize_text_field( $kpa['kpa_weight'] ) : '',
					'kpa_score'  => isset( $_kpa_for_dev[ $index ] ) && is_array( $_kpa_for_dev[ $index ] ) && isset( $_kpa_for_dev[ $index ]['kpa_score'] ) ? sanitize_text_field( $_kpa_for_dev[ $index ]['kpa_score'] ) : '',
				);
			}

			// Update the post meta with the processed data.
			update_post_meta( $post_id, '_kpa_for_dev', $kpa_for_dev );
		} else {
			delete_post_meta( $post_id, '_kpa_for_dev' );
		}
	}
}
