<?php
/**
 * Product Gallery Carousel
 * Expects $gallery array (from rwmb_meta) to be set before include
 */
if ($gallery) : ?>
    <div class="owl-carousel owl-product-gallery mb-3">
        <?php foreach ($gallery as $image) : ?>
            <div class="product-slide">
                <img src="<?php echo esc_url($image['full_url']); ?>"
                     class="img-fluid w-100"
                     alt="<?php echo esc_attr($image['alt'] ?: get_the_title()); ?>">
            </div>
        <?php endforeach; ?>
    </div>
    <?php if (count($gallery) > 1) : ?>
        <div class="owl-carousel owl-product-thumbs">
            <?php foreach ($gallery as $image) : ?>
                <div class="product-thumb">
                    <img src="<?php echo esc_url($image['small_url'] ?? $image['medium_url'] ?? $image['full_url']); ?>"
                         class="img-fluid"
                         loading="lazy"
                         alt="">
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php else : ?>
    <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large') ?: get_template_directory_uri() . '/img/placeholder.jpg'); ?>"
         class="img-fluid w-100"
         alt="<?php echo esc_attr(get_the_title()); ?>">
<?php endif; ?>
