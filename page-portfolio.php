<?php get_header(); /* Template Name: Portfolio */
include(locate_template('template-parts/menu.php'));
include(locate_template('template-parts/phead.php'));
?>

<?php if (have_posts()) : the_post();
    $current_id = get_the_ID();
    $children   = get_pages([
        'parent'      => $current_id,
        'post_status' => 'publish',
        'sort_column' => 'menu_order',
    ]);
?>

<?php if ($children) :
    // Собираем категории всех проектов
    $all_cats = [];
    $children_data = [];
    foreach ($children as $port) {
        $port_id = $port->ID;
        $terms = wp_get_object_terms($port_id, 'prod_category', ['fields' => 'all']);
        $cat_slugs = [];
        if (!is_wp_error($terms) && $terms) {
            foreach ($terms as $term) {
                $all_cats[$term->slug] = $term->name;
                $cat_slugs[] = $term->slug;
            }
        }
        $gallery = rwmb_meta('prod_service_gallery', ['object_type' => 'post'], $port_id);
        $children_data[] = [
            'id'       => $port_id,
            'title'    => $port->post_title,
            'excerpt'  => $port->post_excerpt,
            'thumb'    => get_the_post_thumbnail_url($port_id, 'costom-gallery')
                          ?: ($gallery ? reset($gallery)['full_url'] : get_template_directory_uri() . '/files/topimg2.png'),
            'url'      => get_permalink($port_id),
            'cats'     => implode(' ', $cat_slugs),
        ];
    }
    asort($all_cats);
?>

    <section id="portfolio-page" class="py-5">
        <div class="container">

            <?php if (get_the_excerpt()) : ?>
            <div class="text-center mb-5">
                <p class="company-text mx-auto" style="max-width: 40rem;"><?php the_excerpt(); ?></p>
            </div>
            <?php endif; ?>

            <?php if ($all_cats) : ?>
            <div class="portfolio-filters text-center mb-5">
                <button class="portfolio-filter-btn active" data-filter="*"><?php esc_html_e('Все', 'asiaterm25'); ?></button>
                <?php foreach ($all_cats as $slug => $name) : ?>
                    <button class="portfolio-filter-btn" data-filter="<?php echo esc_attr($slug); ?>"><?php echo esc_html($name); ?></button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <div class="row g-4" id="portfolioGrid">
                <?php foreach ($children_data as $port) : ?>
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

            <?php if (get_the_content()) : ?>
                <div class="project-description mt-5 pt-4 border-top">
                    <?php the_content(); ?>
                </div>
            <?php endif; ?>

        </div>
    </section>

<?php else : ?>

    <?php
    $gallery  = rwmb_meta('prod_service_gallery', ['object_type' => 'post'], $current_id);
    $gallery2 = rwmb_meta('prod_service_gallery2', ['object_type' => 'post'], $current_id);
    $all_images = array_values(array_filter(array_merge($gallery ?: [], $gallery2 ?: [])));
    // Fallback: featured image
    if (empty($all_images) && has_post_thumbnail($current_id)) {
        $thumb_id  = get_post_thumbnail_id($current_id);
        $thumb_url = wp_get_attachment_url($thumb_id);
        $all_images = [['ID' => $thumb_id, 'full_url' => $thumb_url, 'url' => $thumb_url, 'sizes' => []]];
    }
    ?>

    <section id="project-page" class="py-5">
        <div class="container">

            <?php if ($all_images) : ?>
            <div class="project-gallery mb-5">
                <div class="project-gallery-main mb-3">
                    <a href="<?php echo esc_url($all_images[0]['full_url'] ?? $all_images[0]['url']); ?>" data-lightbox="project-gallery">
                        <img src="<?php echo esc_url($all_images[0]['full_url'] ?? $all_images[0]['url']); ?>"
                             id="projectMainImg"
                             alt="<?php the_title_attribute(); ?>">
                    </a>
                </div>

                <?php if (count($all_images) > 1) : ?>
                <div class="project-gallery-thumbs">
                    <?php foreach ($all_images as $i => $img) :
                        $thumb_src = '';
                        if (!empty($img['sizes']['thumbnail'])) {
                            $thumb_src = $img['sizes']['thumbnail'];
                        } elseif (!empty($img['ID'])) {
                            $thumb_arr = wp_get_attachment_image_src($img['ID'], 'thumbnail');
                            $thumb_src = $thumb_arr ? $thumb_arr[0] : '';
                        }
                        if (!$thumb_src) {
                            $thumb_src = $img['full_url'] ?? $img['url'] ?? '';
                        }
                    ?>
                        <div class="project-thumb <?php echo $i === 0 ? 'active' : ''; ?>"
                             data-src="<?php echo esc_url($img['full_url'] ?? $img['url']); ?>">
                            <img src="<?php echo esc_url($thumb_src); ?>" loading="lazy" alt="">
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if (get_the_content()) : ?>
            <div class="project-description">
                <?php the_content(); ?>
            </div>
            <?php endif; ?>

        </div>
    </section>

<?php endif; ?>

<?php endif; ?>

<?php
include locate_template('page-top/ctasec.php');
get_footer();
?>
