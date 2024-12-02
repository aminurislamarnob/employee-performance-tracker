<?php
namespace WeLabs\EmployeePerformanceTracker;

class AdminMenu {
    /**
     * Constructor to initialize the hooks
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'register_menu' ) );
    }

    /**
     * Register the admin menu
     */
    public function register_menu() {
        add_menu_page(
            __( 'Performance Tracker', 'employee-performance-tracker' ), // Page title
            __( 'Performance Tracker', 'employee-performance-tracker' ), // Menu title
            'manage_options',                                            // Capability
            'performance-tracker',                                       // Menu slug
            array( $this, 'menu_page_callback' ),                        // Callback function
            'dashicons-chart-bar',                                       // Icon
            20                                                           // Position
        );
    }

    /**
     * Callback function for the menu page
     */
    public function menu_page_callback() {
        echo '<div class="wrap">';
        echo '<h1>' . esc_html__( 'Performance Tracker', 'employee-performance-tracker' ) . '</h1>';
        echo '<p>' . esc_html__( 'Welcome to the Performance Tracker admin panel.', 'employee-performance-tracker' ) . '</p>';
        echo '</div>';
    }
}