(function($) {
    'use strict';

    $(document).ready(function() {
        var settings = window.wpScreengrabberSettings || {};
        var button = $('<div id="wp-screengrabber-button" class="wp-screengrabber-floating-button"><span class="dashicons dashicons-camera"></span></div>');
        var modal = $('<div id="wp-screengrabber-modal" class="wp-screengrabber-modal">' +
            '<div class="wp-screengrabber-modal-content">' +
            '<h2>Take Screenshots with WP Screengrabber</h2>' +
            '<button id="wp-screengrabber-full-page">Full Webpage</button>' +
            '<button id="wp-screengrabber-selected-area">Selected Area</button>' +
            '<span class="wp-screengrabber-close">&times;</span>' +
            '</div></div>');
        
        // Apply button position
        button.addClass(settings.buttonPosition || 'bottom-right');
        
        $('body').append(button).append(modal);

        button.on('click', function() {
            modal.show();
        });

        $('.wp-screengrabber-close').on('click', function() {
            $(this).closest('.wp-screengrabber-modal').hide();
        });

        $('#wp-screengrabber-full-page').on('click', function() {
            modal.hide();
            captureFullPage();
        });

        $('#wp-screengrabber-selected-area').on('click', function() {
            modal.hide();
            captureSelectedArea();
        });

        function captureFullPage() {
            html2canvas(document.body, {
                useCORS: true,
                allowTaint: true,
                logging: false,
                scale: window.devicePixelRatio
            }).then(function(canvas) {
                saveAs(canvas.toDataURL(), 'screenshot.png');
            }).catch(function(error) {
                console.error('Full page capture failed:', error);
            });
        }

        function captureSelectedArea() {
            var selectionArea = $('<div class="wp-screengrabber-selection-area"></div>');
            var selection = $('<div class="wp-screengrabber-selection"></div>');
            selectionArea.append(selection);
            $('body').append(selectionArea);

            var startX, startY, endX, endY;
            var isSelecting = false;

            selectionArea.on('mousedown', function(e) {
                isSelecting = true;
                startX = e.clientX;
                startY = e.clientY;
                selection.css({
                    left: startX,
                    top: startY,
                    width: 0,
                    height: 0
                }).show();
            });

            $(document).on('mousemove', function(e) {
                if (!isSelecting) return;
                endX = e.clientX;
                endY = e.clientY;
                selection.css({
                    left: Math.min(startX, endX),
                    top: Math.min(startY, endY),
                    width: Math.abs(endX - startX),
                    height: Math.abs(endY - startY)
                });
            });

            $(document).on('mouseup', function() {
                if (!isSelecting) return;
                isSelecting = false;
                $(document).off('mousemove mouseup');

                var captureX = parseInt(selection.css('left')) + window.pageXOffset;
                var captureY = parseInt(selection.css('top')) + window.pageYOffset;
                var captureWidth = selection.width();
                var captureHeight = selection.height();

                html2canvas(document.documentElement, {
                    useCORS: true,
                    allowTaint: true,
                    logging: false,
                    scale: window.devicePixelRatio,
                    x: captureX,
                    y: captureY,
                    width: captureWidth,
                    height: captureHeight,
                    ignoreElements: function(element) {
                        return element.classList.contains('wp-screengrabber-selection-area');
                    }
                }).then(function(canvas) {
                    saveAs(canvas.toDataURL(), 'screenshot.png');
                    selectionArea.remove();
                }).catch(function(error) {
                    console.error('Selected area capture failed:', error);
                    selectionArea.remove();
                });
            });
        }

        function saveAs(uri, filename) {
            var link = document.createElement('a');
            if (typeof link.download === 'string') {
                link.href = uri;
                link.download = filename;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else {
                window.open(uri);
            }
        }
    });
})(jQuery);