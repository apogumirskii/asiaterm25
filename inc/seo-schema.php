<?php

/**
 * SEO meta description fallback.
 */
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

/**
 * Глобальная версия Schema для инвалидации кэша.
 */
function asiaterm_schema_version() {
    return (int) get_option('asiaterm_schema_version', 1);
}

/**
 * Вывод JSON-LD на wp_head с per-page кэшированием.
 */
function asiaterm_schema_output() {
    if (is_singular()) {
        $post_id  = get_queried_object_id();
        $modified = get_post_modified_time('U', true, $post_id);
        $version  = asiaterm_schema_version();
        $key      = 'asiaterm_schema_v' . $version . '_' . $post_id . '_' . $modified;
        $cached   = get_transient($key);
        if ($cached !== false) {
            echo $cached;
            return;
        }
        ob_start();
        asiaterm_schema_output_render();
        $html = ob_get_clean();
        set_transient($key, $html, DAY_IN_SECONDS);
        echo $html;
        return;
    }
    asiaterm_schema_output_render();
}
add_action('wp_head', 'asiaterm_schema_output', 5);

/**
 * Bump версии при изменении глобальных опций / контента.
 */
function asiaterm_bump_schema_version() {
    $v = asiaterm_schema_version();
    update_option('asiaterm_schema_version', $v + 1);
}

// Опции, изменение которых должно сбрасывать ВСЕ schema-кэши
foreach (['my_phone', 'my_phone2', 'my_whatsapp', 'my_mymail', 'my_adress',
          'my_work_hours', 'my_2gis', 'my_instagramm', 'my_facebook', 'my_youtube',
          'my_telegram', 'my_geo_lat', 'my_geo_lng', 'blogname', 'blogdescription'] as $opt) {
    add_action('update_option_' . $opt, 'asiaterm_bump_schema_version');
}

// Точечный сброс schema-кэша при изменении meta-полей продукта
add_action('updated_postmeta', function ($meta_id, $post_id, $meta_key) {
    $tracked = ['prod_price', 'prod_shortdesc', 'prod_service_gallery', 'prod_var_titles', 'prod_specs', 'prod_costomdescr'];
    if (!in_array($meta_key, $tracked, true)) return;
    global $wpdb;
    $like_a = $wpdb->esc_like('_transient_asiaterm_schema_v') . '%' . $wpdb->esc_like('_' . $post_id . '_') . '%';
    $like_b = $wpdb->esc_like('_transient_timeout_asiaterm_schema_v') . '%' . $wpdb->esc_like('_' . $post_id . '_') . '%';
    $wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name LIKE %s", $like_a, $like_b));
}, 10, 3);

// При сохранении самой страницы — точечный сброс
add_action('save_post', function ($post_id) {
    if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) return;
    global $wpdb;
    $like_a = $wpdb->esc_like('_transient_asiaterm_schema_v') . '%' . $wpdb->esc_like('_' . $post_id . '_') . '%';
    $like_b = $wpdb->esc_like('_transient_timeout_asiaterm_schema_v') . '%' . $wpdb->esc_like('_' . $post_id . '_') . '%';
    $wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name LIKE %s", $like_a, $like_b));
});

/**
 * Helper: общий Offer-блок для Product и ProductGroup.
 * Зоны обслуживания и возврата — KG/UZ/TJ/KZ.
 * Цена "по запросу" через PriceSpecification без price.
 * Гарантия 36 мес, возврат 14 дней, доставка до 30 дней.
 */
function asiaterm_build_offer($org_id, $url) {
    $countries = ['KG', 'UZ', 'TJ', 'KZ'];

    $shipping_destinations = [];
    foreach ($countries as $c) {
        $shipping_destinations[] = ['@type' => 'DefinedRegion', 'addressCountry' => $c];
    }

    return [
        '@type'         => 'Offer',
        'url'           => $url,
        'priceCurrency' => 'KGS',
        'priceSpecification' => [
            '@type'         => 'PriceSpecification',
            'priceCurrency' => 'KGS',
            'description'   => 'Цена по запросу',
        ],
        'availability'  => 'https://schema.org/InStock',
        'itemCondition' => 'https://schema.org/NewCondition',
        'seller'        => ['@id' => $org_id],
        'hasMerchantReturnPolicy' => [
            '@type'                => 'MerchantReturnPolicy',
            'applicableCountry'    => $countries,
            'returnPolicyCategory' => 'https://schema.org/MerchantReturnFiniteReturnWindow',
            'merchantReturnDays'   => 14,
            'returnMethod'         => 'https://schema.org/ReturnByMail',
            'returnFees'           => 'https://schema.org/FreeReturn',
        ],
        'shippingDetails' => [
            '@type'              => 'OfferShippingDetails',
            'shippingDestination' => $shipping_destinations,
            'shippingRate' => [
                '@type'    => 'MonetaryAmount',
                'value'    => '0',
                'currency' => 'KGS',
            ],
            'deliveryTime' => [
                '@type'        => 'ShippingDeliveryTime',
                'handlingTime' => [
                    '@type'    => 'QuantitativeValue',
                    'minValue' => 0,
                    'maxValue' => 3,
                    'unitCode' => 'DAY',
                ],
                'transitTime' => [
                    '@type'    => 'QuantitativeValue',
                    'minValue' => 1,
                    'maxValue' => 30,
                    'unitCode' => 'DAY',
                ],
            ],
        ],
        'warranty' => [
            '@type'              => 'WarrantyPromise',
            'durationOfWarranty' => [
                '@type'    => 'QuantitativeValue',
                'value'    => 36,
                'unitCode' => 'MON',
            ],
            'warrantyScope' => 'https://schema.org/PartsAndLaborWarranty',
        ],
    ];
}

/**
 * Основной рендер JSON-LD.
 */
function asiaterm_schema_output_render() {
    $schema    = [];
    $site_name = get_bloginfo('name');
    $site_url  = home_url('/');
    $phone     = get_option('my_phone');
    $phone2    = get_option('my_phone2');
    $wa        = get_option('my_whatsapp');
    $email     = get_option('my_mymail');
    $address   = get_option('my_adress');
    $work_hours= get_option('my_work_hours');
    $map_2gis  = get_option('my_2gis');
    $geo_lat   = get_option('my_geo_lat');
    $geo_lng   = get_option('my_geo_lng');
    $logo_url  = get_template_directory_uri() . '/files/asiatermkg-logo.svg';

    $org_id      = $site_url . '#organization';
    $website_id  = $site_url . '#website';

    // ============ Organization (LocalBusiness) ============
    $org = [
        '@context'    => 'https://schema.org',
        '@type'       => 'LocalBusiness',
        '@id'         => $org_id,
        'name'        => $site_name,
        'url'         => $site_url,
        'logo'        => ['@type' => 'ImageObject', 'url' => $logo_url],
        'image'       => $logo_url,
        'description' => get_bloginfo('description'),
        'currenciesAccepted' => 'KGS',
        'areaServed'  => [
            ['@type' => 'Country', 'name' => 'Кыргызстан'],
            ['@type' => 'Country', 'name' => 'Узбекистан'],
            ['@type' => 'Country', 'name' => 'Таджикистан'],
            ['@type' => 'Country', 'name' => 'Казахстан'],
        ],
    ];

    // Контакты
    $contact_points = [];
    if ($phone) {
        $contact_points[] = [
            '@type'             => 'ContactPoint',
            'telephone'         => $phone,
            'contactType'       => 'customer service',
            'availableLanguage' => ['Russian', 'Kyrgyz'],
        ];
        $org['telephone'] = $phone;
    }
    if ($phone2) {
        $contact_points[] = [
            '@type'       => 'ContactPoint',
            'telephone'   => $phone2,
            'contactType' => 'sales',
        ];
    }
    if ($wa) {
        $contact_points[] = [
            '@type'       => 'ContactPoint',
            'telephone'   => $wa,
            'contactType' => 'customer support',
        ];
    }
    if ($contact_points) $org['contactPoint'] = $contact_points;

    if ($email) $org['email'] = $email;

    if ($address) {
        $org['address'] = [
            '@type'           => 'PostalAddress',
            'streetAddress'   => $address,
            'addressLocality' => 'Бишкек',
            'addressCountry'  => 'KG',
        ];
    }

    if ($work_hours) {
        $org['openingHours'] = $work_hours;
    }

    if ($map_2gis) {
        $org['hasMap'] = $map_2gis;
    }

    if ($geo_lat && $geo_lng) {
        $org['geo'] = [
            '@type'     => 'GeoCoordinates',
            'latitude'  => (float) $geo_lat,
            'longitude' => (float) $geo_lng,
        ];
    }

    $socials = array_filter([
        get_option('my_instagramm'),
        get_option('my_facebook'),
        get_option('my_youtube'),
        get_option('my_telegram'),
    ]);
    if ($socials) $org['sameAs'] = array_values($socials);

    $schema[] = $org;

    // ============ WebSite ============
    if (is_front_page()) {
        $schema[] = [
            '@context'        => 'https://schema.org',
            '@type'           => 'WebSite',
            '@id'             => $website_id,
            'name'            => $site_name,
            'url'             => $site_url,
            'publisher'       => ['@id' => $org_id],
            'potentialAction' => [
                '@type'       => 'SearchAction',
                'target'      => $site_url . '?s={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    // ============ WebPage ============
    if (is_singular() && !is_front_page()) {
        $permalink = get_permalink();
        $page_schema = [
            '@context'      => 'https://schema.org',
            '@type'         => 'WebPage',
            '@id'           => $permalink . '#webpage',
            'name'          => get_the_title(),
            'url'           => $permalink,
            'datePublished' => get_the_date('c'),
            'dateModified'  => get_the_modified_date('c'),
            'isPartOf'      => ['@id' => $website_id],
            'breadcrumb'    => ['@id' => $permalink . '#breadcrumb'],
            'publisher'     => ['@id' => $org_id],
        ];
        if (has_post_thumbnail()) {
            $page_schema['image'] = get_the_post_thumbnail_url(null, 'large');
        }
        if (is_page_template('page-contact.php'))  $page_schema['@type'] = 'ContactPage';
        if (is_page_template('page-about.php'))    $page_schema['@type'] = 'AboutPage';

        $schema[] = $page_schema;
    }

    // ============ Product (single product) ============
    if (is_page_template('page-singleproduct.php')) {
        $permalink = get_permalink();
        $product = [
            '@context'    => 'https://schema.org',
            '@type'       => 'Product',
            '@id'         => $permalink . '#product',
            'name'        => get_the_title(),
            'description' => wp_strip_all_tags(rwmb_meta('prod_shortdesc') ?: get_the_excerpt()),
            'url'         => $permalink,
            'sku'         => 'AT-' . get_the_ID(),
            'brand'       => ['@type' => 'Brand', 'name' => $site_name],
            'mainEntityOfPage' => ['@id' => $permalink . '#webpage'],
        ];

        // Изображения: галерея → главное → fallback
        $images = [];
        $gallery = rwmb_meta('prod_service_gallery', ['size' => 'large']);
        if ($gallery) {
            foreach ($gallery as $img) {
                if (!empty($img['url'])) $images[] = $img['url'];
            }
        }
        if (!$images && has_post_thumbnail()) {
            $images[] = get_the_post_thumbnail_url(null, 'large');
        }
        if ($images) {
            $product['image'] = count($images) === 1 ? $images[0] : $images;
        }

        // Категория-родитель
        $parent_id = wp_get_post_parent_id(get_the_ID());
        if ($parent_id) {
            $product['category'] = get_the_title($parent_id);
            // Связь с ProductGroup если родитель — complex product
            $parent_template = get_page_template_slug($parent_id);
            if ($parent_template === 'page-complexproduct.php') {
                $product['isVariantOf'] = [
                    '@id'  => get_permalink($parent_id) . '#productgroup',
                    '@type' => 'ProductGroup',
                ];
            }
        }

        // Вариации (модификации)
        $var_titles = rwmb_meta('prod_var_titles');
        if ($var_titles) {
            $product['model'] = implode(', ', $var_titles);
        }

        $product['offers'] = asiaterm_build_offer($org_id, $permalink);

        $schema[] = $product;
    }

    // ============ ProductGroup (complex product) ============
    if (is_page_template('page-complexproduct.php')) {
        $permalink = get_permalink();
        $children = get_pages([
            'parent'      => get_the_ID(),
            'post_status' => 'publish',
            'sort_column' => 'menu_order',
        ]);

        $variants = [];
        foreach ($children as $child) {
            $variants[] = [
                '@type' => 'Product',
                '@id'   => get_permalink($child->ID) . '#product',
                'name'  => $child->post_title,
                'url'   => get_permalink($child->ID),
            ];
        }

        $product_group = [
            '@context'       => 'https://schema.org',
            '@type'          => 'ProductGroup',
            '@id'            => $permalink . '#productgroup',
            'productGroupID' => 'PG-' . get_the_ID(),
            'name'           => get_the_title(),
            'description'    => wp_strip_all_tags(rwmb_meta('prod_shortdesc') ?: get_the_excerpt()),
            'url'            => $permalink,
            'brand'          => ['@type' => 'Brand', 'name' => $site_name],
            'mainEntityOfPage' => ['@id' => $permalink . '#webpage'],
        ];

        // Изображение
        $gallery = rwmb_meta('prod_service_gallery', ['size' => 'large']);
        if ($gallery) {
            $img_urls = [];
            foreach ($gallery as $img) {
                if (!empty($img['url'])) $img_urls[] = $img['url'];
            }
            if ($img_urls) $product_group['image'] = count($img_urls) === 1 ? $img_urls[0] : $img_urls;
        } elseif (has_post_thumbnail()) {
            $product_group['image'] = get_the_post_thumbnail_url(null, 'large');
        }

        if ($variants) {
            $product_group['hasVariant'] = $variants;
        }

        $product_group['offers'] = asiaterm_build_offer($org_id, $permalink);

        $schema[] = $product_group;
    }

    // ============ CollectionPage + ItemList (category/catalog) ============
    if (is_page_template(['page-category.php', 'page-catalog.php'])) {
        $permalink = get_permalink();
        $collection = [
            '@context'    => 'https://schema.org',
            '@type'       => 'CollectionPage',
            '@id'         => $permalink . '#collection',
            'name'        => get_the_title(),
            'url'         => $permalink,
            'description' => wp_strip_all_tags(get_the_excerpt() ?: ''),
            'isPartOf'    => ['@id' => $website_id],
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

    // ============ Article + BlogPosting (для постов) ============
    if (is_singular('post')) {
        $permalink = get_permalink();
        $article = [
            '@context'         => 'https://schema.org',
            '@type'            => ['Article', 'BlogPosting'],
            '@id'              => $permalink . '#article',
            'headline'         => mb_substr(get_the_title(), 0, 110),
            'url'              => $permalink,
            'datePublished'    => get_the_date('c'),
            'dateModified'     => get_the_modified_date('c'),
            'mainEntityOfPage' => ['@id' => $permalink . '#webpage'],
            'author'           => [
                '@type' => 'Organization',
                'name'  => $site_name,
                '@id'   => $org_id,
            ],
            'publisher'        => ['@id' => $org_id],
        ];
        if (has_post_thumbnail()) {
            $article['image'] = get_the_post_thumbnail_url(null, 'large');
        }
        $article['description'] = wp_strip_all_tags(get_the_excerpt());
        $schema[] = $article;
    }

    // ============ BreadcrumbList ============
    if (!is_front_page()) {
        $permalink_for_bc = is_singular() ? get_permalink() : home_url();
        $breadcrumbs = [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            '@id'             => $permalink_for_bc . '#breadcrumb',
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
        if (is_singular('post') || is_singular('portfolio')) {
            $breadcrumbs['itemListElement'][] = [
                '@type'    => 'ListItem',
                'position' => $pos,
                'name'     => get_the_title(),
                'item'     => get_permalink(),
            ];
        }
        $schema[] = $breadcrumbs;
    }

    // ============ SiteNavigationElement (для Яндекс sitelinks) ============
    if (is_front_page()) {
        // Главное меню
        $nav_locations = get_nav_menu_locations();
        if (isset($nav_locations['topmenu'])) {
            $menu_items = wp_get_nav_menu_items($nav_locations['topmenu']);
            if ($menu_items) {
                $nav_elements = [];
                $pos = 1;
                foreach ($menu_items as $item) {
                    $nav_elements[] = [
                        '@type'    => 'SiteNavigationElement',
                        'position' => $pos++,
                        'name'     => $item->title,
                        'url'      => $item->url,
                    ];
                }
                $schema[] = [
                    '@context'        => 'https://schema.org',
                    '@type'           => 'ItemList',
                    'name'            => 'Главное меню',
                    'itemListElement' => $nav_elements,
                ];
            }
        }

        // Каталог
        if (function_exists('asiaterm_catalog_children')) {
            $cat_pages = asiaterm_catalog_children();
            if ($cat_pages) {
                $cat_nav = [];
                $pos = 1;
                foreach ($cat_pages as $cat) {
                    $cat_nav[] = [
                        '@type'    => 'SiteNavigationElement',
                        'position' => $pos++,
                        'name'     => $cat->post_title,
                        'url'      => get_permalink($cat->ID),
                    ];
                }
                $schema[] = [
                    '@context'        => 'https://schema.org',
                    '@type'           => 'ItemList',
                    'name'            => 'Каталог',
                    'itemListElement' => $cat_nav,
                ];
            }
        }
    }

    // Вывод
    foreach ($schema as $s) {
        echo '<script type="application/ld+json">' . wp_json_encode($s, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
}
