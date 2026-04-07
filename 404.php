<?php
get_header();

include(locate_template('template-parts/menu.php'));?>

<div class="error-404 not-found">
    <h1><?php esc_html_e( 'Oops! That page can’t be found.', 'my-wordpress-theme' ); ?></h1>
    <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'my-wordpress-theme' ); ?></p>
    <?php get_search_form(); ?>
</div>

<?php 

get_footer();
