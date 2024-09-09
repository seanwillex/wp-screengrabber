<?php
/**
 * The main plugin class
 */
class WP_Screengrabber {

    /**
     * Initialize the plugin
     */
    public function __construct() {
        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     */
    private function load_dependencies() {
        require_once WP_SCREENGRABBER_PLUGIN_DIR . 'includes/class-wp-screengrabber-i18n.php';
        require_once WP_SCREENGRABBER_PLUGIN_DIR . 'admin/class-wp-screengrabber-admin.php';
        require_once WP_SCREENGRABBER_PLUGIN_DIR . 'public/class-wp-screengrabber-public.php';
    }

    /**
     * Define the locale for this plugin for internationalization.
     */
    private function set_locale() {
        $plugin_i18n = new WP_Screengrabber_i18n();
        add_action('plugins_loaded', array($plugin_i18n, 'load_plugin_textdomain'));
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     */
    private function define_admin_hooks() {
        $plugin_admin = new WP_Screengrabber_Admin();
        add_action('admin_enqueue_scripts', array($plugin_admin, 'enqueue_styles'));
        add_action('admin_enqueue_scripts', array($plugin_admin, 'enqueue_scripts'));
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     */
    private function define_public_hooks() {
        $plugin_public = new WP_Screengrabber_Public();
        add_action('wp_enqueue_scripts', array($plugin_public, 'enqueue_styles'));
        add_action('wp_enqueue_scripts', array($plugin_public, 'enqueue_scripts'));
        add_action('wp_footer', array($plugin_public, 'render_floating_button'));
    }

    /**
     * Run the plugin.
     */
    public function run() {
        // Plugin execution code goes here
    }
}