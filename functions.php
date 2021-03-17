<?php
    function load_uni_scripts() {
        wp_enqueue_style('university_main_styles', get_stylesheet_uri());
    }

    add_action('wp_enqueue_scripts', 'load_uni_scripts');
?>