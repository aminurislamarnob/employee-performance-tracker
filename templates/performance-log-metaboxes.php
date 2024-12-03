<?php

// Add nonce for security.
wp_nonce_field( 'performance_log_nonce_action', 'performance_log_nonce' );

// Get existing meta values.
$meta = get_post_meta( $post->ID );

$projects       = get_posts(
	array(
		'post_type'      => 'ept_project',
		'posts_per_page' => -1,
	)
);
$assignee_users = get_users( array( 'fields' => array( 'ID', 'display_name' ) ) );

$fields = array(
	'project'                     => isset( $meta['_project'][0] ) ? $meta['_project'][0] : '',
	'assignee'                    => isset( $meta['_assignee'][0] ) ? $meta['_assignee'][0] : '',
	'assigned_scopes'             => isset( $meta['_assigned_scopes'][0] ) ? maybe_unserialize( $meta['_assigned_scopes'][0] ) : array(),
	'dev_start_date'              => isset( $meta['_dev_start_date'][0] ) ? $meta['_dev_start_date'][0] : '',
	'dev_end_date'                => isset( $meta['_dev_end_date'][0] ) ? $meta['_dev_end_date'][0] : '',
	'qa_issues'                   => isset( $meta['_qa_issues'][0] ) ? maybe_unserialize( $meta['_qa_issues'][0] ) : array(),
	'qa_issue_fix_start_date'     => isset( $meta['_qa_issue_fix_start_date'][0] ) ? $meta['_qa_issue_fix_start_date'][0] : '',
	'qa_issue_fix_end_date'       => isset( $meta['_qa_issue_fix_end_date'][0] ) ? $meta['_qa_issue_fix_end_date'][0] : '',
	'client_issues'               => isset( $meta['_client_issues'][0] ) ? maybe_unserialize( $meta['_client_issues'][0] ) : array(),
	'client_issue_fix_start_date' => isset( $meta['_client_issue_fix_start_date'][0] ) ? $meta['_client_issue_fix_start_date'][0] : '',
	'client_issue_fix_end_date'   => isset( $meta['_client_issue_fix_end_date'][0] ) ? $meta['_client_issue_fix_end_date'][0] : '',
	'final_delivery_date'         => isset( $meta['_final_delivery_date'][0] ) ? $meta['_final_delivery_date'][0] : '',
	'qa_comments'                 => isset( $meta['_qa_comments'][0] ) ? $meta['_qa_comments'][0] : '',
	'team_lead_comments'          => isset( $meta['_team_lead_comments'][0] ) ? $meta['_team_lead_comments'][0] : '',
	'developer_comments'          => isset( $meta['_developer_comments'][0] ) ? $meta['_developer_comments'][0] : '',
);

?>

<div class="performance-log-fields">
	<h3><?php _e( 'Project Scopes & Assignee', 'employee-performance-tracker' ); ?></h3>
	<div class="performance-tracker-field">
		<label for="project"><?php _e( 'Select Project', 'employee-performance-tracker' ); ?></label>
		<select id="project" name="project" class="regular-text ept-full-width">
			<option value=""><?php _e( 'Select a project', 'employee-performance-tracker' ); ?></option>
			<?php foreach ( $projects as $project ) : ?>
				<option value="<?php echo esc_attr( $project->ID ); ?>" <?php selected( $fields['project'], $project->ID ); ?>>
					<?php echo esc_html( $project->post_title ); ?>
				</option>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="performance-tracker-field">
		<label for="assignee"><?php _e( 'Assignee', 'employee-performance-tracker' ); ?></label>
		<select id="assignee" name="assignee" class="regular-text ept-full-width">
			<option value=""><?php _e( 'Select an assignee', 'employee-performance-tracker' ); ?></option>
			<?php foreach ( $assignee_users as $user ) : ?>
				<option value="<?php echo esc_attr( $user->ID ); ?>" <?php selected( $fields['assignee'], $user->ID ); ?>>
					<?php echo esc_html( $user->display_name ); ?>
				</option>
			<?php endforeach; ?>
		</select>
	</div>
	<div id="assigned-scopes" class="repeater-field performance-tracker-field">
		<label><?php esc_html_e( 'Assigned Scopes', 'employee-performance-tracker' ); ?></label>
		<div class="repeater-items">
			<?php if ( ! empty( $fields['assigned_scopes'] ) && is_array( $fields['assigned_scopes'] ) ) : ?>
				<?php foreach ( $fields['assigned_scopes'] as $index => $scope ) : ?>
					<?php
					$scope = $scope ?? array(
						'issue_link' => '',
						'due_date'   => '',
						'start_date' => '',
						'end_date'   => '',
					);
					?>
					<div class="repeater-item">
						<div>
							<label><?php esc_html_e( 'GitHub Issue Link', 'employee-performance-tracker' ); ?></label>
							<input type="url" name="assigned_scopes[<?php echo esc_attr( $index ); ?>][issue_link]" value="<?php echo esc_url( $scope['issue_link'] ); ?>" />
						</div>
						<div class="performance-tracker-dates">
							<div class="performance-tracker-field">
								<label><?php esc_html_e( 'Due Date', 'employee-performance-tracker' ); ?></label>
								<input class="ept_date_picker" type="text" name="assigned_scopes[<?php echo esc_attr( $index ); ?>][due_date]" value="<?php echo esc_attr( $scope['due_date'] ); ?>" />
							</div>
							<div class="performance-tracker-field">
								<label><?php esc_html_e( 'Start Date', 'employee-performance-tracker' ); ?></label>
								<input class="ept_date_picker" type="text" name="assigned_scopes[<?php echo esc_attr( $index ); ?>][start_date]" value="<?php echo esc_attr( $scope['start_date'] ); ?>" />
							</div>
							<div class="performance-tracker-field">
								<label><?php esc_html_e( 'End Date', 'employee-performance-tracker' ); ?></label>
								<input class="ept_date_picker" type="text" name="assigned_scopes[<?php echo esc_attr( $index ); ?>][end_date]" value="<?php echo esc_attr( $scope['end_date'] ); ?>" />
							</div>
						</div>
						<button type="button" class="remove-scope button"><?php esc_html_e( 'Remove', 'employee-performance-tracker' ); ?></button>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="repeater-item">
					<div>
						<label><?php esc_html_e( 'GitHub Issue Link', 'employee-performance-tracker' ); ?></label>
						<input type="url" name="assigned_scopes[0][issue_link]" value="" />
					</div>
					<div class="performance-tracker-dates">
						<div class="performance-tracker-field">
							<label><?php esc_html_e( 'Due Date', 'employee-performance-tracker' ); ?></label>
							<input type="text" name="assigned_scopes[0][due_date]" value="" />
						</div>
						<div class="performance-tracker-field">
							<label><?php esc_html_e( 'Start Date', 'employee-performance-tracker' ); ?></label>
							<input type="text" name="assigned_scopes[0][start_date]" value="" />
						</div>
						<div class="performance-tracker-field">
							<label><?php esc_html_e( 'End Date', 'employee-performance-tracker' ); ?></label>
							<input type="text" name="assigned_scopes[0][end_date]" value="" />
						</div>
					</div>
					<button type="button" class="remove-scope button"><?php esc_html_e( 'Remove', 'employee-performance-tracker' ); ?></button>
				</div>
			<?php endif; ?>
		</div>
		<button type="button" id="add-scope" class="button"><?php esc_html_e( 'Add Scope', 'employee-performance-tracker' ); ?></button>
	</div>
	<h3><?php _e( 'QA Related Informations', 'employee-performance-tracker' ); ?></h3>
</div>