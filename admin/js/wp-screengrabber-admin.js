(function($) {
    'use strict';

    $(document).ready(function() {
        // Initialize color picker
        if ($.fn.wpColorPicker) {
            $('.wp-screengrabber-color-picker').wpColorPicker();
        }

        // Handle form submission
        $('#wp-screengrabber-admin-form').on('submit', function(e) {
            e.preventDefault();
            
            var formData = $(this).serialize();
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'wp_screengrabber_save_settings',
                    nonce: wp_screengrabber_admin.nonce,
                    formData: formData
                },
                success: function(response) {
                    if (response.success) {
                        alert('Settings saved successfully!');
                    } else {
                        alert('Error saving settings. Please try again.');
                    }
                },
                error: function() {
                    alert('An error occurred. Please try again.');
                }
            });
        });

        // Toggle advanced settings
        $('#wp-screengrabber-toggle-advanced').on('click', function(e) {
            e.preventDefault();
            $('.wp-screengrabber-advanced-settings').toggle();
            $(this).text(function(i, text) {
                return text === "Show Advanced Settings" ? "Hide Advanced Settings" : "Show Advanced Settings";
            });
        });

        // Preview button position
        $('#wp-screengrabber-button-position').on('change', function() {
            var position = $(this).val();
            var previewButton = $('#wp-screengrabber-preview-button');
            
            previewButton.removeClass('top-left top-right bottom-left bottom-right');
            previewButton.addClass(position);
        });
    });

})(jQuery);