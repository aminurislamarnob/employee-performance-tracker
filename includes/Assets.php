<?php

namespace WeLabs\EmployeePerformanceTracker;

class Assets {
    /**
     * The constructor.
     */
    public function __construct() {
        add_action( 'init', [ $this, 'register_all_scripts' ], 10 );

        if ( is_admin() ) {
            add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ], 10 );
        } else {
            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_front_scripts' ] );
        }
    }

    /**
     * Register all Dokan scripts and styles.
     *
     * @return void
     */
    public function register_all_scripts() {
        $this->register_styles();
        $this->register_scripts();
    }

    /**
     * Register scripts.
     *
     * @param array $scripts
     *
     * @return void
     */
    public function register_scripts() {
        
        // Admin script.
        wp_register_script( 'employee_performance_tracker_admin_script', EMPLOYEE_PERFORMANCE_TRACKER_PLUGIN_ASSET . '/admin/script.js', [], EMPLOYEE_PERFORMANCE_TRACKER_PLUGIN_VERSION, true );
        wp_register_script( 'select2_js', EMPLOYEE_PERFORMANCE_TRACKER_PLUGIN_ASSET . '/admin/select2.min.js', ['jquery'], '4.1.0', true );
        
        // Frontend script.
        wp_register_script( 'employee_performance_tracker_script', EMPLOYEE_PERFORMANCE_TRACKER_PLUGIN_ASSET . '/frontend/script.js', [], EMPLOYEE_PERFORMANCE_TRACKER_PLUGIN_VERSION, true );
    }

    /**
     * Register styles.
     *
     * @return void
     */
    public function register_styles() {
        // Admin style.
        wp_register_style( 'employee_performance_tracker_admin_style', EMPLOYEE_PERFORMANCE_TRACKER_PLUGIN_ASSET . '/admin/style.css', [], EMPLOYEE_PERFORMANCE_TRACKER_PLUGIN_VERSION );
        wp_register_style( 'select2_style', EMPLOYEE_PERFORMANCE_TRACKER_PLUGIN_ASSET . '/admin/select2.min.css', [], '4.1.0' );

        // Frontend style.
        wp_register_style( 'employee_performance_tracker_style', EMPLOYEE_PERFORMANCE_TRACKER_PLUGIN_ASSET . '/frontend/style.css', [], EMPLOYEE_PERFORMANCE_TRACKER_PLUGIN_VERSION );
    }

    /**
     * Enqueue admin scripts.
     *
     * @return void
     */
    public function enqueue_admin_scripts( $hook ) {
        global $post_type;

        wp_enqueue_style( 'employee_performance_tracker_admin_style' );
        wp_enqueue_script( 'employee_performance_tracker_admin_script' );
        wp_localize_script(
            'employee_performance_tracker_admin_script', 'Employee_Performance_Tracker_Admin', []
        );


        if ( 'ept_project' === $post_type && ( 'post.php' === $hook || 'post-new.php' === $hook ) ) {
            // Enqueue Select2
            wp_enqueue_script( 'select2_js' );
            wp_enqueue_style( 'select2_style' );
            wp_localize_script(
                'select2_js', 'Select2', [
                    'assignee_placeholder' => __( 'Select assignee', 'employee-performance-tracker' ),
                ]
            );
           
            // Enqueue Datepicker
            wp_enqueue_style( 'jquery-ui-datepicker' );
            wp_enqueue_script( 'jquery-ui-datepicker' );
        }
    }

    /**
     * Enqueue front-end scripts.
     *
     * @return void
     */
    public function enqueue_front_scripts() {
        wp_enqueue_script( 'employee_performance_tracker_script' );
        wp_localize_script(
            'employee_performance_tracker_script', 'Employee_Performance_Tracker', []
        );
    }
}
