<?php

/**
 * Шапка секции главной/каталога: subheading + heading.
 * Используется в page-top/popular.php, news.php, cattop.php и подобных.
 */
function asiaterm_section_heading( $subheading, $heading ) {
    if ( ! $subheading && ! $heading ) return;
    ?>
    <div class="text-center mb-5">
        <?php if ( $subheading ) : ?>
            <h6 class="section-subheading"><?php echo esc_html( $subheading ); ?></h6>
        <?php endif; ?>
        <?php if ( $heading ) : ?>
            <h2 class="section-heading"><?php echo esc_html( $heading ); ?></h2>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Карточка товара в Swiper-карусели.
 * Ожидает $id, $thumb, $excerpt, $price, $var_titles в локальной области видимости — стандартный контракт blocks/product.php.
 */
function asiaterm_render_product_card( $id ) {
    $thumb      = get_the_post_thumbnail_url( $id, 'medium_large' );
    $title      = get_the_title( $id );
    $excerpt    = wp_trim_words( get_the_excerpt( $id ) ?: get_post_field( 'post_content', $id ), 30 );
    $price      = rwmb_meta( 'prod_price', [], $id );
    $var_titles = rwmb_meta( 'prod_var_titles', [], $id );
    $permalink  = get_permalink( $id );
    ?>
    <div class="swiper-slide">
        <div class="product-card">
            <div class="product-card-img">
                <a href="<?php echo esc_url( $permalink ); ?>">
                    <?php if ( $thumb ) : ?>
                        <img src="<?php echo esc_url( $thumb ); ?>" loading="lazy" alt="<?php echo esc_attr( $title ); ?>">
                    <?php else : ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/img/placeholder.jpg" alt="">
                    <?php endif; ?>
                </a>
            </div>
            <div class="product-card-body text-center">
                <a href="<?php echo esc_url( $permalink ); ?>" class="product-card-title">
                    <h5><?php echo esc_html( $title ); ?></h5>
                </a>
                <?php if ( $excerpt ) : ?>
                    <p class="product-card-desc"><?php echo esc_html( $excerpt ); ?></p>
                <?php endif; ?>
                <div class="product-card-price"></div>
                <?php if ( $var_titles ) : ?>
                    <div class="product-card-vars mb-3">
                        <?php foreach ( $var_titles as $var ) : ?>
                            <span class="typesvar"><?php echo esc_html( $var ); ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <a href="<?php echo esc_url( $permalink ); ?>" class="btn product-card-btn">
                    <?php esc_html_e( 'Подробнее', 'asiaterm25' ); ?> <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Получить иконки-преимущества с fallback:
 * 1) текущая страница → 2) родитель → 3) дефолты.
 */
function asiaterm_get_cat_features( $post_id = null ) {
    $post_id = $post_id ?: get_the_ID();
    $features = rwmb_meta( 'prod_cat_features', [], $post_id );
    if ( $features ) return $features;

    $parent_id = wp_get_post_parent_id( $post_id );
    while ( $parent_id ) {
        $parent_features = rwmb_meta( 'prod_cat_features', [], $parent_id );
        if ( $parent_features ) return $parent_features;
        $parent_id = wp_get_post_parent_id( $parent_id );
    }

    return [
        ['feature_icon' => [], 'feature_fa' => 'fas fa-check-circle', 'feature_title' => 'Сертификация', 'feature_desc' => 'Всё оборудование сертифицировано и соответствует международным стандартам'],
        ['feature_icon' => [], 'feature_fa' => 'fas fa-shield-alt',   'feature_title' => 'Гарантия',     'feature_desc' => 'Официальная гарантия производителя на все модели'],
        ['feature_icon' => [], 'feature_fa' => 'fas fa-tools',        'feature_title' => 'Монтаж',       'feature_desc' => 'Профессиональный монтаж и пуско-наладка оборудования'],
        ['feature_icon' => [], 'feature_fa' => 'fas fa-headset',      'feature_title' => 'Поддержка',    'feature_desc' => 'Техническая консультация и сервисное обслуживание'],
    ];
}

/**
 * Рендер блока иконок-преимуществ (cat-features) с белым CSS-фильтром.
 */
function asiaterm_render_cat_features( $post_id = null ) {
    $features_list = asiaterm_get_cat_features( $post_id );
    if ( ! $features_list ) return;
    ?>
    <div class="cat-features mb-5">
        <div class="row g-0">
            <?php foreach ( $features_list as $feature ) :
                $f_icon_raw = ! empty( $feature['feature_icon'] ) ? reset( $feature['feature_icon'] ) : null;
                $f_icon_url = '';
                if ( is_array( $f_icon_raw ) && ! empty( $f_icon_raw['url'] ) ) {
                    $f_icon_url = $f_icon_raw['url'];
                } elseif ( is_numeric( $f_icon_raw ) ) {
                    $f_icon_url = wp_get_attachment_url( (int) $f_icon_raw );
                }
                $f_fa    = $feature['feature_fa']    ?? '';
                $f_title = $feature['feature_title'] ?? '';
                $f_desc  = $feature['feature_desc']  ?? '';
            ?>
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="cat-feature-item">
                        <?php if ( $f_icon_url ) : ?>
                            <div class="cat-feature-icon">
                                <img src="<?php echo esc_url( $f_icon_url ); ?>" alt="<?php echo esc_attr( $f_title ); ?>" loading="lazy">
                            </div>
                        <?php elseif ( $f_fa ) : ?>
                            <div class="cat-feature-icon">
                                <i class="<?php echo esc_attr( $f_fa ); ?>" style="font-size: 2rem; color: var(--color-white);"></i>
                            </div>
                        <?php endif; ?>
                        <?php if ( $f_title ) : ?>
                            <h6 class="cat-feature-title"><?php echo esc_html( $f_title ); ?></h6>
                        <?php endif; ?>
                        <?php if ( $f_desc ) : ?>
                            <p class="cat-feature-desc"><?php echo esc_html( $f_desc ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}
