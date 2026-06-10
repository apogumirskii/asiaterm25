<?php

/**
 * Хелперы для динамического получения URL системных страниц по их шаблону.
 * Все результаты кэшируются в transient на сутки и инвалидируются при save_post_page.
 *
 * Использование:
 *   asiaterm_url('contact')     // страница с шаблоном page-contact.php
 *   asiaterm_url('about')       // page-about.php
 *   asiaterm_url('services')    // page-services.php
 *   asiaterm_url('catalog')     // page-catalog.php  ИЛИ страница ID 13
 *   asiaterm_url('certificates')// page-certificates.php
 *   asiaterm_url('reviews')     // page-reviews.php
 *   asiaterm_url('partners')    // page-partners.php
 *   asiaterm_url('portfolio')   // page-portfolio.php
 *   asiaterm_url('sitemap')     // page-sitemap.php
 *   asiaterm_url('oferta')      // ID из настройки my_oferta_page_id
 *   asiaterm_url('faq')         // ID из настройки my_faq_page_id
 */

function asiaterm_page_id_by_template($template_file) {
    $key = 'asiaterm_pageid_' . sanitize_key(str_replace('.php', '', $template_file));
    $cached = get_transient($key);
    if ($cached !== false) return (int) $cached ?: 0;

    $pages = get_pages([
        'meta_key'    => '_wp_page_template',
        'meta_value'  => $template_file,
        'post_status' => 'publish',
        'number'      => 1,
    ]);
    $id = $pages ? (int) $pages[0]->ID : 0;
    set_transient($key, $id ?: 0, DAY_IN_SECONDS);
    return $id;
}

/**
 * Главная функция получения URL системной страницы.
 *
 * @param string $key  Ключ страницы (catalog, contact, about, …)
 * @param string $fallback  URL fallback, по умолчанию главная
 * @return string
 */
function asiaterm_url($key, $fallback = null) {
    $fallback = $fallback ?: home_url('/');
    $id = 0;

    switch ($key) {
        // Каталог: сначала ID 13 (исторический), иначе шаблон
        case 'catalog':
            $id = 13;
            if (!get_post($id)) {
                $id = asiaterm_page_id_by_template('page-catalog.php');
            }
            break;

        case 'contact':       $id = asiaterm_page_id_by_template('page-contact.php');      break;
        case 'about':         $id = asiaterm_page_id_by_template('page-about.php');        break;
        case 'services':      $id = asiaterm_page_id_by_template('page-services.php');     break;
        case 'certificates':  $id = asiaterm_page_id_by_template('page-certificates.php'); break;
        case 'reviews':       $id = asiaterm_page_id_by_template('page-reviews.php');      break;
        case 'partners':      $id = asiaterm_page_id_by_template('page-partners.php');     break;
        case 'portfolio':     $id = asiaterm_page_id_by_template('page-portfolio.php');    break;
        case 'sitemap':       $id = asiaterm_page_id_by_template('page-sitemap.php');      break;

        // Произвольные страницы — ID берётся из настроек Settings → General
        case 'oferta':        $id = (int) get_option('my_oferta_page_id');  break;
        case 'faq':           $id = (int) get_option('my_faq_page_id');     break;
    }

    if ($id && get_post_status($id) === 'publish') {
        return get_permalink($id);
    }
    return $fallback;
}

/**
 * Получить URL бренд-изображения из Customizer или fallback из файлов темы.
 *
 * @param string $key           Ключ без префикса: hero_about, utp, slider_fallback, portfolio_fallback
 * @param string $default_file  Относительный путь fallback внутри темы, например 'files/show.webp'
 * @return string URL
 */
function asiaterm_brand_image($key, $default_file = '') {
    $custom = get_theme_mod('asiaterm_' . $key . '_image', '');
    if ($custom) return $custom;
    return $default_file
        ? get_template_directory_uri() . '/' . ltrim($default_file, '/')
        : '';
}

/**
 * URL логотипа темы с cache-bust по filemtime.
 * При любом изменении файла logo.svg версия в URL меняется → браузеры
 * подтягивают свежий файл (имя файла остаётся прежним).
 */
function asiaterm_logo_url() {
    $rel  = '/files/asiatermkg-logo.svg';
    $uri  = get_template_directory_uri() . $rel;
    $path = get_template_directory() . $rel;
    if (file_exists($path)) {
        $uri = add_query_arg('ver', filemtime($path), $uri);
    }
    return $uri;
}

/**
 * Получить attachment ID бренд-изображения из Customizer (если загружено из медиатеки).
 * Нужно для wp_get_attachment_image_src(): возвращает 0 если в Customizer прямой URL,
 * не из медиабиблиотеки, либо не задано.
 */
function asiaterm_brand_image_id($key) {
    $url = get_theme_mod('asiaterm_' . $key . '_image', '');
    if (!$url) return 0;
    return (int) attachment_url_to_postid($url);
}

/**
 * Универсальный рендер <picture> с desktop/mobile <source> и WebP swap.
 *
 * @param int|string $attachment   Attachment ID, либо прямой URL (для fallback из /files/)
 * @param string     $size_desktop Зарегистрированный image size, например 'about-hero'
 * @param string     $size_mobile  Image size для мобильного <source>, например 'about-hero-mob'
 * @param array      $args         ['alt', 'class', 'loading', 'mobile_breakpoint', 'sizes']
 * @return string HTML
 */
function asiaterm_picture_tag($attachment, $size_desktop = 'large', $size_mobile = '', $args = []) {
    $defaults = [
        'alt'               => '',
        'class'             => '',
        'loading'           => 'lazy',
        'mobile_breakpoint' => 768,
        'sizes'             => '',
    ];
    $args = array_merge($defaults, $args);

    $desktop = '';
    $mobile  = '';
    $alt     = $args['alt'];

    if (is_numeric($attachment) && (int) $attachment > 0) {
        $att_id  = (int) $attachment;
        $desktop = wp_get_attachment_image_url($att_id, $size_desktop);
        if ($size_mobile) {
            $mobile = wp_get_attachment_image_url($att_id, $size_mobile);
        }
        if (!$alt) {
            $alt = get_post_meta($att_id, '_wp_attachment_image_alt', true);
        }
    } else {
        // Прямой URL (Customizer URL без media-attachment или хардкод-fallback)
        $desktop = is_string($attachment) ? $attachment : '';
    }

    if (!$desktop) return '';

    // WebP swap уже встроен в фильтры WordPress (wp_get_attachment_image_url),
    // но для прямых URL прогоним вручную:
    if (function_exists('asiaterm_webp_url_swap')) {
        $desktop = asiaterm_webp_url_swap($desktop);
        if ($mobile) $mobile = asiaterm_webp_url_swap($mobile);
    }

    $cls = $args['class'] ? ' class="' . esc_attr($args['class']) . '"' : '';
    $sizes_attr = $args['sizes'] ? ' sizes="' . esc_attr($args['sizes']) . '"' : '';

    ob_start();
    ?>
    <picture<?php echo $cls; ?>>
        <?php if ($mobile) : ?>
        <source media="(max-width: <?php echo (int) $args['mobile_breakpoint']; ?>px)" srcset="<?php echo esc_url($mobile); ?>">
        <?php endif; ?>
        <img src="<?php echo esc_url($desktop); ?>"
             alt="<?php echo esc_attr($alt); ?>"
             loading="<?php echo esc_attr($args['loading']); ?>"<?php echo $sizes_attr; ?>>
    </picture>
    <?php
    return ob_get_clean();
}

// Инвалидация кэша page_id_by_template
add_action('save_post_page', function () {
    global $wpdb;
    $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_asiaterm_pageid_%' OR option_name LIKE '_transient_timeout_asiaterm_pageid_%'");
});
add_action('deleted_post', function () {
    global $wpdb;
    $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_asiaterm_pageid_%' OR option_name LIKE '_transient_timeout_asiaterm_pageid_%'");
});
