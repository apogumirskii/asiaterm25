<?php

/**
 * Регистрация секции в Customizer "Изображения сайта" для редактирования
 * иллюстраций бренда без правки кода. Все настройки хранятся как theme_mod.
 * Helper `asiaterm_brand_image($key, $default_file)` (в inc/url-helpers.php)
 * возвращает URL пользовательской картинки или fallback из файлов темы.
 */
add_action( 'customize_register', 'asiaterm_customize_register' );
function asiaterm_customize_register( $wp_customize ) {

    $wp_customize->add_section( 'asiaterm_brand_images', [
        'title'       => __( 'Изображения сайта', 'asiaterm25' ),
        'description' => __( 'Иллюстрации блоков главной страницы и запасные изображения.', 'asiaterm25' ),
        'priority'    => 30,
    ] );

    $controls = [
        'hero_about' => [
            'label' => __( 'Hero «О компании» (главная)', 'asiaterm25' ),
            'desc'  => __( 'Картинка в секции "О нас" на главной. По умолчанию: /files/show.webp', 'asiaterm25' ),
        ],
        'utp' => [
            'label' => __( 'UTP-блок «О нас»', 'asiaterm25' ),
            'desc'  => __( 'Используется в UTP-секции на главной и на странице «Услуги». По умолчанию: /files/topimg2.png', 'asiaterm25' ),
        ],
        'slider_fallback' => [
            'label' => __( 'Запасное фото слайдера', 'asiaterm25' ),
            'desc'  => __( 'Показывается если у слайда не загружено своё фото. По умолчанию: /files/slide1.jpg', 'asiaterm25' ),
        ],
        'portfolio_fallback' => [
            'label' => __( 'Запасное фото проекта', 'asiaterm25' ),
            'desc'  => __( 'Показывается если у проекта нет фото или галереи. По умолчанию: /files/topimg2.png', 'asiaterm25' ),
        ],
    ];

    foreach ( $controls as $key => $meta ) {
        $setting_id = 'asiaterm_' . $key . '_image';

        $wp_customize->add_setting( $setting_id, [
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ] );

        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $setting_id, [
            'label'       => $meta['label'],
            'description' => $meta['desc'],
            'section'     => 'asiaterm_brand_images',
        ] ) );
    }
}

/**
 * При сохранении Customizer сбрасываем кэш portfolio listing — там
 * запекается fallback URL в JSON элементов проектов.
 */
add_action( 'customize_save_after', function () {
    delete_transient( 'asiaterm_portfolio_listing_v1' );
} );
