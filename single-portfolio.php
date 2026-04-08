<?php get_header();
include(locate_template('template-parts/menu.php'));
include(locate_template('template-parts/phead.php'));

while (have_posts()) : the_post();
    $current_id = get_the_ID();
    $gallery = rwmb_meta('portfolio_gallery', ['size' => 'costom-gallery'], $current_id);
    $all_images = $gallery ? array_values($gallery) : [];
    if (empty($all_images) && has_post_thumbnail($current_id)) {
        $thumb_id  = get_post_thumbnail_id($current_id);
        $thumb_url = wp_get_attachment_url($thumb_id);
        $all_images = [['ID' => $thumb_id, 'full_url' => $thumb_url, 'url' => $thumb_url]];
    }
?>

<main>
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
                    $full = $img['full_url'] ?? $img['url'] ?? '';
                    $thumb = !empty($img['ID']) ? wp_get_attachment_image_url($img['ID'], 'thumbnail') : '';
                    if (!$thumb) $thumb = $full;
                ?>
                    <a href="<?php echo esc_url($full); ?>"
                       data-lightbox="project-gallery"
                       class="project-thumb <?php echo $i === 0 ? 'active' : ''; ?>"
                       data-src="<?php echo esc_url($full); ?>">
                        <img src="<?php echo esc_url($thumb); ?>" loading="lazy" alt="">
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
</main>

<?php endwhile;

include(locate_template('page-top/ctasec.php'));
get_footer();
