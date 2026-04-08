<?php
// $partner_logos — массив изображений из Meta Box (или пустой)
$has_logos = !empty($partner_logos);

// Демо-логотипы если реальные не загружены
$demo_brands = ['Minib', 'Kermi', 'Protherm', 'BAUF', 'Daikin', 'Mitsubishi', 'Bosch', 'Viessmann'];
?>

<div class="owl-carousel owl-partners">
    <?php if ($has_logos) : ?>
        <?php foreach ($partner_logos as $logo) : ?>
            <div class="partner-item">
                <img src="<?php echo esc_url($logo['url']); ?>"
                     alt="<?php echo esc_attr($logo['alt'] ?: 'Partner'); ?>"
                     loading="lazy"
                     class="partner-logo">
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <?php foreach ($demo_brands as $brand) : ?>
            <div class="partner-item">
                <span style="font-weight: 700; font-size: 0.85rem; color: var(--color-text-muted); text-align: center;"><?php echo esc_html($brand); ?></span>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
