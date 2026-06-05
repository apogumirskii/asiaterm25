<?php
/**
 * Product Gallery Carousel
 * Expects $gallery array (from rwmb_meta) to be set before include
 *
 * Каждый слайд использует размер `costom-gallery` (1290×580) — намного легче чем оригинал.
 * Полное изображение открывается через Lightbox только при клике.
 */
if ($gallery) : ?>
    <div class="swiper swiper-product-gallery mb-3">
        <div class="swiper-wrapper">
        <?php foreach ($gallery as $image) :
            $att_id    = !empty($image['ID']) ? (int) $image['ID'] : 0;
            $slide_url = $att_id
                ? wp_get_attachment_image_url($att_id, 'costom-gallery')
                : ($image['url'] ?? $image['full_url'] ?? '');
            $full_url  = $image['full_url'] ?? $image['url'] ?? '';
            $alt       = $image['alt'] ?? get_the_title();
        ?>
            <div class="swiper-slide product-slide">
                <a href="<?php echo esc_url($full_url); ?>"
                   data-lightbox="product-gallery"
                   data-title="<?php echo esc_attr($alt); ?>">
                    <img src="<?php echo esc_url($slide_url); ?>"
                         class="img-fluid w-100"
                         loading="lazy"
                         alt="<?php echo esc_attr($alt); ?>">
                </a>
            </div>
        <?php endforeach; ?>
        </div>
        <button class="swiper-button-prev" type="button"></button>
        <button class="swiper-button-next" type="button"></button>
    </div>
    <?php if (count($gallery) > 1) : ?>
        <div class="swiper swiper-product-thumbs">
            <div class="swiper-wrapper">
            <?php foreach ($gallery as $image) :
                $att_id    = !empty($image['ID']) ? (int) $image['ID'] : 0;
                $thumb_url = $att_id
                    ? wp_get_attachment_image_url($att_id, 'small')
                    : ($image['small_url'] ?? $image['medium_url'] ?? $image['url'] ?? $image['full_url'] ?? '');
            ?>
                <div class="swiper-slide product-thumb">
                    <img src="<?php echo esc_url($thumb_url); ?>"
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
