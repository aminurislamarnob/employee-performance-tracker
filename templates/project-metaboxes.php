<div class="project-metaboxes">
	<div class="performance-tracker-field">
		<?php
			$repository_link = get_post_meta( $post->ID, '_repository_link', true );
		?>
		<label for="repository_link"><?php echo esc_html__( 'Repository Link', 'employee-performance-tracker' ); ?></label>
		<input class="regular-text ept-full-width" type="text" id="repository_link" name="repository_link" value="<?php echo esc_attr( $repository_link ); ?>">
	</div>
	<?php
		$project_start_date = get_post_meta( $post->ID, '_project_start_date', true );
		$dev_delivery_date  = get_post_meta( $post->ID, '_dev_delivery_date', true );
		$qa_delivery_date   = get_post_meta( $post->ID, '_qa_delivery_date', true );
	?>
	<div class="performance-tracker-dates">
		<div class="performance-tracker-field">
			<label for="project_start_date"><?php echo esc_html__( 'Project Start Date', 'employee-performance-tracker' ); ?></label>
			<input class="regular-text ept-full-width" type="text" id="project_start_date" name="project_start_date" value="<?php echo esc_attr( $project_start_date ); ?>">
		</div>
		<div class="performance-tracker-field">
			<label for="dev_delivery_date"><?php echo esc_html__( 'Dev Delivery Date', 'employee-performance-tracker' ); ?></label>
			<input class="regular-text ept-full-width" type="text" id="dev_delivery_date" name="dev_delivery_date" value="<?php echo esc_attr( $dev_delivery_date ); ?>">
		</div>
		<div class="performance-tracker-field">
			<label for="qa_delivery_date"><?php echo esc_html__( 'QA Delivery Date', 'employee-performance-tracker' ); ?></label>
			<input class="regular-text ept-full-width" type="text" id="qa_delivery_date" name="qa_delivery_date" value="<?php echo esc_attr( $qa_delivery_date ); ?>">
		</div>
	</div>
	<div class="performance-tracker-field">
		<?php
			$selected_assignees = get_post_meta( $post->ID, '_assignees', true );
			$selected_assignees = is_array( $selected_assignees ) ? $selected_assignees : array();
			wp_nonce_field( 'save_metaboxes', 'performance_tracker_nonce' );
			$users = get_users( array( 'fields' => array( 'ID', 'display_name' ) ) );
		?>
		<label for="project_assignees"><?php echo esc_html__( 'Select Assignees', 'employee-performance-tracker' ); ?></label>
		<select class="regular-text ept-full-width" name="assignees[]" id="project_assignees" multiple="multiple">
		<?php
		foreach ( $users as $user ) {
			$selected = in_array( $user->ID, $selected_assignees ) ? 'selected="selected"' : '';
			echo '<option value="' . esc_attr( $user->ID ) . '" ' . $selected . '>' . esc_html( $user->display_name ) . '</option>';
		}
		?>
		</select>
	</div>
</div>