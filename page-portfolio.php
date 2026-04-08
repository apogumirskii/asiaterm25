<?php get_header(); /* Template Name: Portfolio */
include(locate_template('template-parts/menu.php'));
include(locate_template('template-parts/phead.php'));

$portfolio_query = new WP_Query([
    'post_type'      => 'portfolio',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order date',
    'order'          => 'ASC',
]);

if ($portfolio_query->have_posts()) :
    // Собираем категории
    $all_cats = [];
    $items = [];
    while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
        $pid = get_the_ID();
        $terms = get_the_terms($pid, 'portfolio_category');
        $cat_slugs = [];
        if ($terms && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                $all_cats[$term->slug] = $term->name;
                $cat_slugs[] = $term->slug;
            }
        }
        $gallery = rwmb_meta('portfolio_gallery', ['object_type' => 'post'], $pid);
        $items[] = [
            'id'      => $pid,
            'title'   => get_the_title(),
            'excerpt' => get_the_excerpt(),
            'thumb'   => get_the_post_thumbnail_url($pid, 'costom-gallery')
                         ?: ($gallery ? reset($gallery)['full_url'] : get_template_directory_uri() . '/files/topimg2.png'),
            'url'     => get_permalink(),
            'cats'    => implode(' ', $cat_slugs),
        ];
    endwhile;
    wp_reset_postdata();
    asort($all_cats);
?>

<section id="portfolio-page" class="py-5">
    <div class="container">

        <?php if ($all_cats) : ?>
        <div class="portfolio-filters text-center mb-5">
            <button class="portfolio-filter-btn active" data-filter="*"><?php esc_html_e('Все', 'asiaterm25'); ?></button>
            <?php foreach ($all_cats as $slug => $name) : ?>
                <button class="portfolio-filter-btn" data-filter="<?php echo esc_attr($slug); ?>"><?php echo esc_html($name); ?></button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="row g-4" id="portfolioGrid">
            <?php foreach ($items as $port) : ?>
                <div class="col-lg-4 col-md-6 portfolio-item" data-cats="<?php echo esc_attr($port['cats']); ?>">
                    <a href="<?php echo esc_url($port['url']); ?>" class="portfolio-card text-decoration-none d-block">
                        <div class="portfolio-card-img">
                            <img src="<?php echo esc_url($port['thumb']); ?>" loading="lazy" alt="<?php echo esc_attr($port['title']); ?>">
                            <div class="portfolio-card-overlay">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                        <div class="portfolio-card-body">
                            <h5 class="portfolio-card-title"><?php echo esc_html($port['title']); ?></h5>
                            <?php if ($port['excerpt']) : ?>
                                <p class="portfolio-card-desc"><?php echo esc_html($port['excerpt']); ?></p>
                            <?php endif; ?>
                            <span class="portfolio-card-link">
                                <?php esc_html_e('Подробнее', 'asiaterm25'); ?> <i class="fas fa-arrow-right ms-1"></i>
                            </span>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<?php else : ?>

<section class="py-5">
    <div class="container text-center">
        <i class="fas fa-images fa-3x mb-3" style="color: var(--color-primary); opacity: 0.3;"></i>
        <p class="text-muted"><?php esc_html_e('Проекты появятся здесь после добавления записей в раздел «Портфолио».', 'asiaterm25'); ?></p>
    </div>
</section>

<?php endif; ?>

<?php
include(locate_template('page-top/ctasec.php'));
get_footer();
