<?php
/**
 * Plugin Name: Employee Performance Tracker
 * Plugin URI:  https://wordpress.org/plugins/employee-performance-tracker/
 * Description: Project wise employee performance tracker for service base company.
 * Version: 0.0.1
 * Author: aminurislamarnob
 * Author URI: https://wordpress.org/plugins/employee-performance-tracker/
 * Text Domain: employee-performance-tracker
 * WC requires at least: 5.0.0
 * Domain Path: /languages/
 * License: GPL2
 */
use WeLabs\EmployeePerformanceTracker\EmployeePerformanceTracker;

// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'EMPLOYEE_PERFORMANCE_TRACKER_FILE' ) ) {
    define( 'EMPLOYEE_PERFORMANCE_TRACKER_FILE', __FILE__ );
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Load Employee_Performance_Tracker Plugin when all plugins loaded
 *
 * @return \WeLabs\EmployeePerformanceTracker\EmployeePerformanceTracker
 */
function welabs_employee_performance_tracker() {
    return EmployeePerformanceTracker::init();
}

// Lets Go....
welabs_employee_performance_tracker();
