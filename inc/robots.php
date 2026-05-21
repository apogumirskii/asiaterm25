<?php

/**
 * Генерация robots.txt с явными директивами для Yandex и Googlebot.
 * Подключается через фильтр WP `robots_txt`.
 *
 * Включает:
 *  - User-agent: *  (общие правила)
 *  - User-agent: Yandex (с Clean-param для удаления utm/fbclid/gclid из индекса)
 *  - User-agent: Googlebot (с разрешением admin-ajax)
 *  - Sitemap: ссылка на /wp-sitemap.xml
 */
function asiaterm_robots_txt($output, $public) {
    if ('0' === (string) $public) {
        // Сайт закрыт от индексации — оставляем стандартный output WordPress
        return $output;
    }

    $sitemap = esc_url_raw(home_url('/wp-sitemap.xml'));

    $lines = [];
    // Общие правила для всех ботов
    $lines[] = 'User-agent: *';
    $lines[] = 'Disallow: /wp-admin/';
    $lines[] = 'Disallow: /wp-includes/';
    $lines[] = 'Disallow: /?s=';
    $lines[] = 'Disallow: /search/';
    $lines[] = 'Allow: /wp-admin/admin-ajax.php';
    $lines[] = '';

    // Яндекс
    $lines[] = 'User-agent: Yandex';
    $lines[] = 'Disallow: /wp-admin/';
    $lines[] = 'Disallow: /wp-includes/';
    $lines[] = 'Disallow: /?s=';
    $lines[] = 'Disallow: /search/';
    $lines[] = 'Allow: /wp-admin/admin-ajax.php';
    // Clean-param — специфичная директива Яндекса:
    // удаляет UTM/рекламные параметры из URL при индексации, чтобы избежать дублей
    $lines[] = 'Clean-param: utm_source&utm_medium&utm_campaign&utm_term&utm_content&fbclid&gclid&yclid&ymclid&from';
    $lines[] = '';

    // Googlebot
    $lines[] = 'User-agent: Googlebot';
    $lines[] = 'Disallow: /wp-admin/';
    $lines[] = 'Disallow: /wp-includes/';
    $lines[] = 'Disallow: /?s=';
    $lines[] = 'Disallow: /search/';
    $lines[] = 'Allow: /wp-admin/admin-ajax.php';
    $lines[] = '';

    // Sitemap
    $lines[] = 'Sitemap: ' . $sitemap;

    return implode("\n", $lines) . "\n";
}
add_filter('robots_txt', 'asiaterm_robots_txt', 10, 2);
