<?php if (!empty($partner_logos)) : ?>
<div class="owl-carousel owl-partners">
    <?php foreach ($partner_logos as $logo) : ?>
        <div class="partner-item">
            <img src="<?php echo esc_url($logo['url']); ?>"
                 alt="<?php echo esc_attr($logo['alt'] ?: 'Partner'); ?>"
                 loading="lazy"
                 class="partner-logo">
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
