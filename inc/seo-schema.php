<?php

function asiaterm_meta_description() {
    if (is_front_page() || is_home()) {
        return get_bloginfo('description');
    }
    if (is_singular()) {
        $desc = '';
        if (is_page_template(['page-singleproduct.php', 'page-complexproduct.php'])) {
            $desc = rwmb_meta('prod_shortdesc');
        }
        if (!$desc) {
            $desc = get_the_excerpt();
        }
        if (!$desc) {
            $desc = wp_trim_words(get_the_content(), 25, '...');
        }
        return wp_strip_all_tags($desc);
    }
    if (is_tax() || is_category()) {
        $term = get_queried_object();
        return $term && $term->description ? $term->description : get_bloginfo('description');
    }
    return get_bloginfo('description');
}

function asiaterm_schema_output() {
    if (is_singular()) {
        $post_id  = get_queried_object_id();
        $modified = get_post_modified_time('U', true, $post_id);
        $key      = 'asiaterm_schema_' . $post_id . '_' . $modified;
        $cached   = get_transient($key);
        if ($cached !== false) {
            echo $cached;
            return;
        }
        ob_start();
        asiaterm_schema_output_render();
        $html = ob_get_clean();
        set_transient($key, $html, WEEK_IN_SECONDS);
        echo $html;
        return;
    }
    asiaterm_schema_output_render();
}
add_action('wp_head', 'asiaterm_schema_output', 5);

function asiaterm_schema_output_render() {
    $schema = [];
    $site_name = get_bloginfo('name');
    $site_url  = home_url('/');
    $phone     = get_option('my_phone');
    $email     = get_option('my_mymail');
    $address   = get_option('my_adress');
    $logo_url  = get_template_directory_uri() . '/files/asiatermkg-logo.svg';

    $org = [
        '@context'    => 'https://schema.org',
        '@type'       => 'LocalBusiness',
        'name'        => $site_name,
        'url'         => $site_url,
        'logo'        => $logo_url,
        'image'       => $logo_url,
        'description' => get_bloginfo('description'),
        'priceRange'  => '$$',
    ];
    if ($phone) {
        $org['telephone'] = $phone;
        $org['contactPoint'] = [
            '@type'       => 'ContactPoint',
            'telephone'   => $phone,
            'contactType' => 'customer service',
            'availableLanguage' => ['Russian', 'Kyrgyz'],
        ];
    }
    if ($email) $org['email'] = $email;
    if ($address) {
        $org['address'] = [
            '@type'           => 'PostalAddress',
            'streetAddress'   => $address,
            'addressLocality' => 'Бишкек',
            'addressCountry'  => 'KG',
        ];
    }
    $socials = array_filter([
        get_option('my_instagramm'),
        get_option('my_facebook'),
        get_option('my_youtube'),
        get_option('my_telegram'),
        get_option('my_2gis'),
    ]);
    if ($socials) $org['sameAs'] = array_values($socials);
    $schema[] = $org;

    if (is_front_page()) {
        $schema[] = [
            '@context'      => 'https://schema.org',
            '@type'         => 'WebSite',
            'name'          => $site_name,
            'url'           => $site_url,
            'potentialAction' => [
                '@type'       => 'SearchAction',
                'target'      => $site_url . '?s={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    if (is_singular() && !is_front_page()) {
        $page_schema = [
            '@context'      => 'https://schema.org',
            '@type'         => 'WebPage',
            'name'          => get_the_title(),
            'url'           => get_permalink(),
            'datePublished' => get_the_date('c'),
            'dateModified'  => get_the_modified_date('c'),
        ];
        if (has_post_thumbnail()) {
            $page_schema['image'] = get_the_post_thumbnail_url(null, 'large');
        }

        if (is_page_template('page-contact.php')) {
            $page_schema['@type'] = 'ContactPage';
        }
        if (is_page_template('page-about.php')) {
            $page_schema['@type'] = 'AboutPage';
        }

        $schema[] = $page_schema;
    }

    if (is_page_template(['page-singleproduct.php', 'page-complexproduct.php'])) {
        $product = [
            '@context'    => 'https://schema.org',
            '@type'       => 'Product',
            'name'        => get_the_title(),
            'description' => wp_strip_all_tags(rwmb_meta('prod_shortdesc') ?: get_the_excerpt()),
            'url'         => get_permalink(),
            'brand'       => [
                '@type' => 'Brand',
                'name'  => $site_name,
            ],
        ];
        if (has_post_thumbnail()) {
            $product['image'] = get_the_post_thumbnail_url(null, 'large');
        }
        $parent_id = wp_get_post_parent_id(get_the_ID());
        if ($parent_id) {
            $product['category'] = get_the_title($parent_id);
        }
        $price = rwmb_meta('prod_price');
        if ($price) {
            $product['offers'] = [
                '@type'         => 'Offer',
                'price'         => preg_replace('/[^\d.]/', '', $price),
                'priceCurrency' => 'KGS',
                'availability'  => 'https://schema.org/InStock',
                'seller'        => ['@type' => 'Organization', 'name' => $site_name],
            ];
        } else {
            $product['offers'] = [
                '@type'         => 'Offer',
                'availability'  => 'https://schema.org/InStock',
                'price'         => '0',
                'priceCurrency' => 'KGS',
            ];
        }
        $var_titles = rwmb_meta('prod_var_titles');
        if ($var_titles) {
            $product['model'] = implode(', ', $var_titles);
        }
        $gallery = rwmb_meta('prod_service_gallery', ['size' => 'large']);
        if ($gallery) {
            $images = [];
            foreach ($gallery as $img) {
                $images[] = $img['url'];
            }
            if ($images) $product['image'] = $images;
        }
        $schema[] = $product;
    }

    if (is_page_template(['page-category.php', 'page-catalog.php'])) {
        $collection = [
            '@context'    => 'https://schema.org',
            '@type'       => 'CollectionPage',
            'name'        => get_the_title(),
            'url'         => get_permalink(),
            'description' => wp_strip_all_tags(get_the_excerpt() ?: ''),
        ];
        if (has_post_thumbnail()) {
            $collection['image'] = get_the_post_thumbnail_url(null, 'large');
        }
        $children = get_pages([
            'parent'      => get_the_ID(),
            'post_status' => 'publish',
            'sort_column' => 'menu_order',
        ]);
        if ($children) {
            $items = [];
            $pos = 1;
            foreach ($children as $child) {
                $items[] = [
                    '@type'    => 'ListItem',
                    'position' => $pos++,
                    'name'     => $child->post_title,
                    'url'      => get_permalink($child->ID),
                ];
            }
            $collection['mainEntity'] = [
                '@type'           => 'ItemList',
                'itemListElement' => $items,
            ];
        }
        $schema[] = $collection;
    }

    if (is_singular('post')) {
        $article = [
            '@context'      => 'https://schema.org',
            '@type'         => 'BlogPosting',
            'headline'      => get_the_title(),
            'url'           => get_permalink(),
            'datePublished' => get_the_date('c'),
            'dateModified'  => get_the_modified_date('c'),
            'author'        => [
                '@type' => 'Organization',
                'name'  => $site_name,
            ],
            'publisher'     => [
                '@type' => 'Organization',
                'name'  => $site_name,
                'logo'  => ['@type' => 'ImageObject', 'url' => $logo_url],
            ],
        ];
        if (has_post_thumbnail()) {
            $article['image'] = get_the_post_thumbnail_url(null, 'large');
        }
        $article['description'] = wp_strip_all_tags(get_the_excerpt());
        $schema[] = $article;
    }

    if (!is_front_page()) {
        $breadcrumbs = [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => [],
        ];
        $pos = 1;
        $breadcrumbs['itemListElement'][] = [
            '@type'    => 'ListItem',
            'position' => $pos++,
            'name'     => 'Главная',
            'item'     => $site_url,
        ];
        if (is_page()) {
            $ancestors = array_reverse(get_post_ancestors(get_the_ID()));
            foreach ($ancestors as $anc_id) {
                $breadcrumbs['itemListElement'][] = [
                    '@type'    => 'ListItem',
                    'position' => $pos++,
                    'name'     => get_the_title($anc_id),
                    'item'     => get_permalink($anc_id),
                ];
            }
            $breadcrumbs['itemListElement'][] = [
                '@type'    => 'ListItem',
                'position' => $pos,
                'name'     => get_the_title(),
                'item'     => get_permalink(),
            ];
        }
        if (is_singular('post')) {
            $cats = get_the_category();
            if ($cats) {
                $breadcrumbs['itemListElement'][] = [
                    '@type'    => 'ListItem',
                    'position' => $pos++,
                    'name'     => $cats[0]->name,
                    'item'     => get_category_link($cats[0]->term_id),
                ];
            }
            $breadcrumbs['itemListElement'][] = [
                '@type'    => 'ListItem',
                'position' => $pos,
                'name'     => get_the_title(),
                'item'     => get_permalink(),
            ];
        }
        $schema[] = $breadcrumbs;
    }

    foreach ($schema as $s) {
        echo '<script type="application/ld+json">' . wp_json_encode($s, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
}
