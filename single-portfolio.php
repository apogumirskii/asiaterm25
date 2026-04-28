<?php get_header();
include(locate_template('template-parts/menu.php'));
include(locate_template('template-parts/phead.php'));

while (have_posts()) : the_post();
    $current_id = get_the_ID();
    $gallery = rwmb_meta('portfolio_gallery', ['size' => 'costom-gallery'], $current_id);
    if (empty($gallery) && has_post_thumbnail($current_id)) {
        $thumb_id  = get_post_thumbnail_id($current_id);
        $gallery = [['ID' => $thumb_id, 'full_url' => wp_get_attachment_url($thumb_id), 'url' => wp_get_attachment_url($thumb_id)]];
    }
    $terms = get_the_terms($current_id, 'portfolio_category');
    $excerpt = get_the_excerpt();
    $portfolio_page = asiaterm_portfolio_page();
    $portfolio_url = $portfolio_page ? get_permalink($portfolio_page->ID) : home_url('/');
?>

<main>
<section id="project-page" class="py-4">
    <div class="container">
        <div class="row g-4 mb-5">
            <!-- Галерея -->
            <div class="col-lg-7">
                <?php include(locate_template('template-parts/product-gallery.php')); ?>
            </div>

            <!-- Информация -->
            <div class="col-lg-5">
                <h1 class="project-single-title mb-3"><?php the_title(); ?></h1>

                <?php if ($terms && !is_wp_error($terms)) : ?>
                <div class="project-categories mb-4">
                    <?php foreach ($terms as $term) : ?>
                        <span class="project-category-badge">
                            <i class="fas fa-folder-open me-1"></i><?php echo esc_html($term->name); ?>
                        </span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <?php if ($excerpt) : ?>
                <div class="project-excerpt mb-4">
                    <p><?php echo esc_html($excerpt); ?></p>
                </div>
                <?php endif; ?>

                <a href="<?php echo esc_url($portfolio_url); ?>" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-arrow-left me-2"></i>
                    <?php esc_html_e('Все проекты', 'asiaterm25'); ?>
                </a>
            </div>
        </div>

        <?php if (get_the_content()) : ?>
        <div class="project-description">
            <?php the_content(); ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php
// Товары, в которых указан этот проект
$related_products = new WP_Query([
    'post_type'      => 'page',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'meta_query'     => [
        [
            'key'     => 'prod_portfolio_pages',
            'value'   => $current_id,
            'compare' => 'LIKE',
        ],
    ],
]);

if ($related_products->have_posts()) : ?>
<section class="products-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-heading"><?php esc_html_e('Примеры оборудования — для похожих проектов', 'asiaterm25'); ?></h2>
        </div>

        <div class="position-relative">
            <div class="swiper swiper-products">
                <div class="swiper-wrapper">
                <?php while ($related_products->have_posts()) : $related_products->the_post();
                    $id         = get_the_ID();
                    $thumb      = get_the_post_thumbnail_url($id, 'medium_large');
                    $excerpt    = wp_trim_words(get_the_excerpt() ?: get_the_content(), 30);
                    $price      = rwmb_meta('prod_price', [], $id);
                    $var_titles = rwmb_meta('prod_var_titles', [], $id);
                    include(locate_template('blocks/product.php'));
                endwhile; wp_reset_postdata(); ?>
                </div>
            </div>

            <button class="products-nav products-prev"><i class="fas fa-chevron-left"></i></button>
            <button class="products-nav products-next"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>
</section>
<?php endif; ?>

</main>

<?php endwhile;

include(locate_template('page-top/ctasec.php'));
get_footer();
