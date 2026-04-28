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
