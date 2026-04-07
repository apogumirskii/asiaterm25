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
<section id="about" class="py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 mb-4">
                <?php if ($about_image) :
                    $img = reset($about_image); ?>
                    <img src="<?php echo esc_url($img['url']); ?>"
                         class="img-fluid rounded shadow"
                         loading="lazy"
                         alt="<?php echo esc_attr($img['alt'] ?: get_the_title()); ?>">
                <?php elseif (has_post_thumbnail()) : ?>
                    <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>"
                         class="img-fluid rounded shadow"
                         loading="lazy"
                         alt="<?php echo esc_attr(get_the_title()); ?>">
                <?php else : ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/files/topimg2.png"
                         class="img-fluid rounded shadow"
                         loading="lazy"
                         alt="Asiaterm">
                <?php endif; ?>
            </div>
            <div class="col-lg-6">
                <h6 class="about-subheading" style="color: var(--color-primary); font-weight: 600; text-transform: uppercase; letter-spacing: 2px;"><?php bloginfo('name'); ?></h6>
                <h2 class="about-heading mb-4" style="font-size: var(--font-size-2xl); font-weight: 800; line-height: 1.3;"><?php the_title(); ?></h2>
                <?php if ($about_text) : ?>
                    <div class="about-content mb-4" style="color: var(--color-text); line-height: 1.8;">
                        <?php echo do_shortcode(wp_kses_post($about_text)); ?>
                    </div>
                <?php else : ?>
                    <div class="about-content mb-4" style="color: var(--color-text); line-height: 1.8;">
                        <p>Компания <strong>Asiaterm</strong> — официальный поставщик отопительного и охлаждающего оборудования от ведущих европейских производителей в Кыргызстане.</p>
                        <p>Мы реализуем проекты любого масштаба: от частных домов до крупных коммерческих объектов. Наша команда обеспечивает полный цикл — от проектирования до монтажа и сервисного обслуживания.</p>
                    </div>
                <?php endif; ?>
                <a href="/contacts/" class="btn about-btn"><?php esc_html_e('Связаться с нами', 'asiaterm25'); ?> <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Преимущества -->
<?php
$features = $about_features ?: [
    ['about_feature_num' => '01.', 'about_feature_title' => 'Широкий ассортимент', 'about_feature_desc' => 'Отопительное оборудование ведущих европейских производителей для проектов любого масштаба'],
    ['about_feature_num' => '02.', 'about_feature_title' => 'Гарантия качества', 'about_feature_desc' => 'Официальные поставки с полной сертификацией и гарантией от производителя'],
    ['about_feature_num' => '03.', 'about_feature_title' => 'Индивидуальный расчёт', 'about_feature_desc' => 'Подбор оборудования и расчёт системы отопления под параметры вашего объекта'],
    ['about_feature_num' => '04.', 'about_feature_title' => 'Комплексные решения', 'about_feature_desc' => 'Полный цикл: проектирование, поставка, монтаж и сервисное обслуживание'],
];
?>
<section class="about-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="section-subheading"><?php esc_html_e('Почему мы', 'asiaterm25'); ?></h6>
            <h2 class="section-heading"><?php esc_html_e('Наши преимущества', 'asiaterm25'); ?></h2>
        </div>
        <div class="row g-4">
            <?php foreach ($features as $feature) : ?>
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 text-center p-4 border-0 shadow-sm">
                    <div class="mb-3">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 60px; height: 60px; background: rgba(232, 98, 26, 0.1); color: var(--color-primary); font-size: 1.5rem; font-weight: 800;">
                            <?php echo esc_html($feature['about_feature_num'] ?? ''); ?>
                        </span>
                    </div>
                    <h5 class="fw-bold"><?php echo esc_html($feature['about_feature_title'] ?? ''); ?></h5>
                    <p class="text-muted mb-0"><?php echo esc_html($feature['about_feature_desc'] ?? ''); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Галерея -->
<?php
$gallery = $about_gallery ?: [];
if (!empty($gallery)) : ?>
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="section-subheading"><?php esc_html_e('Галерея', 'asiaterm25'); ?></h6>
            <h2 class="section-heading"><?php esc_html_e('Наши объекты', 'asiaterm25'); ?></h2>
        </div>
        <div class="row g-3">
            <?php foreach ($gallery as $img) : ?>
            <div class="col-lg-4 col-md-6">
                <a href="<?php echo esc_url($img['full_url']); ?>" data-lightbox="about-gallery" data-title="<?php echo esc_attr($img['alt'] ?: ''); ?>">
                    <div class="rounded overflow-hidden shadow-sm" style="height: 250px;">
                        <img src="<?php echo esc_url($img['url']); ?>"
                             class="w-100 h-100"
                             style="object-fit: cover;"
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
    ['team_name' => 'Менеджер проектов', 'team_position' => 'Проектный отдел', 'team_photo' => []],
    ['team_name' => 'Инженер', 'team_position' => 'Технический отдел', 'team_photo' => []],
];
?>
<section class="py-5 bg-light">
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
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="p-3">
                        <?php if ($photo && !empty($photo['url'])) : ?>
                            <img src="<?php echo esc_url($photo['url']); ?>"
                                 class="rounded-circle mb-3"
                                 style="width: 120px; height: 120px; object-fit: cover;"
                                 loading="lazy"
                                 alt="<?php echo esc_attr($member['team_name'] ?? ''); ?>">
                        <?php else : ?>
                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3"
                                 style="width: 120px; height: 120px;">
                                <i class="fas fa-user fa-3x text-muted"></i>
                            </div>
                        <?php endif; ?>
                        <h5 class="fw-bold mb-1"><?php echo esc_html($member['team_name'] ?? ''); ?></h5>
                        <p class="text-muted mb-0"><?php echo esc_html($member['team_position'] ?? ''); ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Карта -->
<?php if ($about_map) : ?>
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="section-subheading"><?php esc_html_e('Расположение', 'asiaterm25'); ?></h6>
            <h2 class="section-heading"><?php esc_html_e('Как нас найти', 'asiaterm25'); ?></h2>
        </div>
        <div class="rounded overflow-hidden shadow" style="min-height: 400px;">
            <?php echo $about_map; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php
include(locate_template('page-top/ctasec.php'));
get_footer();
