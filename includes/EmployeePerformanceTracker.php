<?php

namespace WeLabs\EmployeePerformanceTracker;

/**
 * EmployeePerformanceTracker class
 *
 * @class EmployeePerformanceTracker The class that holds the entire EmployeePerformanceTracker plugin
 */
final class EmployeePerformanceTracker {

    /**
     * Plugin version
     *
     * @var string
     */
    public $version = '0.0.1';

    /**
     * Instance of self
     *
     * @var EmployeePerformanceTracker
     */
    private static $instance = null;

    /**
     * Holds various class instances
     *
     * @since 2.6.10
     *
     * @var array
     */
    private $container = [];

    /**
     * Constructor for the EmployeePerformanceTracker class
     *
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     */
    private function __construct() {
        $this->define_constants();

        register_activation_hook( EMPLOYEE_PERFORMANCE_TRACKER_FILE, [ $this, 'activate' ] );
        register_deactivation_hook( EMPLOYEE_PERFORMANCE_TRACKER_FILE, [ $this, 'deactivate' ] );

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
        add_action( 'woocommerce_flush_rewrite_rules', [ $this, 'flush_rewrite_rules' ] );
    }

    /**
     * Initializes the EmployeePerformanceTracker() class
     *
     * Checks for an existing EmployeePerformanceTracker instance
     * and if it doesn't find one then create a new one.
     *
     * @return EmployeePerformanceTracker
     */
    public static function init() {
        if ( self::$instance === null ) {
			self::$instance = new self();
		}

        return self::$instance;
    }

    /**
     * Magic getter to bypass referencing objects
     *
     * @since 2.6.10
     *
     * @param string $prop
     *
     * @return Class Instance
     */
    public function __get( $prop ) {
		if ( array_key_exists( $prop, $this->container ) ) {
            return $this->container[ $prop ];
		}
    }

    /**
     * Placeholder for activation function
     *
     * Nothing is being called here yet.
     */
    public function activate() {
        // Rewrite rules during employee_performance_tracker activation
        if ( $this->has_woocommerce() ) {
            $this->flush_rewrite_rules();
        }
    }

    /**
     * Flush rewrite rules after employee_performance_tracker is activated or woocommerce is activated
     *
     * @since 3.2.8
     */
    public function flush_rewrite_rules() {
        // fix rewrite rules
        flush_rewrite_rules();
    }

    /**
     * Placeholder for deactivation function
     *
     * Nothing being called here yet.
     */
    public function deactivate() {     }

    /**
     * Define all constants
     *
     * @return void
     */
    public function define_constants() {
        defined( 'EMPLOYEE_PERFORMANCE_TRACKER_PLUGIN_VERSION' ) || define( 'EMPLOYEE_PERFORMANCE_TRACKER_PLUGIN_VERSION' , $this->version );
        defined( 'EMPLOYEE_PERFORMANCE_TRACKER_DIR' ) || define( 'EMPLOYEE_PERFORMANCE_TRACKER_DIR' , dirname( EMPLOYEE_PERFORMANCE_TRACKER_FILE ) );
        defined( 'EMPLOYEE_PERFORMANCE_TRACKER_INC_DIR' ) || define( 'EMPLOYEE_PERFORMANCE_TRACKER_INC_DIR' , EMPLOYEE_PERFORMANCE_TRACKER_DIR . '/includes' );
        defined( 'EMPLOYEE_PERFORMANCE_TRACKER_TEMPLATE_DIR' ) || define( 'EMPLOYEE_PERFORMANCE_TRACKER_TEMPLATE_DIR' , EMPLOYEE_PERFORMANCE_TRACKER_DIR . '/templates' );
        defined( 'EMPLOYEE_PERFORMANCE_TRACKER_PLUGIN_ASSET' ) || define( 'EMPLOYEE_PERFORMANCE_TRACKER_PLUGIN_ASSET' , plugins_url( 'assets', EMPLOYEE_PERFORMANCE_TRACKER_FILE ) );

        // give a way to turn off loading styles and scripts from parent theme
        defined( 'EMPLOYEE_PERFORMANCE_TRACKER_LOAD_STYLE' ) || define( 'EMPLOYEE_PERFORMANCE_TRACKER_LOAD_STYLE' , true );
        defined( 'EMPLOYEE_PERFORMANCE_TRACKER_LOAD_SCRIPTS' ) || define( 'EMPLOYEE_PERFORMANCE_TRACKER_LOAD_SCRIPTS' , true );
    }

    /**
     * Load the plugin after WP User Frontend is loaded
     *
     * @return void
     */
    public function init_plugin() {
        $this->includes();
        $this->init_hooks();

        do_action( 'employee_performance_tracker_loaded' );
    }

    /**
     * Initialize the actions
     *
     * @return void
     */
    public function init_hooks() {
        // initialize the classes
        add_action( 'init', [ $this, 'init_classes' ], 4 );
        add_action( 'plugins_loaded', [ $this, 'after_plugins_loaded' ] );
    }

    /**
     * Include all the required files
     *
     * @return void
     */
    public function includes() {
        // include_once STUB_PLUGIN_DIR . '/functions.php';
    }

    /**
     * Init all the classes
     *
     * @return void
     */
    public function init_classes() {
        $this->container['scripts'] = new Assets();
    }

    /**
     * Executed after all plugins are loaded
     *
     * At this point employee_performance_tracker Pro is loaded
     *
     * @since 2.8.7
     *
     * @return void
     */
    public function after_plugins_loaded() {
        // Initiate background processes and other tasks
    }

    /**
     * Check whether woocommerce is installed and active
     *
     * @since 2.9.16
     *
     * @return bool
     */
    public function has_woocommerce() {
        return class_exists( 'WooCommerce' );
    }

    /**
     * Check whether woocommerce is installed
     *
     * @since 3.2.8
     *
     * @return bool
     */
    public function is_woocommerce_installed() {
        return in_array( 'woocommerce/woocommerce.php', array_keys( get_plugins() ), true );
    }

    /**
	 * Get the plugin url.
	 *
	 * @return string
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', EMPLOYEE_PERFORMANCE_TRACKER_FILE ) );
	}

    /**
     * Get the template file path to require or include.
     *
     * @param string $name
     * @return string
     */
    public function get_template( $name ) {
        $template = untrailingslashit( EMPLOYEE_PERFORMANCE_TRACKER_TEMPLATE_DIR ) . '/' . untrailingslashit( $name );

        return apply_filters( 'employee-performance-tracker_template', $template, $name );
    }
}
