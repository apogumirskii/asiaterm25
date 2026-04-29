<?php

add_theme_support( 'post-thumbnails' );
add_theme_support( 'title-tag' );

add_image_size( 'small', 60, 60, true );
add_image_size( 'vert-thumb', 400, 800, true );
add_image_size( 'catalog-thumb', 300, 400, true  );
add_image_size( 'slider-desc', 1920, 350, true  );
add_image_size( 'slider-mob', 720, 720, true  );
add_image_size( 'costom-gallery', 1290, 580, true  );

function arphabet_widgets_init() {
	register_sidebar( array(
		'name'          => 'FooterLinks',
		'id'            => 'FooterLinks',
		'before_widget' => '<div class="widget_text row25f"><nav>',
		'after_widget'  => '</nav></div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => 'Sidebar',
		'id'            => 'Sidebar',
		'before_widget' => '<div class="card widget d-none d-lg-block">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget__header"><h4>',
		'after_title'   => '</h4></div>',
	) );
}
add_action( 'widgets_init', 'arphabet_widgets_init' );

function load_theme_textdomain_asiaterm25() {
    load_theme_textdomain('asiaterm25', get_template_directory());
}
add_action('after_setup_theme', 'load_theme_textdomain_asiaterm25');

function asiaterm_flush_rewrite_rules() {
    my_post_type_sliderims();
    my_post_type_portfolio();
    create_portfolio_category_taxonomy();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'asiaterm_flush_rewrite_rules');

function asiaterm_maybe_flush_rewrite() {
    if (get_option('asiaterm_flush_rewrite') !== '3') {
        flush_rewrite_rules();
        update_option('asiaterm_flush_rewrite', '3');
    }
}
add_action('init', 'asiaterm_maybe_flush_rewrite', 99);

function enqueue_theme_styles() {
    wp_enqueue_style('theme-style', get_template_directory_uri() . '/style.css', ['bootstrap'], '1.0.0');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css', [], '6.5.2');
}
add_action('wp_enqueue_scripts', 'enqueue_theme_styles');

function enqueue_bootstrap() {
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', [], '5.3.3');
    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', ['jquery'], '5.3.3', true);
}
add_action('wp_enqueue_scripts', 'enqueue_bootstrap');

function asiaterm_enqueue_swiper() {
    $swiper_templates = ['page-front.php', 'page-catalog.php', 'page-singleproduct.php', 'page-complexproduct.php', 'page-category.php', 'page-partners.php', 'page-about.php'];
    if (is_page_template($swiper_templates) || is_front_page() || is_singular('portfolio')) {
        $uri = get_template_directory_uri();
        wp_enqueue_style ('swiper', $uri . '/assets/swiper/swiper-bundle.min.css', [], '11.0.0');
        wp_enqueue_script('swiper', $uri . '/assets/swiper/swiper-bundle.min.js', [], '11.0.0', true);
    }
}
add_action('wp_enqueue_scripts', 'asiaterm_enqueue_swiper');

function asiaterm_enqueue_lightbox() {
    $lb_templates = ['page-singleproduct.php', 'page-complexproduct.php', 'page-portfolio.php', 'page-certificates.php', 'page-reviews.php', 'page-about.php', 'page-category.php'];
    if (is_page_template($lb_templates) || is_singular('portfolio')) {
        $uri = get_template_directory_uri();
        $ver = wp_get_theme()->get('Version');
        wp_enqueue_style ('asiaterm-lightbox', $uri . '/assets/lightbox/lightbox.css', [], $ver);
        wp_enqueue_script('asiaterm-lightbox', $uri . '/assets/lightbox/lightbox.js', [], $ver, true);
    }
}
add_action('wp_enqueue_scripts', 'asiaterm_enqueue_lightbox');

function enqueue_theme_scripts() {
    if (is_page_template(['page-singleproduct.php', 'page-complexproduct.php']) || is_singular('portfolio')) {
        wp_enqueue_script('product-gallery', get_template_directory_uri() . '/js/product-gallery.js', ['swiper'], '1.1.0', true);
    }
    $front_templates = ['page-front.php', 'page-catalog.php', 'page-category.php', 'page-partners.php', 'page-about.php', 'page-portfolio.php'];
    if (is_page_template($front_templates) || is_front_page() || is_singular('portfolio')) {
        wp_enqueue_script('theme-front', get_template_directory_uri() . '/js/theme-front.js', ['jquery', 'swiper'], '1.1.0', true);
    }
}
add_action('wp_enqueue_scripts', 'enqueue_theme_scripts');
