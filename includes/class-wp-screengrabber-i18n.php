<?php
/**
 * Define the internationalization functionality
 */
class WP_Screengrabber_i18n {

    /**
     * Load the plugin text domain for translation.
     */
    public function load_plugin_textdomain() {
        load_plugin_textdomain(
            'wp-screengrabber',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }
}