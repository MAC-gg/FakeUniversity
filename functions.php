<?php
    function load_uni_scripts() {
        wp_enqueue_style('css-university-main', get_stylesheet_uri());
        wp_enqueue_style('css-slick-slider', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
        wp_enqueue_style('font-Roboto', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
        wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

        wp_enqueue_script('js-jQuery-load1', '//code.jquery.com/jquery-1.11.0.min.js', NULL, '1.11.0', TRUE);
        wp_enqueue_script('js-jQuery-load2', '//code.jquery.com/jquery-migrate-1.2.1.min.js', NULL, '1.2.1', TRUE);

        wp_enqueue_script('js-university-main', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', TRUE);
        wp_enqueue_script('js-slick-slider', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', NULL, '1.8.1', TRUE);
        wp_enqueue_script('js-mac-custom-scripts', get_theme_file_uri('/js/mac-custom-scripts.js'), NULL, '1.0', TRUE);
    }

    add_action('wp_enqueue_scripts', 'load_uni_scripts');
?>