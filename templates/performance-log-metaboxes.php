<?php
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
	'project'         => isset( $meta['_project'][0] ) ? $meta['_project'][0] : '',
	'assignee'        => isset( $meta['_assignee'][0] ) ? $meta['_assignee'][0] : '',
	'assigned_scopes' => isset( $meta['_assigned_scopes'][0] ) ? maybe_unserialize( $meta['_assigned_scopes'][0] ) : array(),
);

?>

<div class="performance-log-fields">
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
	<div class="repeater-field performance-tracker-field">
		<label><?php esc_html_e( 'Assigned Scopes', 'employee-performance-tracker' ); ?></label>
		<div class="repeater-items">
			<?php if ( ! empty( $fields['assigned_scopes'] ) && is_array( $fields['assigned_scopes'] ) ) : ?>
				<?php foreach ( $fields['assigned_scopes'] as $index => $scope ) : ?>
					<?php
					$scope = $scope ?? array(
						'task_link'  => '',
						'due_date'   => '',
						'start_date' => '',
						'end_date'   => '',
					);
					?>
					<div class="repeater-item">
						<div>
							<label><?php esc_html_e( 'Task Link', 'employee-performance-tracker' ); ?></label>
							<input class="repeater-input-field" type="url" name="assigned_scopes[<?php echo esc_attr( $index ); ?>][task_link]" value="<?php echo esc_url( $scope['task_link'] ); ?>" />
						</div>
						<div class="performance-tracker-dates">
							<div class="performance-tracker-field">
								<label><?php esc_html_e( 'Due Date', 'employee-performance-tracker' ); ?></label>
								<input class="ept_date_picker repeater-input-field" type="text" name="assigned_scopes[<?php echo esc_attr( $index ); ?>][due_date]" value="<?php echo esc_attr( $scope['due_date'] ); ?>" />
							</div>
							<div class="performance-tracker-field">
								<label><?php esc_html_e( 'Start Date', 'employee-performance-tracker' ); ?></label>
								<input class="ept_date_picker repeater-input-field" type="text" name="assigned_scopes[<?php echo esc_attr( $index ); ?>][start_date]" value="<?php echo esc_attr( $scope['start_date'] ); ?>" />
							</div>
							<div class="performance-tracker-field">
								<label><?php esc_html_e( 'End Date', 'employee-performance-tracker' ); ?></label>
								<input class="ept_date_picker repeater-input-field" type="text" name="assigned_scopes[<?php echo esc_attr( $index ); ?>][end_date]" value="<?php echo esc_attr( $scope['end_date'] ); ?>" />
							</div>
						</div>
						<button type="button" class="remove-scope button remove-repeater-row"><?php esc_html_e( 'Remove', 'employee-performance-tracker' ); ?></button>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="repeater-item">
					<div>
						<label><?php esc_html_e( 'Task Link', 'employee-performance-tracker' ); ?></label>
						<input class="repeater-input-field" type="url" name="assigned_scopes[0][task_link]" value="" />
					</div>
					<div class="performance-tracker-dates">
						<div class="performance-tracker-field">
							<label><?php esc_html_e( 'Due Date', 'employee-performance-tracker' ); ?></label>
							<input class="ept_date_picker repeater-input-field" type="text" name="assigned_scopes[0][due_date]" value="" />
						</div>
						<div class="performance-tracker-field">
							<label><?php esc_html_e( 'Start Date', 'employee-performance-tracker' ); ?></label>
							<input class="ept_date_picker repeater-input-field" type="text" name="assigned_scopes[0][start_date]" value="" />
						</div>
						<div class="performance-tracker-field">
							<label><?php esc_html_e( 'End Date', 'employee-performance-tracker' ); ?></label>
							<input class="ept_date_picker repeater-input-field" type="text" name="assigned_scopes[0][end_date]" value="" />
						</div>
					</div>
					<button type="button" class="remove-scope button remove-repeater-row"><?php esc_html_e( 'Remove', 'employee-performance-tracker' ); ?></button>
				</div>
			<?php endif; ?>
		</div>
		<button type="button" class="button add-repeater-row"><?php esc_html_e( 'Add Scope', 'employee-performance-tracker' ); ?></button>
	</div>
</div>