<?php
$phone     = get_option('my_phone');
$phone2    = get_option('my_phone2');
$email     = get_option('my_mymail');
$address   = get_option('my_adress');
$wa_number = get_option('my_whatsapp') ?: $phone;
$work_hours = get_option('my_work_hours') ?: 'Пн-Пт: 9:00-18:00, Сб: 10:00-15:00';
$cat_pages = get_pages([
    'parent'      => 13,
    'post_status' => 'publish',
    'sort_column' => 'menu_order',
]);
?>
<footer class="site-footer pt-5 pb-3">
    <div class="container">
        <div class="row g-5">

            <!-- Меню -->
            <div class="col-lg-3 col-md-6">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="d-inline-block mb-3">
                    <img src="<?php echo get_template_directory_uri(); ?>/files/asiatermkg-logo.svg" alt="<?php bloginfo('name'); ?>" height="50">
                </a>
                <?php
                wp_nav_menu([
                    'theme_location' => 'topmenu',
                    'container'      => false,
                    'menu_class'     => 'list-unstyled footer-menu',
                    'fallback_cb'    => false,
                ]);
                ?>
                <ul class="list-unstyled footer-menu mt-2">
                    <li><a href="<?php echo esc_url(home_url('/oferta-i-uslovija/')); ?>"><?php esc_html_e('Оферта и условия', 'asiaterm25'); ?></a></li>
                </ul>
            </div>

            <!-- Категории -->
            <div class="col-lg-2 col-md-6">
                <h6 class="footer-heading mb-4"><?php esc_html_e('Каталог', 'asiaterm25'); ?></h6>
                <ul class="list-unstyled footer-menu">
                    <?php foreach ($cat_pages as $cat) : ?>
                        <li><a href="<?php echo esc_url(get_permalink($cat->ID)); ?>"><?php echo esc_html($cat->post_title); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Контакты -->
            <div class="col-lg-3 col-md-6">
                <h6 class="footer-heading mb-4"><?php esc_html_e('Контакты', 'asiaterm25'); ?></h6>
                <ul class="list-unstyled footer-contacts">
                    <?php if ($address) : ?>
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <span><?php echo esc_html($address); ?></span>
                    </li>
                    <?php endif; ?>
                    <?php if ($phone) : ?>
                    <li>
                        <i class="fas fa-phone-alt"></i>
                        <a href="tel:<?php echo esc_attr($phone); ?>"><?php echo esc_html($phone); ?></a>
                    </li>
                    <?php endif; ?>
                    <?php if ($phone2) : ?>
                    <li>
                        <i class="fas fa-phone-alt"></i>
                        <a href="tel:<?php echo esc_attr($phone2); ?>"><?php echo esc_html($phone2); ?></a>
                    </li>
                    <?php endif; ?>
                    <?php if ($email) : ?>
                    <li>
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                    </li>
                    <?php endif; ?>
                    <li>
                        <i class="fas fa-clock"></i>
                        <span><?php echo esc_html($work_hours); ?></span>
                    </li>
                </ul>
                <div class="d-flex gap-3 mt-3">
                    <?php if ($wa_number) : ?>
                        <a href="https://wa.me/<?php echo preg_replace('/\D/', '', $wa_number); ?>" target="_blank" class="footer-social"><i class="fab fa-whatsapp"></i></a>
                    <?php endif; ?>
                    <?php if (get_option('my_telegram')) : ?>
                        <a href="<?php echo esc_url(get_option('my_telegram')); ?>" target="_blank" class="footer-social"><i class="fab fa-telegram"></i></a>
                    <?php endif; ?>
                    <?php if (get_option('my_instagramm')) : ?>
                        <a href="<?php echo esc_url(get_option('my_instagramm')); ?>" target="_blank" class="footer-social"><i class="fab fa-instagram"></i></a>
                    <?php endif; ?>
                    <?php if (get_option('my_facebook')) : ?>
                        <a href="<?php echo esc_url(get_option('my_facebook')); ?>" target="_blank" class="footer-social"><i class="fab fa-facebook-f"></i></a>
                    <?php endif; ?>
                    <?php if (get_option('my_youtube')) : ?>
                        <a href="<?php echo esc_url(get_option('my_youtube')); ?>" target="_blank" class="footer-social"><i class="fab fa-youtube"></i></a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Форма WhatsApp -->
            <div class="col-lg-4 col-md-6">
                <h6 class="footer-heading mb-4"><?php esc_html_e('Связаться с нами', 'asiaterm25'); ?></h6>
                <form id="footerWhatsAppForm" class="footer-wa-form">
                    <div class="mb-3">
                        <input type="text" name="footer_name" class="form-control footer-input" placeholder="<?php esc_attr_e('Ваше имя', 'asiaterm25'); ?>">
                    </div>
                    <div class="mb-3">
                        <textarea name="footer_message" class="form-control footer-input" rows="3" placeholder="<?php esc_attr_e('Сообщение...', 'asiaterm25'); ?>"></textarea>
                    </div>
                    <button type="submit" class="btn footer-submit-btn w-100">
                        <i class="fab fa-whatsapp me-2"></i><?php esc_html_e('Написать в WhatsApp', 'asiaterm25'); ?>
                    </button>
                </form>
            </div>

        </div>

        <hr class="footer-divider mt-5">

        <div class="footer-bottom d-flex flex-wrap justify-content-between align-items-center gap-2">
            <span>&copy; <?php echo date('Y'); ?> <?php esc_html_e('Запрещено к использованию без разрешения', 'asiaterm25'); ?> &mdash; <?php esc_html_e('ОсОО «Азия Терм»', 'asiaterm25'); ?></span>
            <span><?php esc_html_e('Разработка и поддержка сайта', 'asiaterm25'); ?> <a href="https://imse.kg" target="_blank" rel="noopener">IMS BISHKEK</a></span>
        </div>
    </div>
</footer>

<script>
jQuery(document).ready(function($) {
    var waNum = '<?php echo esc_js(preg_replace('/\D/', '', $wa_number)); ?>';
    $('#footerWhatsAppForm').on('submit', function(e) {
        e.preventDefault();
        var name = this.footer_name.value.trim();
        var msg = this.footer_message.value.trim();
        var text = 'Здравствуйте!\n\n';
        if (name) text += 'Имя: ' + name + '\n';
        if (msg) text += 'Сообщение: ' + msg + '\n';
        if (!name && !msg) text = 'Здравствуйте! Хочу узнать подробнее.';
        window.open('https://wa.me/' + waNum + '?text=' + encodeURIComponent(text), '_blank');
    });
});
</script>
