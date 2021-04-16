<?php
    /* ENQUEUE SCRIPTS */
    function load_uni_scripts() {
        // wp_enqueue_style('css-university-main', get_stylesheet_uri());
        wp_enqueue_style('css-slick-slider', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
        wp_enqueue_style('font-Roboto', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
        wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        // wp_enqueue_script('js-university-main', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', TRUE);
        
        wp_enqueue_script('js-google-map', '//maps.googleapis.com/maps/api/js?key=AIzaSyDOnwY23gch30v--QxjmutKQYphlRM4z6w', NULL, '1.0', TRUE);
        
        if(strstr($_SERVER['SERVER_NAME'], 'fakeuniversity.local')) {
            wp_enqueue_script('js-university-main', 'http://localhost:3000/bundled.js', NULL, '1.0', TRUE);
        } else {
            wp_enqueue_script('our-vendors-js', get_theme_file_uri('/bundled-assets/vendors~scripts.8c97d901916ad616a264.js'), NULL, '1.0', TRUE);
            wp_enqueue_script('js-university-main', get_theme_file_uri('/bundled-assets/scripts.dd709b99cbc63c91368b.js'), NULL, '1.0', TRUE);
            wp_enqueue_style('css-university-main', get_stylesheet_uri('/bundled-assets/styles.dd709b99cbc63c91368b.css'));
        }

        wp_enqueue_script('js-jQuery-load1', '//code.jquery.com/jquery-1.11.0.min.js', NULL, '1.11.0', TRUE);
        wp_enqueue_script('js-jQuery-load2', '//code.jquery.com/jquery-migrate-1.2.1.min.js', NULL, '1.2.1', TRUE);

        wp_enqueue_script('js-slick-slider', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', NULL, '1.8.1', TRUE);
        wp_enqueue_script('js-mac-custom-scripts', get_theme_file_uri('/js/mac-custom-scripts.js'), NULL, '1.0', TRUE);
    }
    add_action('wp_enqueue_scripts', 'load_uni_scripts');

    /* ADD THEME SUPPORT */
    function university_features() {
        register_nav_menu('headerMenuLoc', 'Header Menu Location');
        register_nav_menu('footerLoc1', 'Footer Location 1');
        register_nav_menu('footerLoc2', 'Footer Location 2');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        // Prof Img Size
        add_image_size('profLandscape', 400, 260, true);
        add_image_size('profPortrait', 480, 650, true);
        add_image_size('pageBanner', 1500, 350, true);
    }
    add_action('after_setup_theme', 'university_features');

    function university_adjust_queries($query) {
        // make changes to the default queries that WP runs
        
        // NOT wp-admin
        if(!is_admin()) {

            // NO custom queries
            if($query->is_main_query()) {

                // EVENT post type -- query on /events
                if(is_post_type_archive('event')) {
                    $today = date('Ymd');
                    $query->set('meta_key', 'event_date');
                    $query->set('orderby', 'meta_value_num');
                    $query->set('order', 'ASC');
                    $query->set('meta_query', array(
                        array(
                            'key' => 'event_date', 
                            'compare' => '>=', 
                            'value' => $today, 
                            'type' => 'numeric'
                        )
                    ));
                }
                
                // PROGRAM post type -- query on /programs
                if(is_post_type_archive('program')) {
                    $query->set('orderby', 'title');
                    $query->set('order', 'ASC');
                    $query->set('posts_per_page', -1);
                }

                // PROGRAM post type -- query on /campuses
                if(is_post_type_archive('campus')) {
                    $query->set('posts_per_page', -1);
                }
            }
        }
    }
    add_action('pre_get_posts', 'university_adjust_queries');

    /* PAGE BANNER */
    function pageBanner($args = NULL) {
        /* SET DEFAULT TITLE VALUE */
        $title = $args['title'];
        if (!$title) { $title = get_the_title(); }

        /* SET DEFAULT SUBTITLE VALUE */
        $subtitle = $args['subtitle'];
        if (!$subtitle) { $subtitle = get_field('page_banner_subtitle'); }

        /* SET DEFAULT BG IMG URL */
        $img = $args['img'];
        if (!$img) { 
            if (get_field('page_banner_background_image') AND !is_archive() AND !is_home() ) {
                $img = get_field('page_banner_background_image')['sizes']['pageBanner']; 
            } else {
                $img = get_theme_file_uri('/images/ocean.jpg');
            }
        }
        
        ?>
        <div class="page-banner">
            <div class="page-banner__bg-image" style="background-image: url(<?php echo $img; ?>);"></div>
            <div class="page-banner__content container container--narrow">
                <h1 class="page-banner__title"><?php echo $title; ?></h1>
                <div class="page-banner__intro">
                    <p><?php echo $subtitle; ?></p>
                </div>
            </div>  
        </div>
    <?php }


function university_map_api_key($api) {
    $api['key'] = 'AIzaSyDOnwY23gch30v--QxjmutKQYphlRM4z6w';
    return $api;
}
add_filter('acf/fields/google_map/api', 'university_map_api_key');

?>