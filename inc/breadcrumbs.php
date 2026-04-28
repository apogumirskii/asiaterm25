<?php

function the_breadcrumb() {
    if (is_front_page()) return;

    echo '<ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">';
    $pos = 1;

    echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
    echo '<a href="' . esc_url(home_url('/')) . '" itemprop="item"><span itemprop="name">Главная</span></a>';
    echo '<meta itemprop="position" content="' . $pos++ . '">';
    echo '</li>';

    if (is_page()) {
        $ancestors = array_reverse(get_post_ancestors(get_the_ID()));
        foreach ($ancestors as $ancestor_id) {
            echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            echo '<a href="' . esc_url(get_permalink($ancestor_id)) . '" itemprop="item"><span itemprop="name">' . esc_html(get_the_title($ancestor_id)) . '</span></a>';
            echo '<meta itemprop="position" content="' . $pos++ . '">';
            echo '</li>';
        }
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<a href="' . esc_url(get_permalink()) . '" itemprop="item"><span itemprop="name">' . esc_html(get_the_title()) . '</span></a>';
        echo '<meta itemprop="position" content="' . $pos . '">';
        echo '</li>';

    } elseif (is_singular('portfolio')) {
        $portfolio_page = asiaterm_portfolio_page();
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        if ($portfolio_page) {
            echo '<a href="' . esc_url(get_permalink($portfolio_page->ID)) . '" itemprop="item"><span itemprop="name">' . esc_html($portfolio_page->post_title) . '</span></a>';
        } else {
            echo '<span itemprop="name">' . __('Проекты', 'asiaterm25') . '</span>';
        }
        echo '<meta itemprop="position" content="' . $pos++ . '">';
        echo '</li>';
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . esc_html(get_the_title()) . '</span>';
        echo '<meta itemprop="position" content="' . $pos . '">';
        echo '</li>';

    } elseif (is_single()) {
        $cats = get_the_category();
        if ($cats) {
            echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            echo '<a href="' . esc_url(get_category_link($cats[0]->term_id)) . '" itemprop="item"><span itemprop="name">' . esc_html($cats[0]->name) . '</span></a>';
            echo '<meta itemprop="position" content="' . $pos++ . '">';
            echo '</li>';
        }
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . esc_html(get_the_title()) . '</span>';
        echo '<meta itemprop="position" content="' . $pos . '">';
        echo '</li>';

    } elseif (is_category()) {
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . esc_html(single_cat_title('', false)) . '</span>';
        echo '<meta itemprop="position" content="' . $pos . '">';
        echo '</li>';

    } elseif (is_archive()) {
        $label = __('Архив', 'asiaterm25');
        if (is_day()) $label = get_the_date();
        elseif (is_month()) $label = get_the_date('F Y');
        elseif (is_year()) $label = get_the_date('Y');
        echo '<li>' . esc_html($label) . '</li>';

    } elseif (is_search()) {
        echo '<li>' . __('Поиск', 'asiaterm25') . '</li>';

    } elseif (is_404()) {
        echo '<li>404</li>';
    }

    echo '</ol>';
}
