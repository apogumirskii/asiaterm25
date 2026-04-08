<footer class="site-footer pt-5 pb-3">
    <div class="container">
        <div class="row g-5">

            <!-- Лого и контакты -->
            <div class="col-lg-3 col-md-6">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="d-inline-block mb-3">
                    <img src="<?php echo get_template_directory_uri(); ?>/files/logotest.svg" alt="<?php bloginfo('name'); ?>" height="50">
                </a>
                <p class="footer-desc mb-4">Крупнейший официальный диллер Европейского оборудования</p>
                <a href="tel:<?php echo esc_attr(get_option('my_phone')); ?>" class="d-flex align-items-center gap-2 footer-phone text-decoration-none mb-4">
                    <i class="fas fa-phone-alt"></i>
                    <span><?php echo esc_html(get_option('my_phone')); ?></span>
                </a>
                <div class="d-flex gap-3">
                    <?php $wa = get_option('my_whatsapp') ?: get_option('my_phone'); if ($wa) : ?>
                        <a href="https://wa.me/<?php echo preg_replace('/\D/', '', $wa); ?>" target="_blank" class="footer-social"><i class="fab fa-whatsapp"></i></a>
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

            <!-- О компании -->
            <div class="col-lg-4 col-md-6">
                <h6 class="footer-heading mb-4">О компании</h6>
                <div class="row">
                    <div class="col-6">
                        <ul class="list-unstyled footer-menu">
                            <li><a href="#">Новости</a></li>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">Контакты</a></li>
                            <li><a href="#">Отзывы</a></li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="list-unstyled footer-menu">
                            <li><a href="#">Каталог</a></li>
                            <li><a href="#">Галлерея</a></li>
                            <li><a href="#">О нас</a></li>
                            <li><a href="#">Новости</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Обратный звонок -->
            <div class="col-lg-4 col-md-12 ms-auto">
                <h6 class="footer-heading mb-4">Обратный звонок</h6>
                <form class="footer-callback-form">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control footer-input" placeholder="Ваш WhatsApp..">
                        <button class="btn footer-submit-btn" type="submit">
                            <i class="fab fa-telegram"></i>
                        </button>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input footer-check" type="checkbox" id="footerAgree" required>
                        <label class="form-check-label footer-check-label" for="footerAgree">
                            I have read and agree to the <a href="#">terms &amp; conditions</a>
                        </label>
                    </div>
                </form>
            </div>

        </div>

        <hr class="footer-divider mt-5">

        <div class="text-center footer-copy">
            © All Rights Reserved - <?php echo date('Y'); ?> - <a href="<?php echo esc_url(home_url('/')); ?>">IMS Bishkek</a>
        </div>
    </div>
</footer>

<style>

</style>
