<?php get_header();
include(locate_template('template-parts/menu.php'));
include(locate_template('template-parts/phead.php'));

while (have_posts()) : the_post();
    $current_id = get_the_ID();
    $gallery = rwmb_meta('portfolio_gallery', ['object_type' => 'post'], $current_id);
    $all_images = $gallery ? array_values($gallery) : [];
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
                    <a href="<?php echo esc_url($img['full_url'] ?? $img['url']); ?>"
                       data-lightbox="project-gallery"
                       class="project-thumb <?php echo $i === 0 ? 'active' : ''; ?>"
                       data-src="<?php echo esc_url($img['full_url'] ?? $img['url']); ?>">
                        <img src="<?php echo esc_url($thumb_src); ?>" loading="lazy" alt="">
                    </a>
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

<?php endwhile;

include(locate_template('page-top/ctasec.php'));
get_footer();
