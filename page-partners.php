<?php /* Template Name: Партнёрам */ get_header();
include(locate_template('template-parts/menu.php'));
include(locate_template('template-parts/phead.php'));

$intro    = rwmb_meta('partners_intro');
$benefits = rwmb_meta('partners_benefits');
$logos    = rwmb_meta('partners_logos', ['size' => 'medium']);
$wa_number = get_option('my_whatsapp') ?: get_option('my_phone');
?>

<section class="py-5">
    <div class="container">
        <h2 class="section-title"><?php the_title(); ?></h2>

        <?php if ($intro) : ?>
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <div class="partners-intro">
                    <?php echo do_shortcode(wp_kses_post($intro)); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($benefits) : ?>
        <div class="row g-4 mb-5">
            <?php foreach ($benefits as $benefit) : ?>
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="<?php echo esc_attr($benefit['partner_benefit_icon'] ?? 'fas fa-check-circle'); ?> fa-2x text-primary"></i>
                    </div>
                    <h5><?php echo esc_html($benefit['partner_benefit_title'] ?? ''); ?></h5>
                    <p class="text-muted"><?php echo esc_html($benefit['partner_benefit_desc'] ?? ''); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php if ($logos) : ?>
<section class="py-5 bg-light">
    <div class="container">
        <h3 class="section-title"><?php esc_html_e('Наши партнёры', 'asiaterm25'); ?></h3>
        <div class="owl-carousel owl-partners">
            <?php foreach ($logos as $logo) : ?>
                <div class="partner-item">
                    <img src="<?php echo esc_url($logo['url']); ?>"
                         alt="<?php echo esc_attr($logo['alt'] ?: 'Partner'); ?>"
                         loading="lazy"
                         class="partner-logo">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="py-5" id="partner-form-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h3 class="section-title"><?php esc_html_e('Запрос на сотрудничество', 'asiaterm25'); ?></h3>

                <form id="partnerForm" class="needs-validation" novalidate>
                    <?php wp_nonce_field('partner_form_nonce', 'partner_nonce'); ?>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label"><?php esc_html_e('Название организации', 'asiaterm25'); ?> *</label>
                            <input type="text" name="company" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?php esc_html_e('Контактное лицо', 'asiaterm25'); ?> *</label>
                            <input type="text" name="contact_person" class="form-control" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label"><?php esc_html_e('Email', 'asiaterm25'); ?></label>
                            <input type="email" name="email" class="form-control" id="partnerEmail">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?php esc_html_e('Телефон', 'asiaterm25'); ?></label>
                            <input type="tel" name="phone" class="form-control" id="partnerPhone">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><?php esc_html_e('Сообщение', 'asiaterm25'); ?></label>
                        <textarea name="message" class="form-control" rows="4"></textarea>
                    </div>

                    <div id="partnerFormAlert" class="alert d-none mb-3"></div>

                    <div class="d-flex flex-wrap gap-3">
                        <button type="button" id="sendWhatsApp" class="btn btn-success btn-lg">
                            <i class="fab fa-whatsapp me-2"></i><?php esc_html_e('Отправить в WhatsApp', 'asiaterm25'); ?>
                        </button>
                        <button type="submit" id="sendEmail" class="btn btn-primary btn-lg">
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

    // WhatsApp
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

    // Email AJAX
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
