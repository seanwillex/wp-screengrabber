<?php
/**
 * Plugin Name: WP Screengrabber
 * Plugin URI: https://www.bomawilliams.com/wp-screengrabber
 * Description: A plugin to take screenshots of full websites (header to footer) or selected areas and save them as images.
 * Version: 1.0.0
 * Author: Boma N. Williams
 * Author URI: https://www.linkedin.com/in/boma-williams/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wp-screengrabber
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Define plugin constants
define('WP_SCREENGRABBER_VERSION', '1.0.0');
define('WP_SCREENGRABBER_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WP_SCREENGRABBER_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include the main WP_Screengrabber class
require_once WP_SCREENGRABBER_PLUGIN_DIR . 'includes/class-wp-screengrabber.php';

// Include the settings page
require_once WP_SCREENGRABBER_PLUGIN_DIR . 'admin/class-wp-screengrabber-settings.php';

// Begin execution of the plugin
function run_wp_screengrabber() {
    $plugin = new WP_Screengrabber();
    $plugin->run();

    // Initialize settings
    $settings = new WP_Screengrabber_Settings();
    $settings->init();
}
run_wp_screengrabber();