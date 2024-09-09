<?php
/**
 * The admin-specific functionality of the plugin.
 */
class WP_Screengrabber_Admin {

    /**
     * Initialize the class and set its properties.
     */
    public function __construct() {
        // Constructor code
    }

    /**
     * Register the stylesheets for the admin area.
     */
    public function enqueue_styles() {
        wp_enqueue_style('wp-screengrabber-admin', WP_SCREENGRABBER_PLUGIN_URL . 'admin/css/wp-screengrabber-admin.css', array(), WP_SCREENGRABBER_VERSION, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     */
    public function enqueue_scripts() {
        wp_enqueue_script('wp-screengrabber-admin', WP_SCREENGRABBER_PLUGIN_URL . 'admin/js/wp-screengrabber-admin.js', array('jquery'), WP_SCREENGRABBER_VERSION, false);
    }
}