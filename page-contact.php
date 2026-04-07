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
$work_hours = rwmb_meta('contact_work_hours') ?: 'Пн-Пт: 9:00-18:00, Сб: 10:00-15:00';
$map_embed  = rwmb_meta('contact_map_embed');
$extra_info = rwmb_meta('contact_extra_info');
?>

<section id="contacts" class="py-5">
    <div class="container">
        <h2 class="section-title"><?php the_title(); ?></h2>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card p-4 h-100">
                    <?php if ($address) : ?>
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <i class="fas fa-map-marker-alt fa-lg text-primary mt-1"></i>
                        <div>
                            <h6 class="mb-1"><?php esc_html_e('Адрес', 'asiaterm25'); ?></h6>
                            <p class="mb-0"><?php echo esc_html($address); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($phone) : ?>
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <i class="fas fa-phone-alt fa-lg text-primary mt-1"></i>
                        <div>
                            <h6 class="mb-1"><?php esc_html_e('Телефон', 'asiaterm25'); ?></h6>
                            <a href="tel:<?php echo esc_attr($phone); ?>" class="text-decoration-none">
                                <?php echo esc_html($phone); ?>
                            </a>
                            <?php if ($phone2) : ?>
                                <br><a href="tel:<?php echo esc_attr($phone2); ?>" class="text-decoration-none">
                                    <?php echo esc_html($phone2); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($email) : ?>
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <i class="fas fa-envelope fa-lg text-primary mt-1"></i>
                        <div>
                            <h6 class="mb-1">Email</h6>
                            <a href="mailto:<?php echo esc_attr($email); ?>" class="text-decoration-none">
                                <?php echo esc_html($email); ?>
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($work_hours) : ?>
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <i class="fas fa-clock fa-lg text-primary mt-1"></i>
                        <div>
                            <h6 class="mb-1"><?php esc_html_e('Режим работы', 'asiaterm25'); ?></h6>
                            <p class="mb-0"><?php echo esc_html($work_hours); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="d-flex gap-3 mt-auto">
                        <?php if ($wa_number) : ?>
                        <a href="https://wa.me/<?php echo preg_replace('/\D/', '', $wa_number); ?>"
                           target="_blank" class="btn btn-success">
                            <i class="fab fa-whatsapp me-1"></i> WhatsApp
                        </a>
                        <?php endif; ?>
                        <?php if ($telegram) : ?>
                        <a href="<?php echo esc_url($telegram); ?>"
                           target="_blank" class="btn btn-primary">
                            <i class="fab fa-telegram me-1"></i> Telegram
                        </a>
                        <?php endif; ?>
                        <?php if ($instagram) : ?>
                        <a href="<?php echo esc_url($instagram); ?>"
                           target="_blank" class="btn btn-outline-danger">
                            <i class="fab fa-instagram me-1"></i> Instagram
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <?php if ($map_embed) : ?>
                    <div class="contact-map rounded overflow-hidden" style="min-height: 400px;">
                        <?php echo $map_embed; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($extra_info) : ?>
        <div class="row mt-5">
            <div class="col-12">
                <div class="contact-extra">
                    <?php echo do_shortcode(wp_kses_post($extra_info)); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php
include(locate_template('page-top/ctasec.php'));
get_footer();
