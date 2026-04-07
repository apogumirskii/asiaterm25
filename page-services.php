<?php /* Template Name: Услуги */ get_header();
include(locate_template('template-parts/menu.php'));
include(locate_template('template-parts/phead.php'));

$services = rwmb_meta('services_list');

$services_list = $services ?: [
    [
        'service_icon'  => 'fas fa-building',
        'service_title' => 'Жилые комплексы',
        'service_desc'  => 'Проектирование и поставка систем отопления для многоквартирных домов и жилых комплексов. Внутрипольные конвекторы, радиаторы, тёплые полы.',
        'service_link'  => '',
        'service_image' => [],
    ],
    [
        'service_icon'  => 'fas fa-home',
        'service_title' => 'Частные дома',
        'service_desc'  => 'Индивидуальные решения для загородных домов и коттеджей. Подбор котлов, радиаторов и конвекторов с учётом площади и особенностей объекта.',
        'service_link'  => '',
        'service_image' => [],
    ],
    [
        'service_icon'  => 'fas fa-door-open',
        'service_title' => 'Квартиры',
        'service_desc'  => 'Современные системы отопления для квартир: компактные внутрипольные конвекторы, дизайнерские радиаторы и полотенцесушители.',
        'service_link'  => '',
        'service_image' => [],
    ],
    [
        'service_icon'  => 'fas fa-store',
        'service_title' => 'Коммерческие помещения',
        'service_desc'  => 'Отопление офисов, торговых центров, ресторанов. Мощные конвекторы для панорамного остекления и тепловые завесы.',
        'service_link'  => '',
        'service_image' => [],
    ],
    [
        'service_icon'  => 'fas fa-drafting-compass',
        'service_title' => 'Проектирование',
        'service_desc'  => 'Расчёт тепловых нагрузок и проектирование систем отопления. Подбор оборудования под технические требования объекта.',
        'service_link'  => '',
        'service_image' => [],
    ],
    [
        'service_icon'  => 'fas fa-tools',
        'service_title' => 'Сервисное обслуживание',
        'service_desc'  => 'Гарантийное и постгарантийное обслуживание поставленного оборудования. Запасные части и комплектующие.',
        'service_link'  => '',
        'service_image' => [],
    ],
];
?>

<!-- Заголовок -->
<section class="company-section py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <img src="<?php echo get_template_directory_uri(); ?>/files/topimg2.png"
                     class="img-fluid company-img"
                     loading="lazy"
                     alt="Asiaterm Services">
            </div>
            <div class="col-lg-6">
                <h6 class="company-subheading"><?php bloginfo('name'); ?></h6>
                <h2 class="company-heading mb-4"><?php the_title(); ?></h2>
                <p class="company-text mb-5">Компания Asiaterm предоставляет полный комплекс услуг в сфере отопления и охлаждения — от проектирования и подбора оборудования до монтажа и сервисного обслуживания.</p>
                <a href="/contacts/" class="btn company-btn-primary">
                    <?php esc_html_e('Связаться с нами', 'asiaterm25'); ?> <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Услуги -->
<section class="features-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="section-subheading"><?php esc_html_e('Что мы делаем', 'asiaterm25'); ?></h6>
            <h2 class="section-heading"><?php esc_html_e('Наши направления', 'asiaterm25'); ?></h2>
        </div>
        <div class="row g-0">
            <?php
            $last = count($services_list) - 1;
            foreach ($services_list as $i => $service) :
                $icon  = $service['service_icon'] ?? 'fas fa-cog';
                $title = $service['service_title'] ?? '';
                $desc  = $service['service_desc'] ?? '';
                $link  = $service['service_link'] ?? '';
                $images = $service['service_image'] ?? [];
            ?>
            <div class="col-lg-4 col-md-6">
                <div class="feature-item text-center <?php echo ($i % 3 !== 2) ? 'feature-divider' : ''; ?>">
                    <div class="feature-icon mb-4">
                        <i class="<?php echo esc_attr($icon); ?>"></i>
                    </div>
                    <h5 class="feature-title"><?php echo esc_html($title); ?></h5>
                    <p class="feature-desc"><?php echo esc_html(wp_strip_all_tags($desc)); ?></p>
                    <?php if ($link) : ?>
                        <a href="<?php echo esc_url($link); ?>" class="feature-link">
                            <?php esc_html_e('Подробнее', 'asiaterm25'); ?> <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Преимущества -->
<section class="about-section py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <h6 class="about-subheading"><?php esc_html_e('Почему мы', 'asiaterm25'); ?></h6>
                <h2 class="about-heading mb-4"><?php esc_html_e('Преимущества работы с нами', 'asiaterm25'); ?></h2>
                <ul class="about-list list-unstyled mb-4">
                    <li>
                        <span class="about-num">01.</span>
                        <div>
                            <h5 class="about-item-title"><?php esc_html_e('Официальный дилер', 'asiaterm25'); ?></h5>
                            <p class="about-item-desc"><?php esc_html_e('Прямые поставки от европейских производителей с полной гарантией', 'asiaterm25'); ?></p>
                        </div>
                    </li>
                    <li>
                        <span class="about-num">02.</span>
                        <div>
                            <h5 class="about-item-title"><?php esc_html_e('Бесплатный расчёт', 'asiaterm25'); ?></h5>
                            <p class="about-item-desc"><?php esc_html_e('Профессиональный подбор оборудования под параметры вашего объекта', 'asiaterm25'); ?></p>
                        </div>
                    </li>
                    <li>
                        <span class="about-num">03.</span>
                        <div>
                            <h5 class="about-item-title"><?php esc_html_e('Монтаж и пуско-наладка', 'asiaterm25'); ?></h5>
                            <p class="about-item-desc"><?php esc_html_e('Квалифицированный монтаж сертифицированными специалистами', 'asiaterm25'); ?></p>
                        </div>
                    </li>
                </ul>
                <a href="/contacts/" class="btn about-btn"><?php esc_html_e('Оставить заявку', 'asiaterm25'); ?> <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
            <div class="col-lg-6 text-center">
                <img src="<?php echo get_template_directory_uri(); ?>/files/topimg2.png"
                     class="img-fluid about-img"
                     loading="lazy"
                     alt="Asiaterm">
            </div>
        </div>
    </div>
</section>

<?php
include(locate_template('page-top/ctasec.php'));
get_footer();
