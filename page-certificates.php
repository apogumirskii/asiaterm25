<?php /* Template Name: Сертификаты */ get_header();
include(locate_template('template-parts/menu.php'));
include(locate_template('template-parts/phead.php'));

$video_url  = rwmb_meta('cert_video_url');
$heading    = rwmb_meta('cert_heading');
$buttons    = rwmb_meta('cert_buttons');
$gallery    = rwmb_meta('cert_gallery', ['size' => 'costom-gallery']);
?>

<?php if ($video_url || $heading) : ?>
<section class="hero-video-section">
    <div class="hero-overlay"></div>
    <div class="container h-100">
        <div class="row align-items-center h-100 py-5">

            <?php if ($video_url) : ?>
            <div class="col-lg-3 col-md-2 text-center">
                <a href="<?php echo esc_url($video_url); ?>"
                   class="video-play-btn"
                   data-bs-toggle="modal"
                   data-bs-target="#videoModal">
                    <i class="fas fa-play"></i>
                </a>
            </div>
            <?php endif; ?>

            <div class="col-lg-6 col-md-8">
                <?php if ($heading) : ?>
                    <h2 class="hero-title mb-4"><?php echo wp_kses_post($heading); ?></h2>
                <?php else : ?>
                    <h2 class="hero-title mb-4"><?php the_title(); ?></h2>
                <?php endif; ?>
                <?php if ($buttons) : ?>
                <div class="d-flex flex-wrap gap-3">
                    <?php foreach ($buttons as $btn) : ?>
                        <a href="<?php echo esc_url($btn['cert_btn_url'] ?? '#'); ?>" class="btn hero-btn">
                            <?php echo esc_html($btn['cert_btn_text'] ?? ''); ?> <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>

<?php if ($video_url) :
    $embed_url = str_replace('watch?v=', 'embed/', $video_url);
    $embed_url = strtok($embed_url, '&') . '?autoplay=1';
?>
<div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-black border-0">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="ratio ratio-16x9">
                    <iframe id="youtubeFrame" src="" data-src="<?php echo esc_url($embed_url); ?>"
                            title="YouTube video" allowfullscreen allow="autoplay; encrypted-media"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
jQuery(document).ready(function($) {
    $('#videoModal').on('show.bs.modal', function() {
        $('#youtubeFrame').attr('src', $('#youtubeFrame').data('src'));
    });
    $('#videoModal').on('hidden.bs.modal', function() {
        $('#youtubeFrame').attr('src', '');
    });
});
</script>
<?php endif; ?>
<?php endif; ?>

<?php if ($gallery) : ?>
<section class="py-5">
    <div class="container">
        <h2 class="section-title"><?php esc_html_e('Сертификаты и документы', 'asiaterm25'); ?></h2>
        <div class="row g-4">
            <?php foreach ($gallery as $image) : ?>
            <div class="col-6 col-md-4 col-lg-3">
                <a href="<?php echo esc_url($image['full_url']); ?>" data-lightbox="certificates" data-title="<?php echo esc_attr($image['title']); ?>">
                    <img src="<?php echo esc_url($image['url']); ?>"
                         class="img-fluid rounded shadow-sm"
                         loading="lazy"
                         alt="<?php echo esc_attr($image['alt'] ?: $image['title']); ?>">
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (!$gallery && !$video_url && !$heading) : ?>
<section class="py-5">
    <div class="container">
        <h2 class="section-title"><?php the_title(); ?></h2>
        <?php the_content(); ?>
    </div>
</section>
<?php endif; ?>

<?php
include(locate_template('page-top/ctasec.php'));
get_footer();
