<?php
	$_project_id = get_post_meta( $post->ID, '_project', true );
if ( ! empty( $_project_id ) ) :
	$_kpa_entries = get_post_meta( $_project_id, '_kpa_entries', true );
	if ( ! empty( $_kpa_entries ) ) :
		$kpa_scores = array(
			'1' => 'Unsatisfactory (1)',
			'2' => 'Needs improvement (2)',
			'3' => 'Satisfactory (3)',
			'4' => 'Good (4)',
			'5' => 'Outstanding (5)',
		);

		$_kpa_for_dev = get_post_meta( $post->ID, '_kpa_for_dev', true );
		$_kpa_for_dev = ! empty( $_kpa_for_dev ) ? $_kpa_for_dev : array();
		?>
<div class="performance-log-fields">
		<?php foreach ( $_kpa_entries as $index => $kpa ) : ?>
	<div class="performance-tracker-dates">
		<div class="performance-tracker-field">
			<label><?php _e( 'KPA', 'employee-performance-tracker' ); ?></label>
			<input type="text" value="<?php echo esc_attr( $kpa['kpa_title'] ); ?>" readonly>
		</div>
		<div class="performance-tracker-field">
			<label><?php _e( 'KPA Weight (%)', 'employee-performance-tracker' ); ?></label>
			<input type="text" value="<?php echo esc_attr( $kpa['kpa_weight'] ); ?>" readonly>
		</div>
		<div class="performance-tracker-field">
			<label><?php _e( 'KPA Score', 'employee-performance-tracker' ); ?></label>
			<select name="kpa_for_dev[<?php echo esc_attr( $index ); ?>][kpa_score]">
				<option value=""><?php _e( 'Select a score', 'employee-performance-tracker' ); ?></option>
				<?php foreach ( $kpa_scores as $key => $value ) : ?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php echo ( isset( $_kpa_for_dev[ $index ]['kpa_score'] ) && $_kpa_for_dev[ $index ]['kpa_score'] == $key ) ? 'selected' : ''; ?>>
						<?php echo esc_html( $value ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<?php endforeach; ?>
</div>
<?php endif; ?>
<?php else : ?>
<div class="">
	<p><?php esc_html_e( 'You will get KPA-related fields after saving the post by selecting a project.', 'employee-performance-tracker' ); ?></p>
</div>
<?php endif; ?>