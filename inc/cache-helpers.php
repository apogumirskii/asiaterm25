<?php

/**
 * Дочерние страницы каталога (ID 13). Используется в меню/футере/cattop.
 */
function asiaterm_catalog_children() {
    $key = 'asiaterm_catalog_children_v2';
    $cached = get_transient($key);
    if ($cached !== false) return $cached;
    $pages = get_pages([
        'parent'      => 13,
        'post_status' => 'publish',
        'sort_column' => 'menu_order, post_title',
    ]);
    set_transient($key, $pages, HOUR_IN_SECONDS);
    return $pages;
}

/**
 * Найти страницу-листинг портфолио по шаблону.
 */
function asiaterm_portfolio_page() {
    $key = 'asiaterm_portfolio_page_v1';
    $cached = get_transient($key);
    if ($cached !== false) return $cached ?: null;
    $pages = get_pages(['meta_key' => '_wp_page_template', 'meta_value' => 'page-portfolio.php']);
    $page  = $pages ? $pages[0] : null;
    set_transient($key, $page ?: 0, DAY_IN_SECONDS);
    return $page;
}

/**
 * Сборка всех документов из prod_downloads по всем страницам товаров.
 * Используется на странице партнёров. TTL 6 часов.
 */
function asiaterm_partners_documents() {
    $key = 'asiaterm_partners_docs_v1';
    $cached = get_transient($key);
    if ($cached !== false) return $cached;

    $docs_query = new WP_Query([
        'post_type'              => 'page',
        'post_status'            => 'publish',
        'posts_per_page'         => -1,
        'no_found_rows'          => true,
        'meta_query'             => [
            ['key' => 'prod_downloads', 'compare' => 'EXISTS'],
        ],
    ]);

    $pages_with_docs = [];
    if ($docs_query->have_posts()) {
        foreach ($docs_query->posts as $p) {
            $files = rwmb_meta('prod_downloads', ['object_type' => 'post'], $p->ID);
            if ($files) $pages_with_docs[$p->ID] = true;
        }
    }

    $all_docs = [];
    if ($docs_query->have_posts()) {
        foreach ($docs_query->posts as $p) {
            $page_id   = $p->ID;
            $parent_id = wp_get_post_parent_id($page_id);

            // Дочернюю страницу пропускаем если у родителя есть файлы (избегаем дублей)
            if ($parent_id && !empty($pages_with_docs[$parent_id])) continue;

            $files = rwmb_meta('prod_downloads', ['object_type' => 'post'], $page_id);
            if (!$files) continue;

            $page_title = get_the_title($page_id);
            $category   = $parent_id ? get_the_title($parent_id) : '';

            foreach ($files as $file) {
                $all_docs[] = [
                    'name'     => $file['title'] ?: $file['name'] ?: basename($file['url']),
                    'url'      => $file['url'],
                    'page'     => $page_title,
                    'category' => $category,
                    'type'     => strtoupper(pathinfo($file['url'], PATHINFO_EXTENSION)),
                    'size'     => size_format($file['filesize'] ?? 0),
                ];
            }
        }
    }

    set_transient($key, $all_docs, 6 * HOUR_IN_SECONDS);
    return $all_docs;
}

/**
 * Сборка listing'а портфолио для page-portfolio.php.
 * Возвращает ['items' => [...], 'all_cats' => [...]]. TTL 12 часов.
 */
function asiaterm_portfolio_listing() {
    $key = 'asiaterm_portfolio_listing_v1';
    $cached = get_transient($key);
    if ($cached !== false) return $cached;

    $portfolio_query = new WP_Query([
        'post_type'      => 'portfolio',
        'posts_per_page' => -1,
        'no_found_rows'  => true,
        'orderby'        => 'menu_order date',
        'order'          => 'ASC',
    ]);

    $all_cats = [];
    $items    = [];

    if ($portfolio_query->have_posts()) {
        while ($portfolio_query->have_posts()) {
            $portfolio_query->the_post();
            $pid = get_the_ID();
            $terms = get_the_terms($pid, 'portfolio_category');
            $cat_slugs = [];
            if ($terms && !is_wp_error($terms)) {
                foreach ($terms as $term) {
                    $all_cats[$term->slug] = $term->name;
                    $cat_slugs[] = $term->slug;
                }
            }
            $gallery = rwmb_meta('portfolio_gallery', ['object_type' => 'post'], $pid);
            $thumb   = get_the_post_thumbnail_url($pid, 'costom-gallery');
            if (!$thumb && $gallery) $thumb = reset($gallery)['full_url'] ?? '';
            if (!$thumb) $thumb = get_template_directory_uri() . '/files/topimg2.png';

            $items[] = [
                'id'      => $pid,
                'title'   => get_the_title(),
                'excerpt' => get_the_excerpt(),
                'thumb'   => $thumb,
                'url'     => get_permalink(),
                'cats'    => implode(' ', $cat_slugs),
            ];
        }
        wp_reset_postdata();
    }
    asort($all_cats);

    $data = ['items' => $items, 'all_cats' => $all_cats];
    set_transient($key, $data, 12 * HOUR_IN_SECONDS);
    return $data;
}

/**
 * Связанные товары для конкретного проекта (где prod_portfolio_pages содержит ID проекта).
 * Per-portfolio cache. TTL 12 часов.
 */
function asiaterm_related_products_for_portfolio($portfolio_id) {
    $portfolio_id = (int) $portfolio_id;
    if (!$portfolio_id) return [];

    $key = 'asiaterm_related_products_' . $portfolio_id . '_v1';
    $cached = get_transient($key);
    if ($cached !== false) return $cached;

    $query = new WP_Query([
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'no_found_rows'  => true,
        'meta_query'     => [
            [
                'key'     => 'prod_portfolio_pages',
                'value'   => $portfolio_id,
                'compare' => 'LIKE',
            ],
        ],
    ]);

    $ids = $query->have_posts() ? wp_list_pluck($query->posts, 'ID') : [];
    set_transient($key, $ids, 12 * HOUR_IN_SECONDS);
    return $ids;
}

/**
 * Сброс всех кэшей, зависящих от структуры страниц.
 */
function asiaterm_invalidate_page_caches() {
    delete_transient('asiaterm_catalog_children_v1');
    delete_transient('asiaterm_catalog_children_v2');
    delete_transient('asiaterm_portfolio_page_v1');
    delete_transient('asiaterm_partners_docs_v1');
    delete_transient('asiaterm_portfolio_listing_v1');
    // Wildcard: все per-portfolio related-products
    global $wpdb;
    $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_asiaterm_related_products_%' OR option_name LIKE '_transient_timeout_asiaterm_related_products_%'");
}
add_action('save_post_page', 'asiaterm_invalidate_page_caches');
add_action('save_post_portfolio', 'asiaterm_invalidate_page_caches');
add_action('deleted_post', 'asiaterm_invalidate_page_caches');
add_action('switch_theme', 'asiaterm_invalidate_page_caches');

// Точечный сброс кэша партнёрских документов и related-products при изменении meta
add_action('updated_postmeta', function ($mid, $pid, $meta_key) {
    if ($meta_key === 'prod_downloads') {
        delete_transient('asiaterm_partners_docs_v1');
    }
    if ($meta_key === 'prod_portfolio_pages') {
        global $wpdb;
        $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_asiaterm_related_products_%' OR option_name LIKE '_transient_timeout_asiaterm_related_products_%'");
    }
}, 10, 3);

// Сброс при изменении таксономии портфолио
add_action('created_portfolio_category', function () { delete_transient('asiaterm_portfolio_listing_v1'); });
add_action('edited_portfolio_category',  function () { delete_transient('asiaterm_portfolio_listing_v1'); });
add_action('deleted_portfolio_category', function () { delete_transient('asiaterm_portfolio_listing_v1'); });
