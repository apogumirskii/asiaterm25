<?php
$slides = new WP_Query([
    'post_type'      => 'sliderims',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
]);
?>

<section class="hero-slider">

    <div class="owl-carousel owl-hero">
        <?php if ($slides->have_posts()) : while ($slides->have_posts()) : $slides->the_post();
            $head     = get_post_meta(get_the_ID(), 'sliderhead', true);
            $text     = get_post_meta(get_the_ID(), 'slidertext', true);
            $btntext  = get_post_meta(get_the_ID(), 'sliderbtntext', true) ?: 'В каталог';
            $link_id  = get_post_meta(get_the_ID(), 'sliderlink', true);
            $link_url = $link_id ? get_permalink($link_id) : '#';
            $file_id   = get_post_meta(get_the_ID(), 'sliderfile', true);
            $file_url  = $file_id ? wp_get_attachment_url($file_id) : get_the_post_thumbnail_url(get_the_ID(), 'slider-desc');
            $file_mob  = $file_id ? wp_get_attachment_image_url($file_id, 'slider-mob') : get_the_post_thumbnail_url(get_the_ID(), 'slider-mob');
            $file_type = $file_id ? get_post_mime_type($file_id) : '';
        ?>
        <div class="hero-slide">
            <div class="hero-slide-bg">
                <?php if (strpos($file_type, 'video') !== false) : ?>
                    <video autoplay muted loop playsinline>
                        <source src="<?php echo esc_url($file_url); ?>" type="<?php echo esc_attr($file_type); ?>">
                    </video>
                <?php else : ?>
                    <picture>
                        <?php if ($file_mob) : ?>
                            <source media="(max-width: 768px)" srcset="<?php echo esc_url($file_mob); ?>">
                        <?php endif; ?>
                        <img src="<?php echo esc_url($file_url ?: get_template_directory_uri() . '/files/slide1.jpg'); ?>" alt="<?php the_title(); ?>">
                    </picture>
                <?php endif; ?>
            </div>
            <div class="hero-slide-overlay"></div>
            <div class="container h-100">
                <div class="hero-slide-content">
                    <?php if ($text) : ?>
                        <h6 class="hero-subheading"><?php echo esc_html($text); ?></h6>
                    <?php endif; ?>
                    <?php if ($head) : ?>
                        <h2 class="hero-heading"><?php echo esc_html($head); ?></h2>
                    <?php endif; ?>
                    <a href="<?php echo esc_url($link_url); ?>" class="btn hero-slider-btn">
                        <?php echo esc_html($btntext); ?> <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
        <?php endwhile; wp_reset_postdata();
        else : ?>
        <!-- Заглушка -->
        <?php
        $stub_slides = [
            ['sub' => 'Внутрипольные конвекторы', 'title' => 'Стиль и практичность',         'img' => '/files/slide1.jpg'],
            ['sub' => 'Фанкойлы',                  'title' => 'Охлаждение и обогрев',          'img' => '/files/slide2.jpg'],
            ['sub' => 'Отопительные котлы',        'title' => 'Прямые поставки',               'img' => '/files/slide3.jpg'],
            ['sub' => 'Тепловые насосы',           'title' => 'Экономия и практичность',       'img' => '/files/slide4.jpg'],
        ];
        foreach ($stub_slides as $s) : ?>
        <div class="hero-slide">
            <div class="hero-slide-bg">
                <img src="<?php echo get_template_directory_uri() . $s['img']; ?>" alt="">
            </div>
            <div class="hero-slide-overlay"></div>
            <div class="container h-100">
                <div class="hero-slide-content">
                    <h6 class="hero-subheading"><?php echo esc_html($s['sub']); ?></h6>
                    <h2 class="hero-heading"><?php echo esc_html($s['title']); ?></h2>
                    <a href="#" class="btn hero-slider-btn">В каталог <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
        <?php endforeach; endif; ?>
    </div>

    <!-- Нумерация -->
    <div class="hero-bullets" id="heroBullets"></div>

    <!-- Блок поверх слайдера -->
    <?php
    $promo_pages = get_pages(['meta_key' => '_wp_page_template', 'meta_value' => 'page-portfolio.php']);
    $promo_url = $promo_pages ? get_permalink($promo_pages[0]->ID) : home_url('/');
    ?>
    <div class="hero-promo-box">
        <h4>Наши <span>реализованные проекты</span> отопления</h4>
        <a href="<?php echo esc_url($promo_url); ?>" class="hero-promo-link">
            <?php esc_html_e('Подробнее', 'asiaterm25'); ?> <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </div>

</section>

