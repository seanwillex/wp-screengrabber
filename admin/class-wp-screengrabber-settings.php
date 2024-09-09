<?php
class WP_Screengrabber_Settings {
    public function init() {
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('wp_footer', array($this, 'apply_frontend_settings'));
    }

    public function add_settings_page() {
        add_options_page(
            'WP Screengrabber Settings',
            'WP Screengrabber',
            'manage_options',
            'wp-screengrabber-settings',
            array($this, 'render_settings_page')
        );
    }

    public function register_settings() {
        register_setting('wp_screengrabber_options', 'wp_screengrabber_button_color');
        register_setting('wp_screengrabber_options', 'wp_screengrabber_button_position');
        register_setting('wp_screengrabber_options', 'wp_screengrabber_button_opacity');

        add_settings_section(
            'wp_screengrabber_general',
            'General Settings',
            array($this, 'render_section_info'),
            'wp-screengrabber-settings'
        );

        add_settings_field(
            'wp_screengrabber_button_color',
            'Button Color',
            array($this, 'render_button_color_field'),
            'wp-screengrabber-settings',
            'wp_screengrabber_general'
        );

        add_settings_field(
            'wp_screengrabber_button_position',
            'Button Position',
            array($this, 'render_button_position_field'),
            'wp-screengrabber-settings',
            'wp_screengrabber_general'
        );

        add_settings_field(
            'wp_screengrabber_button_opacity',
            'Button Opacity',
            array($this, 'render_button_opacity_field'),
            'wp-screengrabber-settings',
            'wp_screengrabber_general'
        );
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1>WP Screengrabber Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('wp_screengrabber_options');
                do_settings_sections('wp-screengrabber-settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function render_section_info() {
        echo 'Configure the WP Screengrabber plugin settings below:';
    }

    public function render_button_color_field() {
        $color = get_option('wp_screengrabber_button_color', '#0073aa');
        echo "<input type='color' name='wp_screengrabber_button_color' value='{$color}' />";
    }

    public function render_button_position_field() {
        $position = get_option('wp_screengrabber_button_position', 'bottom-right');
        $options = array(
            'top-left' => 'Top Left',
            'top-right' => 'Top Right',
            'bottom-left' => 'Bottom Left',
            'bottom-right' => 'Bottom Right'
        );
        echo "<select name='wp_screengrabber_button_position'>";
        foreach ($options as $value => $label) {
            $selected = ($position === $value) ? 'selected' : '';
            echo "<option value='{$value}' {$selected}>{$label}</option>";
        }
        echo "</select>";
    }

    public function render_button_opacity_field() {
        $opacity = get_option('wp_screengrabber_button_opacity', '70');
        echo "<input type='range' name='wp_screengrabber_button_opacity' min='0' max='100' step='1' value='{$opacity}' />";
        echo "<span id='opacity-value'>{$opacity}%</span>";
        echo "<script>
            jQuery(document).ready(function($) {
                $('input[name=\"wp_screengrabber_button_opacity\"]').on('input', function() {
                    $('#opacity-value').text($(this).val() + '%');
                });
            });
        </script>";
    }

    public function apply_frontend_settings() {
        $color = get_option('wp_screengrabber_button_color', '#0073aa');
        $position = get_option('wp_screengrabber_button_position', 'bottom-right');
        $opacity = get_option('wp_screengrabber_button_opacity', '70');

        $opacity_decimal = $opacity / 100;

        echo "<style>
            .wp-screengrabber-floating-button {
                background-color: {$color} !important;
                opacity: {$opacity_decimal} !important;
            }
        </style>";

        echo "<script>
            var wpScreengrabberSettings = {
                buttonPosition: '{$position}'
            };
        </script>";
    }
}