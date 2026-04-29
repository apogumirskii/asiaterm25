<?php /* Template Name: Отзывы */ get_header();
include(locate_template('template-parts/menu.php'));
include(locate_template('template-parts/phead.php'));

$gallery = rwmb_meta('reviews_gallery');
?>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="section-subheading"><?php esc_html_e('Доверие', 'asiaterm25'); ?></h6>
            <h2 class="section-heading"><?php the_title(); ?></h2>
            <p class="company-text mt-3" style="max-width: 600px; margin: 0 auto;"><?php esc_html_e('Реальные отзывы наших клиентов и партнёров о работе с компанией Asiaterm.', 'asiaterm25'); ?></p>
        </div>

        <?php if ($gallery) : ?>
        <!-- Поиск -->
        <div class="row mb-4 justify-content-center">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" id="reviewSearch" class="form-control form-control-lg" placeholder="<?php esc_attr_e('Поиск по названию отзыва...', 'asiaterm25'); ?>">
                </div>
            </div>
        </div>

        <div class="row g-4" id="reviewGrid">
            <?php foreach ($gallery as $image) :
                $title    = $image['title'] ?? '';
                $alt      = $image['alt']   ?? '';
                $title    = $title ?: $alt;
                $full_url = $image['url'];
                $ext      = strtolower(pathinfo(parse_url($full_url, PHP_URL_PATH), PATHINFO_EXTENSION));
                $is_pdf   = $ext === 'pdf';
                $att_id   = $image['ID']  ?? 0;
                $href     = $is_pdf ? $full_url : asiaterm_webp_url_swap($full_url);
                $thumb_url = '';
                if (!$is_pdf) {
                    if ($att_id) {
                        $thumb_arr = wp_get_attachment_image_src($att_id, 'medium');
                        $thumb_url = $thumb_arr ? $thumb_arr[0] : $full_url;
                    } else {
                        $thumb_url = $full_url;
                    }
                    $thumb_url = asiaterm_webp_url_swap($thumb_url);
                }
            ?>
            <div class="col-6 col-md-4 col-lg-3 cert-item" data-name="<?php echo esc_attr(mb_strtolower($title)); ?>">
                <a href="<?php echo esc_url($href); ?>"
                   <?php if ($is_pdf) : ?>data-cert-pdf="<?php echo esc_url($href); ?>" data-cert-title="<?php echo esc_attr($title); ?>"<?php else : ?>data-lightbox="reviews" data-title="<?php echo esc_attr($title); ?>"<?php endif; ?>
                   class="cert-card">
                    <div class="cert-card-img">
                        <?php if ($is_pdf) : ?>
                            <div class="cert-pdf-preview">
                                <i class="fas fa-file-pdf"></i>
                                <span class="small text-uppercase mt-2">PDF</span>
                            </div>
                        <?php else : ?>
                            <img src="<?php echo esc_url($thumb_url); ?>"
                                 loading="lazy"
                                 alt="<?php echo esc_attr($title); ?>">
                        <?php endif; ?>
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
        <p class="text-muted mt-3 small text-center" id="reviewCount"><?php printf(esc_html__('Всего отзывов: %d', 'asiaterm25'), count($gallery)); ?></p>

        <?php else : ?>
        <!-- Демо-заглушка -->
        <div class="row g-4">
            <?php for ($i = 1; $i <= 8; $i++) : ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="cert-card">
                    <div class="cert-card-img d-flex align-items-center justify-content-center" style="background: var(--color-gray);">
                        <i class="fas fa-comment-dots fa-4x" style="color: var(--color-primary); opacity: 0.3;"></i>
                    </div>
                    <div class="cert-card-body">
                        <p class="cert-card-title"><?php printf(esc_html__('Отзыв %d', 'asiaterm25'), $i); ?></p>
                    </div>
                </div>
            </div>
            <?php endfor; ?>
        </div>
        <div class="text-center mt-4">
            <p class="text-muted"><?php esc_html_e('Загрузите отзывы через редактор страницы в Meta Box → Галерея отзывов', 'asiaterm25'); ?></p>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php if ($gallery) : ?>
<!-- Модалка PDF просмотра -->
<div class="modal fade" id="reviewPdfModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content bg-dark border-0">
            <div class="modal-header border-0 py-2 px-3">
                <h6 class="modal-title text-white mb-0" id="reviewPdfTitle"></h6>
                <div class="d-flex align-items-center gap-3 ms-auto">
                    <a href="#" id="reviewPdfDownload" target="_blank" rel="noopener" class="btn btn-sm portfolio-detail-btn">
                        <i class="fas fa-download me-1"></i> <?php esc_html_e('Скачать', 'asiaterm25'); ?>
                    </a>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
            </div>
            <div class="modal-body p-0">
                <iframe id="reviewPdfFrame" src="" style="width:100%; height:100%; border:0; background:#525659;"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    var $items = $('#reviewGrid .cert-item');
    var total = $items.length;

    $('#reviewSearch').on('input', function() {
        var q = $(this).val().trim().toLowerCase();
        var visible = 0;
        $items.each(function() {
            var match = !q || $(this).data('name').toString().indexOf(q) !== -1;
            $(this).toggle(match);
            if (match) visible++;
        });
        $('#reviewCount').text(q
            ? '<?php echo esc_js(__('Найдено отзывов:', 'asiaterm25')); ?> ' + visible + ' / ' + total
            : '<?php echo esc_js(__('Всего отзывов:', 'asiaterm25')); ?> ' + total);
    });

    // Открытие PDF в модалке
    $(document).on('click', '#reviewGrid [data-cert-pdf]', function(e) {
        e.preventDefault();
        var url   = $(this).data('cert-pdf');
        var title = $(this).data('cert-title') || 'PDF';
        $('#reviewPdfTitle').text(title);
        $('#reviewPdfDownload').attr('href', url);
        $('#reviewPdfFrame').attr('src', url);
        var modal = new bootstrap.Modal(document.getElementById('reviewPdfModal'));
        modal.show();
    });

    $('#reviewPdfModal').on('hidden.bs.modal', function() {
        $('#reviewPdfFrame').attr('src', '');
    });
});
</script>
<?php endif; ?>

<?php
include(locate_template('page-top/ctasec.php'));
get_footer();
