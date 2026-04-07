<?php /* Template Name: Партнёрам */ get_header();
include(locate_template('template-parts/menu.php'));
include(locate_template('template-parts/phead.php'));

$intro         = rwmb_meta('partners_intro');
$brands        = rwmb_meta('partners_brands');
$partner_logos = rwmb_meta('partners_logos', ['size' => 'medium']);
$wa_number     = get_option('my_whatsapp') ?: get_option('my_phone');
?>

<!-- Вступление -->
<section class="company-section py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <img src="<?php echo get_template_directory_uri(); ?>/files/topimg2.png"
                     class="img-fluid company-img"
                     loading="lazy"
                     alt="Asiaterm Partners">
            </div>
            <div class="col-lg-6">
                <h6 class="company-subheading"><?php bloginfo('name'); ?></h6>
                <h2 class="company-heading mb-4"><?php the_title(); ?></h2>
                <div class="company-text mb-4">
                    <?php if ($intro) :
                        echo do_shortcode(wp_kses_post($intro));
                    else : ?>
                        <p>Компания <strong>Asiaterm</strong> является официальным дилером ведущих европейских производителей отопительного и охлаждающего оборудования. Мы предлагаем полный спектр продукции от проверенных брендов с официальной гарантией и сертификацией.</p>
                        <p>Приглашаем к сотрудничеству строительные, монтажные и проектные организации.</p>
                    <?php endif; ?>
                </div>
                <a href="#partner-form-section" class="btn company-btn-primary">
                    <?php esc_html_e('Стать партнёром', 'asiaterm25'); ?> <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Карточки брендов -->
<?php
$brands_list = $brands ?: [
    [
        'brand_name' => 'Minib',
        'brand_desc' => 'Чешский производитель внутрипольных конвекторов и настенных обогревателей. Более 25 лет на рынке отопительного оборудования.',
        'brand_product_type' => 'Внутрипольные конвекторы',
        'brand_address' => 'Чехия, Прага',
        'brand_website' => 'https://www.minib.cz',
        'brand_logo' => [], 'brand_photo' => [],
    ],
    [
        'brand_name' => 'Kermi',
        'brand_desc' => 'Немецкий производитель стальных панельных радиаторов, полотенцесушителей и систем вентиляции.',
        'brand_product_type' => 'Радиаторы, полотенцесушители',
        'brand_address' => 'Германия, Платтлинг',
        'brand_website' => 'https://www.kermi.com',
        'brand_logo' => [], 'brand_photo' => [],
    ],
    [
        'brand_name' => 'Protherm',
        'brand_desc' => 'Европейский производитель газовых и электрических котлов для отопления жилых и коммерческих помещений.',
        'brand_product_type' => 'Газовые и электрические котлы',
        'brand_address' => 'Словакия, Братислава',
        'brand_website' => 'https://www.protherm.com',
        'brand_logo' => [], 'brand_photo' => [],
    ],
];
?>

<section class="py-5" style="background: var(--color-gray-light);">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="section-subheading"><?php esc_html_e('Бренды', 'asiaterm25'); ?></h6>
            <h2 class="section-heading"><?php esc_html_e('Мы — официальные дилеры', 'asiaterm25'); ?></h2>
        </div>

        <div class="row g-4">
            <?php foreach ($brands_list as $brand) :
                $logo  = !empty($brand['brand_logo']) ? reset($brand['brand_logo']) : null;
                $photo = !empty($brand['brand_photo']) ? reset($brand['brand_photo']) : null;
            ?>
            <div class="col-lg-4 col-md-6">
                <div class="product-card h-100">
                    <?php if ($photo && !empty($photo['url'])) : ?>
                        <div class="product-card-img">
                            <img src="<?php echo esc_url($photo['url']); ?>"
                                 loading="lazy"
                                 alt="<?php echo esc_attr($brand['brand_name'] ?? ''); ?>">
                        </div>
                    <?php else : ?>
                        <div class="product-card-img d-flex align-items-center justify-content-center" style="background: var(--color-gray);">
                            <i class="fas fa-industry fa-4x" style="color: var(--color-primary); opacity: 0.3;"></i>
                        </div>
                    <?php endif; ?>

                    <div class="product-card-body">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <?php if ($logo && !empty($logo['url'])) : ?>
                                <img src="<?php echo esc_url($logo['url']); ?>"
                                     style="max-width: 50px; max-height: 35px; object-fit: contain;"
                                     alt="<?php echo esc_attr($brand['brand_name'] ?? ''); ?>">
                            <?php endif; ?>
                            <h5 class="fw-bold mb-0"><?php echo esc_html($brand['brand_name'] ?? ''); ?></h5>
                        </div>

                        <?php if (!empty($brand['brand_product_type'])) : ?>
                            <div class="mb-2">
                                <span class="typesvar"><?php echo esc_html($brand['brand_product_type']); ?></span>
                            </div>
                        <?php endif; ?>

                        <p class="product-card-desc" style="-webkit-line-clamp: 4;"><?php echo esc_html($brand['brand_desc'] ?? ''); ?></p>

                        <div class="d-flex flex-column gap-1 mb-3" style="font-size: var(--font-size-sm);">
                            <?php if (!empty($brand['brand_address'])) : ?>
                                <span style="color: var(--color-text-muted);">
                                    <i class="fas fa-map-marker-alt me-2" style="color: var(--color-primary);"></i><?php echo esc_html($brand['brand_address']); ?>
                                </span>
                            <?php endif; ?>
                            <?php if (!empty($brand['brand_website'])) : ?>
                                <span>
                                    <i class="fas fa-globe me-2" style="color: var(--color-primary);"></i>
                                    <a href="<?php echo esc_url($brand['brand_website']); ?>" target="_blank" rel="noopener" class="text-decoration-none" style="color: var(--color-primary);">
                                        <?php echo esc_html(str_replace(['https://', 'http://', 'www.'], '', $brand['brand_website'])); ?>
                                    </a>
                                </span>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($brand['brand_website'])) : ?>
                            <a href="<?php echo esc_url($brand['brand_website']); ?>" target="_blank" rel="noopener" class="btn product-card-btn">
                                <?php esc_html_e('Подробнее', 'asiaterm25'); ?> <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Карусель логотипов -->
<?php if (!empty($partner_logos)) : ?>
<section class="py-5">
    <div class="container">
        <div class="text-center mb-4">
            <h6 class="section-subheading"><?php esc_html_e('Партнёры', 'asiaterm25'); ?></h6>
            <h2 class="section-heading"><?php esc_html_e('Наши партнёры', 'asiaterm25'); ?></h2>
        </div>
        <?php include locate_template('template-parts/partners-carousel.php'); ?>
    </div>
</section>
<?php endif; ?>

<!-- Форма запроса -->
<section class="py-5" style="background: var(--color-gray-light);" id="partner-form-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <h6 class="section-subheading"><?php esc_html_e('Сотрудничество', 'asiaterm25'); ?></h6>
                    <h2 class="section-heading"><?php esc_html_e('Запрос на сотрудничество', 'asiaterm25'); ?></h2>
                </div>

                <form id="partnerForm" class="needs-validation" novalidate>
                    <?php wp_nonce_field('partner_form_nonce', 'partner_nonce'); ?>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><?php esc_html_e('Название организации', 'asiaterm25'); ?> *</label>
                            <input type="text" name="company" class="form-control form-control-lg" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><?php esc_html_e('Контактное лицо', 'asiaterm25'); ?> *</label>
                            <input type="text" name="contact_person" class="form-control form-control-lg" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><?php esc_html_e('Email', 'asiaterm25'); ?></label>
                            <input type="email" name="email" class="form-control form-control-lg" id="partnerEmail">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><?php esc_html_e('Телефон', 'asiaterm25'); ?></label>
                            <input type="tel" name="phone" class="form-control form-control-lg" id="partnerPhone">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold"><?php esc_html_e('Сообщение', 'asiaterm25'); ?></label>
                        <textarea name="message" class="form-control form-control-lg" rows="4"></textarea>
                    </div>

                    <div id="partnerFormAlert" class="alert d-none mb-3"></div>

                    <div class="d-flex flex-wrap gap-3">
                        <button type="button" id="sendWhatsApp" class="btn btn-lg" style="background: var(--color-whatsapp); color: #fff; border-radius: var(--radius-pill); font-weight: 600;">
                            <i class="fab fa-whatsapp me-2"></i><?php esc_html_e('Отправить в WhatsApp', 'asiaterm25'); ?>
                        </button>
                        <button type="submit" id="sendEmail" class="btn about-btn btn-lg">
                            <i class="fas fa-envelope me-2"></i><?php esc_html_e('Отправить на Email', 'asiaterm25'); ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
jQuery(document).ready(function($) {
    var waNumber = '<?php echo esc_js(preg_replace('/\D/', '', $wa_number)); ?>';

    $('#sendWhatsApp').on('click', function() {
        var form = $('#partnerForm')[0];
        var company = form.company.value.trim();
        var contact = form.contact_person.value.trim();
        var message = form.message.value.trim();

        if (!company || !contact) {
            showAlert('danger', 'Заполните название организации и контактное лицо');
            return;
        }

        var text = 'Запрос на сотрудничество\n';
        text += 'Организация: ' + company + '\n';
        text += 'Контактное лицо: ' + contact + '\n';
        if (form.email.value) text += 'Email: ' + form.email.value + '\n';
        if (form.phone.value) text += 'Телефон: ' + form.phone.value + '\n';
        if (message) text += 'Сообщение: ' + message;

        window.open('https://wa.me/' + waNumber + '?text=' + encodeURIComponent(text), '_blank');
    });

    $('#partnerForm').on('submit', function(e) {
        e.preventDefault();
        var email = $('#partnerEmail').val().trim();
        var phone = $('#partnerPhone').val().trim();

        if (!this.company.value.trim() || !this.contact_person.value.trim()) {
            showAlert('danger', 'Заполните название организации и контактное лицо');
            return;
        }
        if (!email && !phone) {
            showAlert('danger', 'Укажите Email или телефон для обратной связи');
            return;
        }

        var $btn = $('#sendEmail');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Отправка...');

        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            method: 'POST',
            data: {
                action: 'partner_form_send',
                nonce: $('#partner_nonce').val(),
                company: this.company.value,
                contact_person: this.contact_person.value,
                email: email,
                phone: phone,
                message: this.message.value
            },
            success: function(res) {
                if (res.success) {
                    showAlert('success', res.data.message);
                    $('#partnerForm')[0].reset();
                } else {
                    showAlert('danger', res.data.message);
                }
            },
            error: function() {
                showAlert('danger', 'Произошла ошибка. Попробуйте позже.');
            },
            complete: function() {
                $btn.prop('disabled', false).html('<i class="fas fa-envelope me-2"></i>Отправить на Email');
            }
        });
    });

    function showAlert(type, msg) {
        $('#partnerFormAlert').removeClass('d-none alert-success alert-danger')
            .addClass('alert-' + type).text(msg);
    }
});
</script>

<?php
include(locate_template('page-top/ctasec.php'));
get_footer();
