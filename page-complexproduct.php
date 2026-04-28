<?php /* Template Name: Complex product */ get_header();
include(locate_template('template-parts/menu.php'));
include(locate_template('template-parts/phead.php'));
?>

<section id="product" class="py-2">
    <div class="container">
        <?php while (have_posts()) : the_post();
            $gallery   = rwmb_meta('prod_service_gallery', ['object_type' => 'post'], get_the_ID());
            $shortdesc = rwmb_meta('prod_shortdesc');
            $var_titles = rwmb_meta('prod_var_titles');
        ?>

        <div class="row g-4 mb-5">
            <div class="col-lg-6">
                <?php include(locate_template('template-parts/product-gallery.php')); ?>
            </div>
            <?php include(locate_template('template-parts/product-header.php')); ?>
        </div>

        <?php
        $child_products = get_pages([
            'parent'      => get_the_ID(),
            'post_status' => 'publish',
            'sort_column' => 'menu_order',
        ]);
        asiaterm_prime_thumbnails( $child_products );
        ?>

        <?php if ($child_products) : ?>
        <div class="child-products-section mb-5">
            <h2 class="section-heading mb-4"><?php esc_html_e('Модели', 'asiaterm25'); ?></h2>
            <div class="row g-4">
                <?php foreach ($child_products as $child_product) :
                    $id         = $child_product->ID;
                    $thumb      = get_the_post_thumbnail_url($id, 'medium_large');
                    $excerpt    = wp_trim_words($child_product->post_excerpt ?: $child_product->post_content, 20);
                    $price      = rwmb_meta('prod_price', [], $id);
                    $var_titles = rwmb_meta('prod_var_titles', [], $id);
                ?>
                    <div class="col-lg-3 col-md-6">
                        <div class="product-card h-100">
                            <div class="product-card-img">
                                <a href="<?php echo esc_url(get_permalink($id)); ?>">
                                    <?php if ($thumb) : ?>
                                        <img src="<?php echo esc_url($thumb); ?>" loading="lazy" alt="<?php echo esc_attr($child_product->post_title); ?>">
                                    <?php else : ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/img/placeholder.jpg" alt="">
                                    <?php endif; ?>
                                </a>
                            </div>
                            <div class="product-card-body text-center d-flex flex-column">
                                <a href="<?php echo esc_url(get_permalink($id)); ?>" class="product-card-title">
                                    <h5><?php echo esc_html($child_product->post_title); ?></h5>
                                </a>
                                <?php if ($excerpt) : ?>
                                    <p class="product-card-desc"><?php echo esc_html($excerpt); ?></p>
                                <?php endif; ?>
                                <?php if ($price) : ?>
                                    <div class="product-card-price">от <?php echo esc_html($price); ?> $</div>
                                <?php endif; ?>
                                <?php if ($var_titles) : ?>
                                    <div class="product-card-vars mb-3">
                                        <?php foreach ($var_titles as $var) : ?>
                                            <span class="typesvar"><?php echo esc_html($var); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                <div class="mt-auto pt-3">
                                    <a href="<?php echo esc_url(get_permalink($id)); ?>" class="btn product-card-btn w-100">
                                        <?php esc_html_e('Подробнее', 'asiaterm25'); ?> <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Иконки-преимущества -->
        <?php
        $cat_features = rwmb_meta('prod_cat_features');
        $features_list = $cat_features ?: [
            ['feature_icon' => [], 'feature_fa' => 'fas fa-check-circle',  'feature_title' => 'Сертификация',  'feature_desc' => 'Всё оборудование сертифицировано и соответствует международным стандартам'],
            ['feature_icon' => [], 'feature_fa' => 'fas fa-shield-alt',    'feature_title' => 'Гарантия',      'feature_desc' => 'Официальная гарантия производителя на все модели'],
            ['feature_icon' => [], 'feature_fa' => 'fas fa-tools',         'feature_title' => 'Монтаж',        'feature_desc' => 'Профессиональный монтаж и пуско-наладка оборудования'],
            ['feature_icon' => [], 'feature_fa' => 'fas fa-headset',       'feature_title' => 'Поддержка',     'feature_desc' => 'Техническая консультация и сервисное обслуживание'],
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

        <?php if (get_the_content()) : ?>
        <div class="product-full-desc mb-5">
            <?php echo apply_filters('the_content', get_the_content()); ?>
        </div>
        <?php endif; ?>

        <?php endwhile; ?>
    </div>
</section>

<?php
include(locate_template('page-top/ctasec.php'));
get_footer();
?>
