<?php /* Template Name: Сертификаты */ get_header();
include(locate_template('template-parts/menu.php'));
include(locate_template('template-parts/phead.php'));

$gallery = rwmb_meta('cert_gallery', ['size' => 'medium']);
?>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="section-subheading"><?php esc_html_e('Документы', 'asiaterm25'); ?></h6>
            <h2 class="section-heading"><?php the_title(); ?></h2>
            <p class="company-text mt-3" style="max-width: 600px; margin: 0 auto;"><?php esc_html_e('Все наше оборудование имеет официальную сертификацию и соответствует международным стандартам качества.', 'asiaterm25'); ?></p>
        </div>

        <?php if ($gallery) : ?>
        <!-- Поиск -->
        <div class="row mb-4 justify-content-center">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" id="certSearch" class="form-control form-control-lg" placeholder="<?php esc_attr_e('Поиск по названию сертификата...', 'asiaterm25'); ?>">
                </div>
            </div>
        </div>

        <div class="row g-4" id="certGrid">
            <?php foreach ($gallery as $image) :
                $title = $image['title'] ?: $image['alt'] ?: '';
            ?>
            <div class="col-6 col-md-4 col-lg-3 cert-item" data-name="<?php echo esc_attr(mb_strtolower($title)); ?>">
                <a href="<?php echo esc_url(asiaterm_webp_url_swap($image['full_url'])); ?>" data-lightbox="certificates" data-title="<?php echo esc_attr($title); ?>" class="cert-card">
                    <div class="cert-card-img">
                        <img src="<?php echo esc_url(asiaterm_webp_url_swap($image['url'])); ?>"
                             loading="lazy"
                             alt="<?php echo esc_attr($title); ?>">
                        <div class="cert-card-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>
                    <?php if ($title) : ?>
                    <div class="cert-card-body">
                        <p class="cert-card-title"><?php echo esc_html($title); ?></p>
                    </div>
                    <?php endif; ?>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <p class="text-muted mt-3 small text-center" id="certCount"><?php printf(esc_html__('Всего сертификатов: %d', 'asiaterm25'), count($gallery)); ?></p>

        <?php else : ?>
        <!-- Демо-заглушка -->
        <div class="row g-4">
            <?php for ($i = 1; $i <= 8; $i++) : ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="cert-card">
                    <div class="cert-card-img d-flex align-items-center justify-content-center" style="background: var(--color-gray);">
                        <i class="fas fa-file-pdf fa-4x" style="color: var(--color-primary); opacity: 0.3;"></i>
                    </div>
                    <div class="cert-card-body">
                        <p class="cert-card-title"><?php printf(esc_html__('Сертификат %d', 'asiaterm25'), $i); ?></p>
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

<?php if ($gallery) : ?>
<script>
jQuery(document).ready(function($) {
    var $items = $('#certGrid .cert-item');
    var total = $items.length;

    $('#certSearch').on('input', function() {
        var q = $(this).val().trim().toLowerCase();
        var visible = 0;
        $items.each(function() {
            var match = !q || $(this).data('name').toString().indexOf(q) !== -1;
            $(this).toggle(match);
            if (match) visible++;
        });
        $('#certCount').text(q
            ? '<?php echo esc_js(__('Найдено сертификатов:', 'asiaterm25')); ?> ' + visible + ' / ' + total
            : '<?php echo esc_js(__('Всего сертификатов:', 'asiaterm25')); ?> ' + total);
    });
});
</script>
<?php endif; ?>

<?php
include(locate_template('page-top/ctasec.php'));
get_footer();
