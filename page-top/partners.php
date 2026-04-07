<section class="py-5">
    <div class="container">
        <h2 class="section-title"> </h2>
        <div class="owl-carousel owl-partners">
            <?php
            $gallery_images = rwmb_meta('service_gallery');

            if ($gallery_images) {
                foreach ($gallery_images as $image) {
                    $image_url = $image['full_url'];
                    $image_alt = $image['alt'] ?: 'Partner logo';
            ?>
                <div class="partner-item">
                    <img src="<?php echo esc_url($image_url); ?>"
                         alt="<?php echo esc_attr($image_alt); ?>"
                         loading="lazy"
                         class="partner-logo">
                </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</section>
