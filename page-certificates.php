<?php /* Template Name: Сертификаты */ get_header();
include(locate_template('template-parts/menu.php'));
include(locate_template('template-parts/phead.php'));

$gallery = rwmb_meta('cert_gallery', ['size' => 'costom-gallery']);
?>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="section-subheading"><?php esc_html_e('Документы', 'asiaterm25'); ?></h6>
            <h2 class="section-heading"><?php the_title(); ?></h2>
            <p class="company-text mt-3" style="max-width: 600px; margin: 0 auto;"><?php esc_html_e('Все наше оборудование имеет официальную сертификацию и соответствует международным стандартам качества.', 'asiaterm25'); ?></p>
        </div>

        <?php if ($gallery) : ?>
        <div class="row g-4">
            <?php foreach ($gallery as $image) : ?>
            <div class="col-6 col-md-4 col-lg-3">
                <a href="<?php echo esc_url(asiaterm_webp_url_swap($image['full_url'])); ?>" data-lightbox="certificates" data-title="<?php echo esc_attr($image['title']); ?>">
                    <div class="product-card" style="overflow: hidden;">
                        <div class="product-card-img" style="height: 300px;">
                            <img src="<?php echo esc_url(asiaterm_webp_url_swap($image['url'])); ?>"
                                 loading="lazy"
                                 alt="<?php echo esc_attr($image['alt'] ?: $image['title']); ?>">
                        </div>
                        <?php if (!empty($image['title'])) : ?>
                        <div class="product-card-body text-center py-2">
                            <p class="mb-0 small fw-bold"><?php echo esc_html($image['title']); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>

        <?php else : ?>
        <!-- Демо-заглушка -->
        <div class="row g-4">
            <?php for ($i = 1; $i <= 8; $i++) : ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="product-card">
                    <div class="product-card-img d-flex align-items-center justify-content-center" style="height: 300px; background: var(--color-gray);">
                        <i class="fas fa-file-pdf fa-4x" style="color: var(--color-primary); opacity: 0.3;"></i>
                    </div>
                    <div class="product-card-body text-center py-2">
                        <p class="mb-0 small fw-bold"><?php printf(esc_html__('Сертификат %d', 'asiaterm25'), $i); ?></p>
                    </div>
                </div>
            </div>
            <?php endfor; ?>
        </div>
        <div class="text-center mt-4">
            <p class="text-muted"><?php esc_html_e('Загрузите сертификаты через редактор страницы в Meta Box → Галерея сертификатов', 'asiaterm25'); ?></p>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php
include(locate_template('page-top/ctasec.php'));
get_footer();
