<?php
/**
 * Project KPA Metaboxes
 *
 * @package Employee_Performance_Tracker
 */

$meta = get_post_meta( $post->ID );

$kpa_posts      = get_posts(
	array(
		'post_type'      => 'ept_kpa',
		'posts_per_page' => -1,
	)
);
$assignee_users = get_users( array( 'fields' => array( 'ID', 'display_name' ) ) );

$fields = array(
	'kpa_entries' => isset( $meta['_kpa_entries'][0] ) ? maybe_unserialize( $meta['_kpa_entries'][0] ) : array(),
);
?>

<div class="performance-log-fields">
	<div class="repeater-field performance-tracker-field">
		<label><?php esc_html_e( 'All KPAs', 'employee-performance-tracker' ); ?></label>
		<div class="repeater-items">
			<?php if ( ! empty( $fields['kpa_entries'] ) && is_array( $fields['kpa_entries'] ) ) : ?>
				<?php foreach ( $fields['kpa_entries'] as $index => $kpa ) : ?>
					<?php
					$kpa = $kpa ?? array(
						'kpa_title'  => '',
						'kpa_weight' => '',
					);
					?>
					<div class="repeater-item">
						<div class="performance-tracker-field">
							<label><?php _e( 'Select KPA', 'employee-performance-tracker' ); ?></label>
							<select name="kpa_entries[<?php echo esc_attr( $index ); ?>][kpa_title]" class="regular-text ept-full-width repeater-input-field">
								<option value=""><?php _e( 'Select a KPA', 'employee-performance-tracker' ); ?></option>
								<?php foreach ( $kpa_posts as $kpa_post ) : ?>
									<option value="<?php echo esc_attr( $kpa_post->post_title ); ?>" <?php selected( $kpa['kpa_title'], $kpa_post->post_title ); ?>>
										<?php echo esc_html( $kpa_post->post_title ); ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="performance-tracker-field">
							<label><?php esc_html_e( 'KPA Weight (%)', 'employee-performance-tracker' ); ?></label>
							<input class="regular-text ept-full-width repeater-input-field" type="number" name="kpa_entries[<?php echo esc_attr( $index ); ?>][kpa_weight]" value="<?php echo esc_attr( $kpa['kpa_weight'] ); ?>" />
						</div>
						<button type="button" class="remove-scope button remove-repeater-row"><?php esc_html_e( 'Remove', 'employee-performance-tracker' ); ?></button>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="repeater-item">
					<div class="performance-tracker-field">
						<label><?php _e( 'Select KPA', 'employee-performance-tracker' ); ?></label>
						<select name="kpa_entries[0][kpa_title]" class="regular-text ept-full-width repeater-input-field">
							<option value=""><?php _e( 'Select a KPA', 'employee-performance-tracker' ); ?></option>
							<?php foreach ( $kpa_posts as $kpa_post ) : ?>
								<option value="<?php echo esc_attr( $kpa_post->post_title ); ?>">
									<?php echo esc_html( $kpa_post->post_title ); ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="performance-tracker-field">
						<label><?php esc_html_e( 'KPA Weight (%)', 'employee-performance-tracker' ); ?></label>
						<input class="regular-text ept-full-width repeater-input-field" type="number" name="kpa_entries[0][kpa_weight]" value="" />
					</div>
					<button type="button" class="remove-scope button remove-repeater-row"><?php esc_html_e( 'Remove', 'employee-performance-tracker' ); ?></button>
				</div>
			<?php endif; ?>
		</div>
		<button type="button" class="button add-repeater-row"><?php esc_html_e( 'Add Scope', 'employee-performance-tracker' ); ?></button>
	</div>
</div>