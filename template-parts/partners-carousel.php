<?php
// $partner_logos — массив изображений из Meta Box (или пустой)
if (empty($partner_logos)) return;
?>

<div class="swiper swiper-partners">
    <div class="swiper-wrapper">
        <?php foreach ($partner_logos as $logo) : ?>
            <div class="swiper-slide partner-item">
                <img src="<?php echo esc_url(asiaterm_webp_url_swap($logo['url'])); ?>"
                     alt="<?php echo esc_attr($logo['alt'] ?: 'Partner'); ?>"
                     loading="lazy"
                     class="partner-logo">
            </div>
        <?php endforeach; ?>
    </div>
</div>
