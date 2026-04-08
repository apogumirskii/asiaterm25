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
        <div class="text-center mb-4">
            <h6 class="section-subheading"><?php esc_html_e('Партнёры', 'asiaterm25'); ?></h6>
            <h2 class="section-heading"><?php esc_html_e('Наши партнёры', 'asiaterm25'); ?></h2>
        </div>
        <?php include locate_template('template-parts/partners-carousel.php'); ?>
    </div>
</section>
