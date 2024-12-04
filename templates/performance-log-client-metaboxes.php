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
	'client_issues' => isset( $meta['_client_issues'][0] ) ? maybe_unserialize( $meta['_client_issues'][0] ) : array(),
);

?>

<div class="performance-log-fields">
	<div class="repeater-field performance-tracker-field">
		<label><?php esc_html_e( 'Client Issues', 'employee-performance-tracker' ); ?></label>
		<div class="repeater-items">
			<?php if ( ! empty( $fields['client_issues'] ) && is_array( $fields['client_issues'] ) ) : ?>
				<?php foreach ( $fields['client_issues'] as $index => $client_issue ) : ?>
					<?php
					$client_issue = $client_issue ?? array(
						'task_link'  => '',
						'due_date'   => '',
						'start_date' => '',
						'end_date'   => '',
					);
					?>
					<div class="repeater-item">
						<div>
							<label><?php esc_html_e( 'Issue Link', 'employee-performance-tracker' ); ?></label>
							<input class="repeater-input-field" type="url" name="client_issues[<?php echo esc_attr( $index ); ?>][task_link]" value="<?php echo esc_url( $client_issue['task_link'] ); ?>" />
						</div>
						<div class="performance-tracker-dates">
							<div class="performance-tracker-field">
								<label><?php esc_html_e( 'Due Date', 'employee-performance-tracker' ); ?></label>
								<input class="ept_date_picker repeater-input-field" type="text" name="client_issues[<?php echo esc_attr( $index ); ?>][due_date]" value="<?php echo esc_attr( $client_issue['due_date'] ); ?>" />
							</div>
							<div class="performance-tracker-field">
								<label><?php esc_html_e( 'Start Date', 'employee-performance-tracker' ); ?></label>
								<input class="ept_date_picker repeater-input-field" type="text" name="client_issues[<?php echo esc_attr( $index ); ?>][start_date]" value="<?php echo esc_attr( $client_issue['start_date'] ); ?>" />
							</div>
							<div class="performance-tracker-field">
								<label><?php esc_html_e( 'End Date', 'employee-performance-tracker' ); ?></label>
								<input class="ept_date_picker repeater-input-field" type="text" name="client_issues[<?php echo esc_attr( $index ); ?>][end_date]" value="<?php echo esc_attr( $client_issue['end_date'] ); ?>" />
							</div>
						</div>
						<button type="button" class="remove-scope button remove-repeater-row"><?php esc_html_e( 'Remove', 'employee-performance-tracker' ); ?></button>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="repeater-item">
					<div>
						<label><?php esc_html_e( 'Issue Link', 'employee-performance-tracker' ); ?></label>
						<input class="repeater-input-field" type="url" name="client_issues[0][task_link]" value="" />
					</div>
					<div class="performance-tracker-dates">
						<div class="performance-tracker-field">
							<label><?php esc_html_e( 'Due Date', 'employee-performance-tracker' ); ?></label>
							<input class="ept_date_picker repeater-input-field" type="text" name="client_issues[0][due_date]" value="" />
						</div>
						<div class="performance-tracker-field">
							<label><?php esc_html_e( 'Start Date', 'employee-performance-tracker' ); ?></label>
							<input class="ept_date_picker repeater-input-field" type="text" name="client_issues[0][start_date]" value="" />
						</div>
						<div class="performance-tracker-field">
							<label><?php esc_html_e( 'End Date', 'employee-performance-tracker' ); ?></label>
							<input class="ept_date_picker repeater-input-field" type="text" name="client_issues[0][end_date]" value="" />
						</div>
					</div>
					<button type="button" class="remove-scope button remove-repeater-row"><?php esc_html_e( 'Remove', 'employee-performance-tracker' ); ?></button>
				</div>
			<?php endif; ?>
		</div>
		<button type="button" class="button add-repeater-row"><?php esc_html_e( 'Add Client Issue', 'employee-performance-tracker' ); ?></button>
	</div>
</div>