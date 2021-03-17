<?php
    get_header(); // grabs Header.php

    while(have_posts()) {
        the_post(); ?>
        <h2><?php the_title(); ?></h2>
        <?php the_content(); ?>
    <?php }

    get_footer(); // grabs Footer.php
?>