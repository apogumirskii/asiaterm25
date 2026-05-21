<?php
$slides = new WP_Query([
    'post_type'      => 'sliderims',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => ['menu_order' => 'ASC', 'date' => 'ASC'],
    'no_found_rows'  => true,
]);

$promo_page = asiaterm_portfolio_page();
$promo_url  = $promo_page ? get_permalink($promo_page->ID) : home_url('/');
?>

<section class="hero-slider">
    <div class="swiper swiper-hero">
        <div class="swiper-wrapper">
        <?php if ($slides->have_posts()) : while ($slides->have_posts()) : $slides->the_post();
            $sid       = get_the_ID();
            $head      = get_post_meta($sid, 'sliderhead', true) ?: get_the_title();
            $text      = get_post_meta($sid, 'slidertext', true);
            $btntext   = get_post_meta($sid, 'sliderbtntext', true) ?: 'В каталог';
            $link_id   = get_post_meta($sid, 'sliderlink', true);
            $link_url  = $link_id ? get_permalink($link_id) : '#';
            $file_id   = get_post_meta($sid, 'sliderfile', true);
            $file_type = $file_id ? get_post_mime_type($file_id) : '';
            $is_video  = $file_id && strpos($file_type, 'video') !== false;
            if ($is_video) {
                $file_url = wp_get_attachment_url($file_id);
                $file_mob = '';
            } else {
                $file_url = $file_id ? wp_get_attachment_image_url($file_id, 'slider-desc') : get_the_post_thumbnail_url($sid, 'slider-desc');
                $file_mob = $file_id ? wp_get_attachment_image_url($file_id, 'slider-mob')  : get_the_post_thumbnail_url($sid, 'slider-mob');
            }
        ?>
        <div class="swiper-slide hero-slide">
            <div class="hero-slide-media">
                <?php if ($is_video) : ?>
                    <video autoplay muted loop playsinline>
                        <source src="<?php echo esc_url($file_url); ?>" type="<?php echo esc_attr($file_type); ?>">
                    </video>
                <?php else : ?>
                    <picture>
                        <?php if ($file_mob) : ?>
                            <source media="(max-width: 768px)" srcset="<?php echo esc_url($file_mob); ?>">
                        <?php endif; ?>
                        <img src="<?php echo esc_url($file_url ?: get_template_directory_uri() . '/files/slide1.jpg'); ?>" alt="<?php echo esc_attr($head); ?>">
                    </picture>
                <?php endif; ?>
                <span class="hero-slide-tint"></span>
            </div>

            <div class="hero-slide-inner">
                <div class="container">
                <div class="hero-slide-text">
                    <?php if ($text) : ?>
                        <p class="hero-slide-sub"><?php echo esc_html($text); ?></p>
                    <?php endif; ?>
                    <?php if ($head) : ?>
                        <h2 class="hero-slide-title"><?php echo esc_html($head); ?></h2>
                    <?php endif; ?>
                    <?php if ($btntext) : ?>
                        <a href="<?php echo esc_url($link_url); ?>" class="hero-slide-cta">
                            <?php echo esc_html($btntext); ?> <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    <?php endif; ?>
                </div>
                </div>
            </div>
        </div>
        <?php endwhile; wp_reset_postdata();
        else : ?>
        <div class="swiper-slide hero-slide">
            <div class="hero-slide-media">
                <img src="<?php echo get_template_directory_uri(); ?>/files/slide1.jpg" alt="">
                <span class="hero-slide-tint"></span>
            </div>
            <div class="hero-slide-inner">
                <div class="container">
                <div class="hero-slide-text">
                    <p class="hero-slide-sub">Asiaterm</p>
                    <h2 class="hero-slide-title">Комплексное отопление и охлаждение</h2>
                    <a href="<?php echo esc_url(get_permalink(13) ?: home_url('/')); ?>" class="hero-slide-cta">
                        В каталог <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        </div>
    </div>

    <div class="hero-bullets" id="heroBullets"></div>

    <div class="hero-promo-wrap">
        <div class="container">
            <div class="hero-promo-box">
                <h4>Наши <span>реализованные проекты</span> отопления</h4>
                <a href="<?php echo esc_url($promo_url); ?>" class="hero-promo-link">
                    <?php esc_html_e('Подробнее', 'asiaterm25'); ?> <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</section>
