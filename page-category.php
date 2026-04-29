<?php get_header(); /* Template Name: Category */
include(locate_template('template-parts/menu.php'));
include(locate_template('template-parts/phead.php'));
?>

<section id="category-page" class="py-5">
    <div class="container">

        <?php if (have_posts()) : the_post();
            $current_id  = get_the_ID();
            $icon        = rwmb_meta('prod_icon', [], $current_id);
            $var_titles  = rwmb_meta('prod_var_titles', [], $current_id);
            $shortdesc   = rwmb_meta('prod_cat_shortdesc', [], $current_id);
            $cat_features = rwmb_meta('prod_cat_features', [], $current_id);
            $gallery     = rwmb_meta('prod_service_gallery', ['size' => 'costom-gallery'], $current_id);
            $gallery_full = rwmb_meta('prod_service_gallery', ['size' => 'large'], $current_id);
            // Основное фото: первое из галереи в полном размере (не обрезано)
            $hero_img    = !empty($gallery_full) ? reset($gallery_full)['url'] : get_the_post_thumbnail_url($current_id, 'large');
        ?>

        <!-- Описание категории -->
        <div class="row g-5 align-items-center mb-5">
            <div class="col-lg-5">
                <?php if ($hero_img) : ?>
                    <div class="cat-hero-img mb-4">
                        <img src="<?php echo esc_url($hero_img); ?>" alt="<?php the_title_attribute(); ?>">
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-7">
                <?php if ($shortdesc) : ?>
                    <div class="company-text mb-4"><?php echo do_shortcode(wp_kses_post($shortdesc)); ?></div>
                <?php elseif (get_the_excerpt()) : ?>
                    <p class="company-text mb-4"><?php the_excerpt(); ?></p>
                <?php endif; ?>

                <?php if (get_the_content()) : ?>
                    <div class="cat-description mb-4">
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>

                <?php if ($var_titles) : ?>
                    <div class="cat-variations mt-3">
                        <h6 class="mb-3"><?php esc_html_e('Модификации', 'asiaterm25'); ?></h6>
                        <div class="d-flex flex-wrap gap-2">
                            <?php foreach ($var_titles as $var) : ?>
                                <span class="typesvar"><?php echo esc_html($var); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Иконки-преимущества -->
        <?php asiaterm_render_cat_features($current_id); ?>

        <!-- Галерея (пропускаем первое фото — оно в описании) -->
        <?php $gallery_rest = !empty($gallery) ? array_slice($gallery, 1) : []; ?>
        <?php if (!empty($gallery_rest)) : ?>
        <div class="mb-5">
            <div class="row g-3">
                <?php foreach ($gallery_rest as $img) : ?>
                <div class="col-lg-4 col-md-6">
                    <a href="<?php echo esc_url(asiaterm_webp_url_swap($img['full_url'])); ?>" data-lightbox="cat-gallery" data-title="<?php echo esc_attr($img['alt'] ?: ''); ?>">
                        <div class="cat-hero-img cat-hero-img--thumb" style="height: 250px;">
                            <img src="<?php echo esc_url(asiaterm_webp_url_swap($img['url'])); ?>" loading="lazy" alt="<?php echo esc_attr($img['alt'] ?: ''); ?>">
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Товары -->
        <?php
        $products = new WP_Query([
            'post_type'      => 'page',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'post_parent'    => $current_id,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        ]);
        ?>

        <?php if ($products->have_posts()) : ?>
        <div class="mb-5">
            <h3 class="section-heading mb-4"><?php esc_html_e('Продукция', 'asiaterm25'); ?></h3>
            <div class="position-relative">
                <div class="swiper swiper-products">
                    <div class="swiper-wrapper">
                    <?php while ($products->have_posts()) : $products->the_post();
                        $id         = get_the_ID();
                        $thumb      = get_the_post_thumbnail_url($id, 'medium_large');
                        $excerpt    = wp_trim_words(get_the_excerpt() ?: get_the_content(), 20);
                        $price      = rwmb_meta('prod_price', [], $id);
                        $var_titles = rwmb_meta('prod_var_titles', [], $id);
                    ?>
                        <?php include locate_template('blocks/product.php'); ?>
                    <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                </div>

                <button class="products-nav products-prev"><i class="fas fa-chevron-left"></i></button>
                <button class="products-nav products-next"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
        <?php else : ?>
            <p class="text-muted"><?php esc_html_e('Товары не найдены.', 'asiaterm25'); ?></p>
        <?php endif; ?>

        <?php endif; ?>

    </div>
</section>

<?php
include locate_template('page-top/ctasec.php');
get_footer();
