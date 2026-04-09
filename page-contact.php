<?php /* Template Name: Контакты */ get_header();
include(locate_template('template-parts/menu.php'));
include(locate_template('template-parts/phead.php'));

$address    = get_option('my_adress') ?: 'г. Бишкек, Кыргызстан';
$phone      = get_option('my_phone');
$phone2     = get_option('my_phone2');
$email      = get_option('my_mymail');
$wa_number  = get_option('my_whatsapp') ?: $phone;
$telegram   = get_option('my_telegram');
$instagram  = get_option('my_instagramm');
$twogis     = get_option('my_2gis');
$work_hours = get_option('my_work_hours') ?: 'Пн-Пт: 9:00-18:00, Сб: 10:00-15:00';
$map_embed  = rwmb_meta('contact_map_embed');
$extra_info = rwmb_meta('contact_extra_info');
?>

<!-- Контактные карточки -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">

            <!-- Адрес -->
            <div class="col-lg-4 col-md-6">
                <div class="contact-card text-center">
                    <div class="contact-card-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h5 class="contact-card-title"><?php esc_html_e('Адрес', 'asiaterm25'); ?></h5>
                    <p class="contact-card-text"><?php echo esc_html($address); ?></p>
                    <?php if ($twogis) : ?>
                        <a href="<?php echo esc_url($twogis); ?>" target="_blank" rel="noopener" class="btn contact-card-btn">
                            <i class="fas fa-map me-1"></i> <?php esc_html_e('Открыть в 2ГИС', 'asiaterm25'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Телефон -->
            <div class="col-lg-4 col-md-6">
                <div class="contact-card text-center">
                    <div class="contact-card-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h5 class="contact-card-title"><?php esc_html_e('Телефон', 'asiaterm25'); ?></h5>
                    <?php if ($phone) : ?>
                        <p class="contact-card-text">
                            <a href="tel:<?php echo esc_attr($phone); ?>" class="contact-card-link"><?php echo esc_html($phone); ?></a>
                        </p>
                    <?php endif; ?>
                    <?php if ($phone2) : ?>
                        <p class="contact-card-text">
                            <a href="tel:<?php echo esc_attr($phone2); ?>" class="contact-card-link"><?php echo esc_html($phone2); ?></a>
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Email -->
            <div class="col-lg-4 col-md-6">
                <div class="contact-card text-center">
                    <div class="contact-card-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h5 class="contact-card-title">Email</h5>
                    <?php if ($email) : ?>
                        <p class="contact-card-text">
                            <a href="mailto:<?php echo esc_attr($email); ?>" class="contact-card-link"><?php echo esc_html($email); ?></a>
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- WhatsApp -->
            <?php if ($wa_number) : ?>
            <div class="col-lg-4 col-md-6">
                <div class="contact-card text-center">
                    <div class="contact-card-icon" style="background: var(--color-whatsapp);">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <h5 class="contact-card-title">WhatsApp</h5>
                    <p class="contact-card-text"><?php echo esc_html($wa_number); ?></p>
                    <a href="https://wa.me/<?php echo preg_replace('/\D/', '', $wa_number); ?>" target="_blank" rel="noopener" class="btn contact-card-btn" style="background: var(--color-whatsapp);">
                        <i class="fab fa-whatsapp me-1"></i> <?php esc_html_e('Написать', 'asiaterm25'); ?>
                    </a>
                </div>
            </div>
            <?php endif; ?>

            <!-- Режим работы -->
            <div class="col-lg-4 col-md-6">
                <div class="contact-card text-center">
                    <div class="contact-card-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h5 class="contact-card-title"><?php esc_html_e('Режим работы', 'asiaterm25'); ?></h5>
                    <p class="contact-card-text"><?php echo esc_html($work_hours); ?></p>
                </div>
            </div>

            <!-- Соцсети -->
            <?php if ($telegram || $instagram) : ?>
            <div class="col-lg-4 col-md-6">
                <div class="contact-card text-center">
                    <div class="contact-card-icon">
                        <i class="fas fa-share-alt"></i>
                    </div>
                    <h5 class="contact-card-title"><?php esc_html_e('Мы в соцсетях', 'asiaterm25'); ?></h5>
                    <div class="d-flex justify-content-center gap-3 mt-3">
                        <?php if ($telegram) : ?>
                            <a href="<?php echo esc_url($telegram); ?>" target="_blank" rel="noopener" class="contact-social-link" style="background: #0088cc;">
                                <i class="fab fa-telegram-plane"></i>
                            </a>
                        <?php endif; ?>
                        <?php if ($instagram) : ?>
                            <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener" class="contact-social-link" style="background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);">
                                <i class="fab fa-instagram"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (get_option('my_facebook')) : ?>
                            <a href="<?php echo esc_url(get_option('my_facebook')); ?>" target="_blank" rel="noopener" class="contact-social-link" style="background: #1877f2;">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (get_option('my_youtube')) : ?>
                            <a href="<?php echo esc_url(get_option('my_youtube')); ?>" target="_blank" rel="noopener" class="contact-social-link" style="background: #ff0000;">
                                <i class="fab fa-youtube"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<!-- Карта -->
<?php if ($map_embed) : ?>
<section class="py-5" style="background: var(--color-gray-light);">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="section-subheading"><?php esc_html_e('Расположение', 'asiaterm25'); ?></h6>
            <h2 class="section-heading"><?php esc_html_e('Как нас найти', 'asiaterm25'); ?></h2>
        </div>
        <div class="rounded overflow-hidden" style="min-height: 450px; box-shadow: var(--shadow-md);">
            <?php echo $map_embed; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if ($extra_info) : ?>
<section class="py-5">
    <div class="container">
        <div class="contact-extra">
            <?php echo do_shortcode(wp_kses_post($extra_info)); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php
include(locate_template('page-top/ctasec.php'));
get_footer();
