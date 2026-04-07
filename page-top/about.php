<section class="company-section py-5">
    <div class="container">
        <div class="row g-5 align-items-center">

            <div class="col-lg-6">
                <img src="<?php echo get_template_directory_uri(); ?>/files/show.webp"
                     class="img-fluid company-img"
                     alt="Азия Терм">
            </div>

            <div class="col-lg-6">
                <h6 class="company-subheading">ОсОО АЗИЯ ТЕРМ</h6>
                <h2 class="company-heading mb-4">О нас</h2>

                <p class="company-text">Азия терм - Ваш надежный партнер в мире инновационного отопления.</p>
                <p class="company-text mb-5">Мы предлагаем точные расчеты, обеспечиваем надежное и эффективное отопление вашего дома или бизнеса, по все территории Кыргызской Республики</p>

                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <a href="/about-us/" class="btn company-btn-primary">
                        Подробнее <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                    <a href="tel:<?php echo esc_attr(get_option('my_phone')); ?>" class="btn company-btn-phone">
                        <span class="company-phone-icon"><i class="fas fa-phone-alt"></i></span>
                        <?php echo esc_html(get_option('my_phone')); ?>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<style>

</style>