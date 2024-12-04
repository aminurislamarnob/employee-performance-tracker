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
	'qa_comments'        => isset( $meta['_qa_comments'][0] ) ? $meta['_qa_comments'][0] : '',
	'team_lead_comments' => isset( $meta['_team_lead_comments'][0] ) ? $meta['_team_lead_comments'][0] : '',
	'developer_comments' => isset( $meta['_developer_comments'][0] ) ? $meta['_developer_comments'][0] : '',
);

?>
<div class="performance-log-fields">
	<div class="performance-tracker-field">
		<label for="qa_comments"><?php _e( 'QA Comments', 'employee-performance-tracker' ); ?></label>
		<textarea name="qa_comments" id="qa_comments"><?php echo esc_html( $fields['qa_comments'] ); ?></textarea>
	</div>
	<div class="performance-tracker-field">
		<label for="developer_comments"><?php _e( 'Developer Comments', 'employee-performance-tracker' ); ?></label>
		<textarea name="developer_comments" id="developer_comments"><?php echo esc_html( $fields['developer_comments'] ); ?></textarea>
	</div>
	<div class="performance-tracker-field">
		<label for="team_lead_comments"><?php _e( 'Team Lead Comments', 'employee-performance-tracker' ); ?></label>
		<textarea name="team_lead_comments" id="team_lead_comments"><?php echo esc_html( $fields['team_lead_comments'] ); ?></textarea>
	</div>
</div>