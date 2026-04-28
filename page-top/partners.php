<?php
// Находим страницу с шаблоном "Партнёрам" и берём логотипы оттуда
$partners_page = get_posts([
    'post_type'      => 'page',
    'post_status'    => 'publish',
    'posts_per_page' => 1,
    'meta_key'       => '_wp_page_template',
    'meta_value'     => 'page-partners.php',
]);
$partner_logos = $partners_page ? rwmb_meta('partners_logos', ['size' => 'medium'], $partners_page[0]->ID) : [];
?>

<section class="py-5">
    <div class="container">
        <?php asiaterm_section_heading( __( 'Партнёры', 'asiaterm25' ), __( 'Наши партнёры', 'asiaterm25' ) ); ?>
        <?php include locate_template('template-parts/partners-carousel.php'); ?>
    </div>
</section>
