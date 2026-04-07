<?php /* Template Name: О нас */ get_header();
include(locate_template('template-parts/menu.php'));
include(locate_template('template-parts/phead.php'));

$about_image    = rwmb_meta('about_image', ['size' => 'large']);
$about_text     = rwmb_meta('about_text');
$about_features = rwmb_meta('about_features');
?>

<section id="about" class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title"><?php the_title(); ?></h2>
        <div class="row align-items-center g-5">
            <div class="col-lg-6 mb-4">
                <?php if ($about_image) :
                    $img = reset($about_image); ?>
                    <img src="<?php echo esc_url($img['url']); ?>"
                         class="img-fluid rounded"
                         loading="lazy"
                         alt="<?php echo esc_attr($img['alt'] ?: get_the_title()); ?>">
                <?php elseif (has_post_thumbnail()) : ?>
                    <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>"
                         class="img-fluid rounded"
                         loading="lazy"
                         alt="<?php echo esc_attr(get_the_title()); ?>">
                <?php endif; ?>
            </div>
            <div class="col-lg-6">
                <?php if ($about_text) : ?>
                    <div class="about-content mb-4">
                        <?php echo do_shortcode(wp_kses_post($about_text)); ?>
                    </div>
                <?php else : ?>
                    <div class="about-content mb-4">
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php
$features = $about_features ?: [
    ['about_feature_num' => '01.', 'about_feature_title' => 'Широкий ассортимент', 'about_feature_desc' => 'Отопительное оборудование ведущих европейских производителей для проектов любого масштаба'],
    ['about_feature_num' => '02.', 'about_feature_title' => 'Гарантия качества', 'about_feature_desc' => 'Официальные поставки с полной сертификацией и гарантией от производителя'],
    ['about_feature_num' => '03.', 'about_feature_title' => 'Индивидуальный расчёт', 'about_feature_desc' => 'Подбор оборудования и расчёт системы отопления под параметры вашего объекта'],
    ['about_feature_num' => '04.', 'about_feature_title' => 'Комплексные решения', 'about_feature_desc' => 'Полный цикл: проектирование, поставка, монтаж и сервисное обслуживание'],
];
?>
<section class="about-section py-5">
    <div class="container">
        <div class="row g-5 align-items-start">
            <div class="col-lg-12">
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
            </div>
        </div>
    </div>
</section>

<?php
include(locate_template('page-top/ctasec.php'));
get_footer();
