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
            // Основное фото: первое из галереи, или миниатюра записи
            $hero_img    = !empty($gallery) ? reset($gallery)['url'] : get_the_post_thumbnail_url($current_id, 'large');
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
        <?php
        $features_list = $cat_features ?: [
            ['feature_icon' => [], 'feature_fa' => 'fas fa-check-circle',  'feature_title' => 'Сертификация',         'feature_desc' => 'Всё оборудование сертифицировано и соответствует международным стандартам'],
            ['feature_icon' => [], 'feature_fa' => 'fas fa-shield-alt',    'feature_title' => 'Гарантия',             'feature_desc' => 'Официальная гарантия производителя на все модели'],
            ['feature_icon' => [], 'feature_fa' => 'fas fa-tools',         'feature_title' => 'Монтаж',               'feature_desc' => 'Профессиональный монтаж и пуско-наладка оборудования'],
            ['feature_icon' => [], 'feature_fa' => 'fas fa-headset',       'feature_title' => 'Поддержка',            'feature_desc' => 'Техническая консультация и сервисное обслуживание'],
        ];
        ?>
        <div class="cat-features mb-5">
            <div class="row g-0">
                <?php foreach ($features_list as $feature) :
                    $f_icon  = !empty($feature['feature_icon']) ? reset($feature['feature_icon']) : null;
                    $f_fa    = $feature['feature_fa'] ?? '';
                    $f_title = $feature['feature_title'] ?? '';
                    $f_desc  = $feature['feature_desc'] ?? '';
                ?>
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="cat-feature-item">
                        <?php if ($f_icon && !empty($f_icon['url'])) : ?>
                            <div class="cat-feature-icon">
                                <img src="<?php echo esc_url($f_icon['url']); ?>" alt="<?php echo esc_attr($f_title); ?>" loading="lazy">
                            </div>
                        <?php elseif ($f_fa) : ?>
                            <div class="cat-feature-icon">
                                <i class="<?php echo esc_attr($f_fa); ?>" style="font-size: 2rem; color: var(--color-white);"></i>
                            </div>
                        <?php endif; ?>
                        <?php if ($f_title) : ?>
                            <h6 class="cat-feature-title"><?php echo esc_html($f_title); ?></h6>
                        <?php endif; ?>
                        <?php if ($f_desc) : ?>
                            <p class="cat-feature-desc"><?php echo esc_html($f_desc); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Галерея (пропускаем первое фото — оно в описании) -->
        <?php $gallery_rest = !empty($gallery) ? array_slice($gallery, 1) : []; ?>
        <?php if (!empty($gallery_rest)) : ?>
        <div class="mb-5">
            <div class="row g-3">
                <?php foreach ($gallery_rest as $img) : ?>
                <div class="col-lg-4 col-md-6">
                    <a href="<?php echo esc_url(asiaterm_webp_url_swap($img['full_url'])); ?>" data-lightbox="cat-gallery" data-title="<?php echo esc_attr($img['alt'] ?: ''); ?>">
                        <div class="cat-hero-img" style="height: 250px;">
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
