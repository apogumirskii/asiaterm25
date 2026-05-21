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

// Инвалидация кэша page_id_by_template
add_action('save_post_page', function () {
    global $wpdb;
    $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_asiaterm_pageid_%' OR option_name LIKE '_transient_timeout_asiaterm_pageid_%'");
});
add_action('deleted_post', function () {
    global $wpdb;
    $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_asiaterm_pageid_%' OR option_name LIKE '_transient_timeout_asiaterm_pageid_%'");
});
