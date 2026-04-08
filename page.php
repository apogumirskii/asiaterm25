<?php get_header();

include(locate_template('template-parts/menu.php'));
include(locate_template('template-parts/phead.php'));

// Если страница — дочерняя от Портфолио (ID 29), используем шаблон портфолио
$is_portfolio_child = false;
$check_id = get_the_ID();
while ($check_id) {
    $parent = wp_get_post_parent_id($check_id);
    if ($parent == 29) {
        $is_portfolio_child = true;
        break;
    }
    $check_id = $parent;
}

if ($is_portfolio_child) :
    $current_id = get_the_ID();
    $gallery  = rwmb_meta('prod_service_gallery', ['object_type' => 'post'], $current_id);
    $gallery2 = rwmb_meta('prod_service_gallery2', ['object_type' => 'post'], $current_id);
    $all_images = array_values(array_filter(array_merge($gallery ?: [], $gallery2 ?: [])));
    if (empty($all_images) && has_post_thumbnail($current_id)) {
        $thumb_id  = get_post_thumbnail_id($current_id);
        $thumb_url = wp_get_attachment_url($thumb_id);
        $all_images = [['ID' => $thumb_id, 'full_url' => $thumb_url, 'url' => $thumb_url, 'sizes' => []]];
    }
?>

<section id="project-page" class="py-5">
    <div class="container">
        <?php if ($all_images) : ?>
        <div class="project-gallery mb-5">
            <div class="project-gallery-main mb-3">
                <a href="<?php echo esc_url($all_images[0]['full_url'] ?? $all_images[0]['url']); ?>" data-lightbox="project-gallery">
                    <img src="<?php echo esc_url($all_images[0]['full_url'] ?? $all_images[0]['url']); ?>"
                         id="projectMainImg"
                         alt="<?php the_title_attribute(); ?>">
                </a>
            </div>
            <?php if (count($all_images) > 1) : ?>
            <div class="project-gallery-thumbs">
                <?php foreach ($all_images as $i => $img) :
                    $thumb_src = '';
                    if (!empty($img['sizes']['thumbnail'])) {
                        $thumb_src = $img['sizes']['thumbnail'];
                    } elseif (!empty($img['ID'])) {
                        $thumb_arr = wp_get_attachment_image_src($img['ID'], 'thumbnail');
                        $thumb_src = $thumb_arr ? $thumb_arr[0] : '';
                    }
                    if (!$thumb_src) {
                        $thumb_src = $img['full_url'] ?? $img['url'] ?? '';
                    }
                ?>
                    <div class="project-thumb <?php echo $i === 0 ? 'active' : ''; ?>"
                         data-src="<?php echo esc_url($img['full_url'] ?? $img['url']); ?>">
                        <img src="<?php echo esc_url($thumb_src); ?>" loading="lazy" alt="">
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if (get_the_content()) : ?>
        <div class="project-description">
            <?php the_content(); ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php else : ?>

<section id="page" class="py-3 pt-3 mt-3">
    <div class="container">
        <div class="row g-4">
            <?php the_content(); ?>
        </div>
    </div>
</section>

<?php endif; ?>

<?php include(locate_template('page-top/ctasec.php'));
get_footer();
