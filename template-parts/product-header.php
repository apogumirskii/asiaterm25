<?php
/**
 * Product Header Block (title, shortdesc, variations, WhatsApp button)
 * Expects: $shortdesc, $var_titles to be set before include
 */
?>
<div class="col-lg-6">
    <h1 class="product-title mb-4"><?php the_title(); ?></h1>

    <?php if ($shortdesc) : ?>
        <div class="product-shortdesc mb-4">
            <?php echo do_shortcode(wp_kses_post($shortdesc)); ?>
        </div>
    <?php else : ?>
        <?php
        $content = apply_filters('the_content', get_the_content());
        $lines   = preg_split('/\r\n|\r|\n/', $content);
        $lines   = array_values(array_filter($lines, fn($l) => trim($l) !== ''));
        $lines   = array_slice($lines, 0, 10);
        $excerpt_html = force_balance_tags(implode("\n", $lines));
        ?>
        <div class="product-shortdesc mb-4">
            <?php echo wp_kses_post($excerpt_html); ?>
        </div>
    <?php endif; ?>

    <?php
    $children = get_pages([
        'parent'      => get_the_ID(),
        'post_status' => 'publish',
        'sort_column' => 'menu_order',
    ]);
    ?>

    <?php if ($children) : ?>
        <div class="product-variations d-flex flex-wrap gap-2 mb-4">
            <?php foreach ($children as $child) : ?>
                <a href="<?php echo esc_url(get_permalink($child->ID)); ?>" class="variation-badge">
                    <?php echo esc_html($child->post_title); ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php elseif ($var_titles) : ?>
        <div class="product-variations d-flex flex-wrap gap-2 mb-4">
            <?php foreach ($var_titles as $title) : ?>
                <span class="variation-badge">
                    <?php echo esc_html($title); ?>
                </span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php $wa_number = get_option('my_whatsapp') ?: get_option('my_phone'); ?>
    <a href="https://wa.me/<?php echo preg_replace('/\D/', '', $wa_number); ?>?text=<?php echo urlencode("Меня интересует!\n\nНазвание товара: " . get_the_title() . "\nСсылка: " . get_permalink()); ?>"
       target="_blank"
       class="btn btn-primary btn-lg w-100">
        <i class="fab fa-whatsapp me-2"></i>
        <?php esc_html_e('Заказать в WhatsApp', 'asiaterm25'); ?>
    </a>
</div>
