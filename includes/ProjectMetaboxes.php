<?php
namespace WeLabs\EmployeePerformanceTracker;

class ProjectMetaboxes {
    /**
     * Constructor to initialize hooks
     */
    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_metaboxes' ) );
        add_action( 'save_post', array( $this, 'save_metaboxes' ) );
    }

    /**
     * Register the Metaboxes
     */
    public function add_metaboxes() {
        add_meta_box(
            'project_metaboxes',
            __( 'Project Informations', 'employee-performance-tracker' ),
            array( $this, 'render_project_metabox' ),
            'ept_project',
            'normal',
            'high'
        );
    }

    /**
     * Render the Project Metabox
     */
    public function render_project_metabox( $post ) {
        require welabs_employee_performance_tracker()->get_template('project-metaboxes.php');
    }

    /**
     * Save the Metaboxes Data
     */
    public function save_metaboxes( $post_id ) {
        if ( ! isset( $_POST['performance_tracker_nonce'] ) || ! wp_verify_nonce( $_POST['performance_tracker_nonce'], 'save_metaboxes' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        // Save Assignees
        if ( isset( $_POST['assignees'] ) && is_array( $_POST['assignees'] ) ) {
            $assignees = array_map( 'sanitize_text_field', $_POST['assignees'] );
            update_post_meta( $post_id, '_assignees', $assignees );
        } else {
            delete_post_meta( $post_id, '_assignees' );
        }

        // Save Repository
        if ( isset( $_POST['repository_link'] ) && is_array( $_POST['repository_link'] ) ) {
            $repository_link = array_map( 'sanitize_text_field', $_POST['repository_link'] );
            update_post_meta( $post_id, '_repository_link', $repository_link );
        } else {
            delete_post_meta( $post_id, '_repository_link' );
        }

        // Save Dates
        $fields = [
            'project_start_date' => '_project_start_date',
            'dev_delivery_date'  => '_dev_delivery_date',
            'qa_delivery_date'   => '_qa_delivery_date',
        ];

        foreach ( $fields as $key => $meta_key ) {
            if ( isset( $_POST[ $key ] ) ) {
                update_post_meta( $post_id, $meta_key, sanitize_text_field( $_POST[ $key ] ) );
            } else {
                delete_post_meta( $post_id, $meta_key );
            }
        }
    }
}