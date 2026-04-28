<?php
/**
 * Product Gallery Carousel
 * Expects $gallery array (from rwmb_meta) to be set before include
 */
if ($gallery) : ?>
    <div class="swiper swiper-product-gallery mb-3">
        <div class="swiper-wrapper">
        <?php foreach ($gallery as $image) : ?>
            <div class="swiper-slide product-slide">
                <img src="<?php echo esc_url(asiaterm_webp_url_swap($image['full_url'])); ?>"
                     class="img-fluid w-100"
                     alt="<?php echo esc_attr($image['alt'] ?: get_the_title()); ?>">
            </div>
        <?php endforeach; ?>
        </div>
        <button class="swiper-button-prev" type="button"></button>
        <button class="swiper-button-next" type="button"></button>
    </div>
    <?php if (count($gallery) > 1) : ?>
        <div class="swiper swiper-product-thumbs">
            <div class="swiper-wrapper">
            <?php foreach ($gallery as $image) : ?>
                <div class="swiper-slide product-thumb">
                    <img src="<?php echo esc_url(asiaterm_webp_url_swap($image['small_url'] ?? $image['medium_url'] ?? $image['full_url'])); ?>"
                         class="img-fluid"
                         loading="lazy"
                         alt="">
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
<?php else : ?>
    <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large') ?: get_template_directory_uri() . '/img/placeholder.jpg'); ?>"
         class="img-fluid w-100"
         alt="<?php echo esc_attr(get_the_title()); ?>">
<?php endif; ?>
