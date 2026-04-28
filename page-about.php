<?php /* Template Name: О нас */ get_header();
include(locate_template('template-parts/menu.php'));
include(locate_template('template-parts/phead.php'));

$about_image    = rwmb_meta('about_image', ['size' => 'large']);
$about_text     = rwmb_meta('about_text');
$about_gallery  = rwmb_meta('about_gallery', ['size' => 'costom-gallery']);
$about_features = rwmb_meta('about_features');
$about_team     = rwmb_meta('about_team');
$about_map      = rwmb_meta('about_map_embed');
?>

<!-- О компании -->
<section class="company-section py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <?php if ($about_image) :
                    $img = reset($about_image); ?>
                    <img src="<?php echo esc_url(asiaterm_webp_url_swap($img['url'])); ?>"
                         class="img-fluid company-img"
                         loading="lazy"
                         alt="<?php echo esc_attr($img['alt'] ?: get_the_title()); ?>">
                <?php elseif (has_post_thumbnail()) : ?>
                    <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>"
                         class="img-fluid company-img"
                         loading="lazy"
                         alt="<?php echo esc_attr(get_the_title()); ?>">
                <?php else : ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/files/topimg2.png"
                         class="img-fluid company-img"
                         loading="lazy"
                         alt="Asiaterm">
                <?php endif; ?>
            </div>
            <div class="col-lg-6">
                <h6 class="company-subheading"><?php bloginfo('name'); ?></h6>
                <h2 class="company-heading mb-4"><?php the_title(); ?></h2>
                <?php if ($about_text) : ?>
                    <div class="company-text mb-5"><?php echo do_shortcode(wp_kses_post($about_text)); ?></div>
                <?php else : ?>
                    <p class="company-text">Компания <strong>Asiaterm</strong> — официальный поставщик отопительного и охлаждающего оборудования от ведущих европейских производителей в Кыргызстане.</p>
                    <p class="company-text mb-5">Мы реализуем проекты любого масштаба: от частных домов до крупных коммерческих объектов. Наша команда обеспечивает полный цикл — от проектирования до монтажа и сервисного обслуживания.</p>
                <?php endif; ?>
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <a href="/contacts/" class="btn company-btn-primary">
                        <?php esc_html_e('Связаться с нами', 'asiaterm25'); ?> <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                    <?php if (get_option('my_phone')) : ?>
                    <a href="tel:<?php echo esc_attr(get_option('my_phone')); ?>" class="btn company-btn-phone">
                        <span class="company-phone-icon"><i class="fas fa-phone-alt"></i></span>
                        <?php echo esc_html(get_option('my_phone')); ?>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Преимущества -->
<section class="about-section py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <h6 class="about-subheading"><?php esc_html_e('Почему мы', 'asiaterm25'); ?></h6>
                <h2 class="about-heading mb-4"><?php esc_html_e('Наши преимущества', 'asiaterm25'); ?></h2>

                <?php
                $features = $about_features ?: [
                    ['about_feature_num' => '01.', 'about_feature_title' => 'Широкий ассортимент', 'about_feature_desc' => 'Отопительное оборудование ведущих европейских производителей для проектов любого масштаба'],
                    ['about_feature_num' => '02.', 'about_feature_title' => 'Гарантия качества', 'about_feature_desc' => 'Официальные поставки с полной сертификацией и гарантией от производителя'],
                    ['about_feature_num' => '03.', 'about_feature_title' => 'Индивидуальный расчёт', 'about_feature_desc' => 'Подбор оборудования и расчёт системы отопления под параметры вашего объекта'],
                    ['about_feature_num' => '04.', 'about_feature_title' => 'Комплексные решения', 'about_feature_desc' => 'Полный цикл: проектирование, поставка, монтаж и сервисное обслуживание'],
                ];
                ?>
                <ul class="about-list list-unstyled mb-4">
                    <?php foreach ($features as $feature) : ?>
                    <li>
                        <span class="about-num"><?php echo esc_html($feature['about_feature_num'] ?? ''); ?></span>
                        <div>
                            <h5 class="about-item-title"><?php echo esc_html($feature['about_feature_title'] ?? ''); ?></h5>
                            <p class="about-item-desc"><?php echo esc_html($feature['about_feature_desc'] ?? ''); ?></p>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <a href="/catalog/" class="btn about-btn"><?php esc_html_e('В каталог', 'asiaterm25'); ?> <i class="fas fa-arrow-right ms-2"></i></a>
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

<!-- Направления -->
<section class="features-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="section-subheading"><?php esc_html_e('Направления', 'asiaterm25'); ?></h6>
            <h2 class="section-heading"><?php esc_html_e('Наша специализация', 'asiaterm25'); ?></h2>
        </div>
        <div class="row g-0">
            <?php
            $directions = [
                ['icon' => 'fas fa-building', 'title' => 'Жилые комплексы', 'desc' => 'Проектирование и поставка систем отопления для многоквартирных домов и жилых комплексов'],
                ['icon' => 'fas fa-home', 'title' => 'Частные дома', 'desc' => 'Индивидуальные решения для загородных домов и коттеджей с учётом особенностей объекта'],
                ['icon' => 'fas fa-door-open', 'title' => 'Квартиры', 'desc' => 'Современные системы отопления для квартир: внутрипольные конвекторы и радиаторы'],
                ['icon' => 'fas fa-store', 'title' => 'Коммерческие помещения', 'desc' => 'Отопление офисов, торговых центров, ресторанов и других коммерческих объектов'],
            ];
            $last = count($directions) - 1;
            foreach ($directions as $i => $d) : ?>
            <div class="col-lg-3 col-md-6">
                <div class="feature-item text-center <?php echo $i < $last ? 'feature-divider' : ''; ?>">
                    <div class="feature-icon mb-4">
                        <i class="<?php echo esc_attr($d['icon']); ?>"></i>
                    </div>
                    <h5 class="feature-title"><?php echo esc_html($d['title']); ?></h5>
                    <p class="feature-desc"><?php echo esc_html($d['desc']); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Галерея -->
<?php if (!empty($about_gallery)) : ?>
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="section-subheading"><?php esc_html_e('Галерея', 'asiaterm25'); ?></h6>
            <h2 class="section-heading"><?php esc_html_e('Наши объекты', 'asiaterm25'); ?></h2>
        </div>
        <div class="row g-3">
            <?php foreach ($about_gallery as $img) : ?>
            <div class="col-lg-4 col-md-6">
                <a href="<?php echo esc_url(asiaterm_webp_url_swap($img['full_url'])); ?>" data-lightbox="about-gallery" data-title="<?php echo esc_attr($img['alt'] ?: ''); ?>">
                    <div class="cat-hero-img" style="height: 250px;">
                        <img src="<?php echo esc_url(asiaterm_webp_url_swap($img['url'])); ?>"
                             loading="lazy"
                             alt="<?php echo esc_attr($img['alt'] ?: 'Asiaterm'); ?>">
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Команда -->
<?php
$team = $about_team ?: [
    ['team_name' => 'Директор', 'team_position' => 'Генеральный директор', 'team_photo' => []],
    ['team_name' => 'Менеджер', 'team_position' => 'Отдел продаж', 'team_photo' => []],
    ['team_name' => 'Инженер', 'team_position' => 'Технический отдел', 'team_photo' => []],
];
if (!empty($team)) : ?>
<section class="py-5" style="background: var(--color-gray-light);">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="section-subheading"><?php esc_html_e('Команда', 'asiaterm25'); ?></h6>
            <h2 class="section-heading"><?php esc_html_e('Наша команда', 'asiaterm25'); ?></h2>
        </div>
        <div class="row g-4 justify-content-center">
            <?php foreach ($team as $member) :
                $photo = !empty($member['team_photo']) ? reset($member['team_photo']) : null;
            ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="text-center">
                    <?php if ($photo && !empty($photo['url'])) : ?>
                        <div class="cat-hero-img mb-3" style="width: 160px; height: 160px; margin: 0 auto; border-radius: 50%;">
                            <img src="<?php echo esc_url($photo['url']); ?>"
                                 style="border-radius: 50%;"
                                 loading="lazy"
                                 alt="<?php echo esc_attr($member['team_name'] ?? ''); ?>">
                        </div>
                    <?php else : ?>
                        <div class="d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 160px; height: 160px; border-radius: 50%; background: var(--color-white); box-shadow: var(--shadow-sm);">
                            <i class="fas fa-user fa-3x" style="color: var(--color-primary);"></i>
                        </div>
                    <?php endif; ?>
                    <h5 class="fw-bold mb-1"><?php echo esc_html($member['team_name'] ?? ''); ?></h5>
                    <p style="color: var(--color-primary); font-weight: 600; font-size: var(--font-size-sm);"><?php echo esc_html($member['team_position'] ?? ''); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Карта -->
<?php if ($about_map) : ?>
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="section-subheading"><?php esc_html_e('Расположение', 'asiaterm25'); ?></h6>
            <h2 class="section-heading"><?php esc_html_e('Как нас найти', 'asiaterm25'); ?></h2>
        </div>
        <div class="rounded overflow-hidden" style="min-height: 400px; box-shadow: var(--shadow-md);">
            <?php echo $about_map; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php
include(locate_template('page-top/ctasec.php'));
get_footer();
