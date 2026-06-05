<?php
/**
 * Секция «О компании» на главной.
 * Источник изображений (приоритет):
 *   1) front_about_gallery (Meta Box страницы с шаблоном TopPage) — карусель, если 2+ фото
 *   2) Customizer asiaterm_hero_about_image — одна картинка
 *   3) /files/show.webp — fallback
 */
$front_page_id = (int) get_option( 'page_on_front' );
$about_gallery = $front_page_id
    ? rwmb_meta( 'front_about_gallery', [ 'object_type' => 'post' ], $front_page_id )
    : [];
$about_gallery = is_array( $about_gallery ) ? array_values( $about_gallery ) : [];
$gallery_count = count( $about_gallery );
?>
<section class="company-section py-5">
    <div class="container">
        <div class="row g-5 align-items-center">

            <div class="col-lg-6">
                <?php if ( $gallery_count > 1 ) : ?>
                    <!-- Карусель из 2+ фото -->
                    <div class="swiper swiper-about-gallery">
                        <div class="swiper-wrapper">
                            <?php foreach ( $about_gallery as $img ) : ?>
                                <div class="swiper-slide about-gallery-slide">
                                    <?php echo asiaterm_picture_tag(
                                        (int) $img['ID'],
                                        'about-gallery',
                                        'about-gallery-mob',
                                        [
                                            'alt'   => $img['alt'] ?? '',
                                            'class' => 'about-gallery-img',
                                        ]
                                    ); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="swiper-pagination about-gallery-pagination"></div>
                    </div>
                <?php elseif ( $gallery_count === 1 ) : ?>
                    <!-- Одно фото из Meta Box -->
                    <?php $img = $about_gallery[0]; ?>
                    <?php echo asiaterm_picture_tag(
                        (int) $img['ID'],
                        'about-gallery',
                        'about-gallery-mob',
                        [
                            'alt'     => $img['alt'] ?? 'Asiaterm',
                            'class'   => 'company-img-wrap',
                            'loading' => 'eager',
                        ]
                    ); ?>
                <?php else : ?>
                    <!-- Customizer / fallback -->
                    <?php
                    $custom_id  = asiaterm_brand_image_id( 'hero_about' );
                    $hero_url   = asiaterm_brand_image( 'hero_about', 'files/show.webp' );
                    $hero_arg   = $custom_id ?: $hero_url;
                    echo asiaterm_picture_tag(
                        $hero_arg,
                        'about-gallery',
                        'about-gallery-mob',
                        [
                            'alt'     => 'Asiaterm',
                            'class'   => 'company-img-wrap',
                            'loading' => 'eager',
                        ]
                    );
                    ?>
                <?php endif; ?>
            </div>

            <div class="col-lg-6">
                <h6 class="company-subheading">ОсОО АЗИЯ ТЕРМ</h6>
                <h2 class="company-heading mb-4">О нас</h2>

                <p class="company-text">Азия терм — Ваш надежный партнёр в мире инновационного отопления.</p>
                <p class="company-text mb-5">Мы предлагаем точные расчёты, обеспечиваем надёжное и эффективное отопление вашего дома или бизнеса по всей территории Кыргызской Республики.</p>

                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <a href="<?php echo esc_url( asiaterm_url( 'about' ) ); ?>" class="btn company-btn-primary">
                        Подробнее <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                    <a href="tel:<?php echo esc_attr( get_option( 'my_phone' ) ); ?>" class="btn company-btn-phone">
                        <span class="company-phone-icon"><i class="fas fa-phone-alt"></i></span>
                        <?php echo esc_html( get_option( 'my_phone' ) ); ?>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
