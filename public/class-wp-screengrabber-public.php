<?php
class WP_Screengrabber_Public {
    public function enqueue_styles() {
        wp_enqueue_style('wp-screengrabber-public', WP_SCREENGRABBER_PLUGIN_URL . 'public/css/wp-screengrabber-public.css', array(), WP_SCREENGRABBER_VERSION, 'all');
    }

    public function enqueue_scripts() {
        wp_enqueue_script('html2canvas', WP_SCREENGRABBER_PLUGIN_URL . 'public/js/html2canvas.min.js', array(), '1.4.1', true);
        wp_enqueue_script('wp-screengrabber-public', WP_SCREENGRABBER_PLUGIN_URL . 'public/js/wp-screengrabber-public.js', array('jquery', 'html2canvas'), WP_SCREENGRABBER_VERSION, true);
    }

    public function render_floating_button() {
        echo '<div id="wp-screengrabber-button" class="wp-screengrabber-floating-button"><span class="dashicons dashicons-camera"></span></div>';
    }
}