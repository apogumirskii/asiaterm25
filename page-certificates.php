<?php /* Template Name: Сертификаты */ get_header();
include(locate_template('template-parts/menu.php'));
include(locate_template('template-parts/phead.php'));

$video_url = rwmb_meta('cert_video_url');
$heading   = rwmb_meta('cert_heading');
$buttons   = rwmb_meta('cert_buttons');
$gallery   = rwmb_meta('cert_gallery', ['size' => 'costom-gallery']);
?>

<!-- Hero секция -->
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
                <h2 class="hero-title mb-4">
                    <?php echo $heading ? wp_kses_post($heading) : esc_html__('Качество подтверждённое сертификатами', 'asiaterm25'); ?>
                </h2>
                <?php if ($buttons) : ?>
                <div class="d-flex flex-wrap gap-3">
                    <?php foreach ($buttons as $btn) : ?>
                        <a href="<?php echo esc_url($btn['cert_btn_url'] ?? '#'); ?>" class="btn hero-btn">
                            <?php echo esc_html($btn['cert_btn_text'] ?? ''); ?> <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="/catalog/" class="btn hero-btn">
                            <?php esc_html_e('Каталог продукции', 'asiaterm25'); ?> <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        <a href="/contacts/" class="btn hero-btn" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(4px);">
                            <?php esc_html_e('Связаться с нами', 'asiaterm25'); ?> <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                <?php endif; ?>
                </div>
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
<?php endif; ?>

<!-- Информация -->
<section class="about-section py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <h6 class="about-subheading"><?php esc_html_e('Гарантия качества', 'asiaterm25'); ?></h6>
                <h2 class="about-heading mb-4"><?php esc_html_e('Сертифицированное оборудование', 'asiaterm25'); ?></h2>
                <ul class="about-list list-unstyled mb-4">
                    <li>
                        <span class="about-num">01.</span>
                        <div>
                            <h5 class="about-item-title"><?php esc_html_e('Европейские стандарты', 'asiaterm25'); ?></h5>
                            <p class="about-item-desc"><?php esc_html_e('Всё оборудование соответствует стандартам EN и имеет европейскую сертификацию', 'asiaterm25'); ?></p>
                        </div>
                    </li>
                    <li>
                        <span class="about-num">02.</span>
                        <div>
                            <h5 class="about-item-title"><?php esc_html_e('Официальная гарантия', 'asiaterm25'); ?></h5>
                            <p class="about-item-desc"><?php esc_html_e('Гарантия от производителя на все поставляемое оборудование', 'asiaterm25'); ?></p>
                        </div>
                    </li>
                    <li>
                        <span class="about-num">03.</span>
                        <div>
                            <h5 class="about-item-title"><?php esc_html_e('Техническая документация', 'asiaterm25'); ?></h5>
                            <p class="about-item-desc"><?php esc_html_e('Полный комплект документов: паспорта, сертификаты, инструкции по монтажу', 'asiaterm25'); ?></p>
                        </div>
                    </li>
                </ul>
                <a href="/contacts/" class="btn about-btn"><?php esc_html_e('Запросить документы', 'asiaterm25'); ?> <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
            <div class="col-lg-6 text-center">
                <img src="<?php echo get_template_directory_uri(); ?>/files/topimg2.png"
                     class="img-fluid about-img"
                     loading="lazy"
                     alt="Asiaterm Certificates">
            </div>
        </div>
    </div>
</section>

<!-- Галерея сертификатов -->
<?php if ($gallery) : ?>
<section class="py-5" style="background: var(--color-gray-light);">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="section-subheading"><?php esc_html_e('Документы', 'asiaterm25'); ?></h6>
            <h2 class="section-heading"><?php esc_html_e('Сертификаты и документы', 'asiaterm25'); ?></h2>
        </div>
        <div class="row g-4">
            <?php foreach ($gallery as $image) : ?>
            <div class="col-6 col-md-4 col-lg-3">
                <a href="<?php echo esc_url($image['full_url']); ?>" data-lightbox="certificates" data-title="<?php echo esc_attr($image['title']); ?>">
                    <div class="cat-hero-img" style="height: 280px;">
                        <img src="<?php echo esc_url($image['url']); ?>"
                             loading="lazy"
                             alt="<?php echo esc_attr($image['alt'] ?: $image['title']); ?>">
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php
include(locate_template('page-top/ctasec.php'));
get_footer();
