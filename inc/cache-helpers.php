<?php

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

function asiaterm_portfolio_page() {
    $key = 'asiaterm_portfolio_page_v1';
    $cached = get_transient($key);
    if ($cached !== false) return $cached ?: null;
    $pages = get_pages(['meta_key' => '_wp_page_template', 'meta_value' => 'page-portfolio.php']);
    $page  = $pages ? $pages[0] : null;
    set_transient($key, $page ?: 0, DAY_IN_SECONDS);
    return $page;
}

function asiaterm_invalidate_page_caches() {
    delete_transient('asiaterm_catalog_children_v1');
    delete_transient('asiaterm_catalog_children_v2');
    delete_transient('asiaterm_portfolio_page_v1');
}
add_action('save_post_page', 'asiaterm_invalidate_page_caches');
add_action('deleted_post', 'asiaterm_invalidate_page_caches');
add_action('switch_theme', 'asiaterm_invalidate_page_caches');
