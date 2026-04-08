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

function enqueue_theme_styles() {
    wp_enqueue_style('theme-style', get_template_directory_uri() . '/style.css', ['bootstrap'], '1.0.0');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css', [], '6.5.2');
}
add_action('wp_enqueue_scripts', 'enqueue_theme_styles');

function load_theme_textdomain_asiaterm25() {
    load_theme_textdomain('asiaterm25', get_template_directory());
}
add_action('after_setup_theme', 'load_theme_textdomain_asiaterm25');

function enqueue_bootstrap() {
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', [], '5.3.3');
    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', ['jquery'], '5.3.3', true);
}
add_action('wp_enqueue_scripts', 'enqueue_bootstrap');

function enqueue_owl_carousel() {
    $owl_templates = ['page-front.php', 'page-catalog.php', 'page-singleproduct.php', 'page-complexproduct.php', 'page-category.php', 'page-partners.php', 'page-about.php'];
    if (is_page_template($owl_templates) || is_front_page()) {
        wp_enqueue_style('owl-carousel', 'https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/assets/owl.carousel.min.css');
        wp_enqueue_style('owl-theme', 'https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/assets/owl.theme.default.min.css');
        wp_enqueue_script('owl-carousel', 'https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/owl.carousel.min.js', ['jquery'], null, true);
    }
}
add_action('wp_enqueue_scripts', 'enqueue_owl_carousel');

function enqueue_lightbox() {
    $lb_templates = ['page-singleproduct.php', 'page-complexproduct.php', 'page-portfolio.php', 'page-certificates.php', 'page-about.php', 'page-category.php'];
    if (is_page_template($lb_templates)) {
        wp_enqueue_style('lightbox-css', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css');
        wp_enqueue_script('lightbox-js', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js', ['jquery'], null, true);
    }
}
add_action('wp_enqueue_scripts', 'enqueue_lightbox');

function enqueue_theme_scripts() {
    // Product gallery carousel
    if (is_page_template(['page-singleproduct.php', 'page-complexproduct.php'])) {
        wp_enqueue_script('product-gallery', get_template_directory_uri() . '/js/product-gallery.js', ['jquery', 'owl-carousel'], '1.0.0', true);
    }
    // Theme front JS (hero slider, product/partners carousels, video modal)
    $front_templates = ['page-front.php', 'page-catalog.php', 'page-category.php', 'page-partners.php', 'page-about.php', 'page-portfolio.php'];
    if (is_page_template($front_templates) || is_front_page()) {
        wp_enqueue_script('theme-front', get_template_directory_uri() . '/js/theme-front.js', ['jquery', 'owl-carousel'], '1.0.0', true);
    }
}
add_action('wp_enqueue_scripts', 'enqueue_theme_scripts');

function register_my_menu() {
    register_nav_menus([
        'menu'    => __('Menu'),
        'topmenu' => __('Top Menu'),
    ]);
}
add_action('init', 'register_my_menu');

class Bootstrap5_Walker_Nav_Menu extends Walker_Nav_Menu {
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= '<ul class="sub-menu">';
    }
    public function end_lvl(&$output, $depth = 0, $args = null) {
        $output .= '</ul>';
    }
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = implode(' ', $item->classes ?? []);
        $has_children = in_array('menu-item-has-children', $item->classes ?? []);
        $output .= '<li class="' . esc_attr($classes) . '">';
        $output .= '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';
    }
    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= '</li>';
    }
}

function disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
    add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );

function disable_emojis_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
        return array();
    }
}

function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
    if ( 'dns-prefetch' == $relation_type ) {
        $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
        $urls = array_diff( $urls, array( $emoji_svg_url ) );
    }
    return $urls;
}


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


function register_custom_settings_section() {
    add_settings_section(
        'custom_contact_section',
        'Контактная информация',
        null,
        'general'
    );
}
add_action('admin_init', 'register_custom_settings_section');

function my_mymail() {
    add_settings_field( 'mymail', 'EMAIL', 'callback_mymail', 'general', 'custom_contact_section' );
    register_setting( 'general', 'my_mymail', 'sanitize_email' );
}

function my_instagramm() {
    add_settings_field( 'instagramm', 'INSTAGRAMM link', 'callback_instagramm', 'general', 'custom_contact_section' );
    register_setting( 'general', 'my_instagramm', 'esc_url_raw' );
}

function my_facebook() {
    add_settings_field( 'facebook', 'Facebook link', 'callback_facebook', 'general', 'custom_contact_section' );
    register_setting( 'general', 'my_facebook', 'esc_url_raw' );
}

function my_youtube() {
    add_settings_field( 'youtube', 'Youtube link', 'callback_youtube', 'general', 'custom_contact_section' );
    register_setting( 'general', 'my_youtube', 'esc_url_raw' );
}

function my_adress() {
    add_settings_field( 'adress', 'adress text', 'callback_adress', 'general', 'custom_contact_section' );
    register_setting( 'general', 'my_adress', 'sanitize_text_field' );
}

function my_phone() {
    add_settings_field( 'phone', 'Телефон', 'callback_phone', 'general', 'custom_contact_section' );
    register_setting( 'general', 'my_phone', 'sanitize_text_field' );
}

function my_phone2() {
    add_settings_field( 'phone2', 'Доп. телефон', 'callback_phone2', 'general', 'custom_contact_section' );
    register_setting( 'general', 'my_phone2', 'sanitize_text_field' );
}

function my_whatsapp() {
    add_settings_field( 'whatsapp', 'WhatsApp номер', 'callback_whatsapp', 'general', 'custom_contact_section' );
    register_setting( 'general', 'my_whatsapp', 'sanitize_text_field' );
}

function my_telegram() {
    add_settings_field( 'telegram', 'Telegram ссылка', 'callback_telegram', 'general', 'custom_contact_section' );
    register_setting( 'general', 'my_telegram', 'esc_url_raw' );
}

function my_2gis() {
    add_settings_field( '2gis', '2GIS ссылка', 'callback_2gis', 'general', 'custom_contact_section' );
    register_setting( 'general', 'my_2gis', 'esc_url_raw' );
}

add_action('admin_init', 'my_mymail');
add_action('admin_init', 'my_instagramm');
add_action('admin_init', 'my_facebook');
add_action('admin_init', 'my_youtube');
add_action('admin_init', 'my_adress');
add_action('admin_init', 'my_phone');
add_action('admin_init', 'my_phone2');
add_action('admin_init', 'my_whatsapp');
add_action('admin_init', 'my_telegram');
add_action('admin_init', 'my_2gis');

function callback_mymail() {
    echo "<input class='regular-text' type='text' name='my_mymail' value='" . esc_attr(get_option('my_mymail')) . "'>";
}
function callback_instagramm() {
    echo "<input class='regular-text' type='text' name='my_instagramm' value='" . esc_attr(get_option('my_instagramm')) . "'>";
}
function callback_facebook() {
    echo "<input class='regular-text' type='text' name='my_facebook' value='" . esc_attr(get_option('my_facebook')) . "'>";
}
function callback_youtube() {
    echo "<input class='regular-text' type='text' name='my_youtube' value='" . esc_attr(get_option('my_youtube')) . "'>";
}
function callback_adress() {
    echo "<input class='regular-text' type='text' name='my_adress' value='" . esc_attr(get_option('my_adress')) . "'>";
}
function callback_phone() {
    echo "<input class='regular-text' type='text' name='my_phone' value='" . esc_attr(get_option('my_phone')) . "'>";
}
function callback_phone2() {
    echo "<input class='regular-text' type='text' name='my_phone2' value='" . esc_attr(get_option('my_phone2')) . "' placeholder='+996 XXX XXX XXX'>";
}
function callback_whatsapp() {
    echo "<input class='regular-text' type='text' name='my_whatsapp' value='" . esc_attr(get_option('my_whatsapp')) . "' placeholder='+996XXXXXXXXX (без пробелов)'>";
}
function callback_telegram() {
    echo "<input class='regular-text' type='text' name='my_telegram' value='" . esc_attr(get_option('my_telegram')) . "' placeholder='https://t.me/username'>";
}
function callback_2gis() {
    echo "<input class='regular-text' type='text' name='my_2gis' value='" . esc_attr(get_option('my_2gis')) . "' placeholder='https://2gis.kg/bishkek/...'>";
}


function df_disable_comments_post_types_support() {
    $post_types = get_post_types();
    foreach ($post_types as $post_type) {
        if(post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}
add_action('admin_init', 'df_disable_comments_post_types_support');

function df_disable_comments_status() {
    return false;
}
add_filter('comments_open', 'df_disable_comments_status', 20, 2);
add_filter('pings_open', 'df_disable_comments_status', 20, 2);

function df_disable_comments_hide_existing_comments($comments) {
    $comments = array();
    return $comments;
}
add_filter('comments_array', 'df_disable_comments_hide_existing_comments', 10, 2);

function df_disable_comments_admin_menu() {
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'df_disable_comments_admin_menu');

function df_disable_comments_admin_menu_redirect() {
    global $pagenow;
    if ($pagenow === 'edit-comments.php') {
        wp_redirect(admin_url()); exit;
    }
}
add_action('admin_init', 'df_disable_comments_admin_menu_redirect');


function my_post_type_sliderims() {
    register_post_type( 'sliderims',
        array(
            'label'               => __('Слайдер', 'asiaterm25'),
            'public'              => true,
            'show_ui'             => true,
            'show_in_nav_menus'   => false,
            'menu_position'       => 10,
            'exclude_from_search' => true,
            'menu_icon'           => 'dashicons-book-alt',
            'rewrite'             => array(
                'slug'       => 'sliderims',
                'with_front' => false,
            ),
            'supports' => array(
                'title',
                'thumbnail',
                'page-attributes'
            ),
        )
    );
}
add_action('init', 'my_post_type_sliderims');

function my_sliderims_fields() {
    add_meta_box(
        'sliderims_fields',
        'Мета слайдера',
        'sliderims_fields_box_func',
        'sliderims',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'my_sliderims_fields');

function sliderims_fields_box_func( $post ) {
    $sliderlink = get_post_meta($post->ID, 'sliderlink', true);
    ?>
    <p><label for="sliderhead"><?php esc_html_e( 'Заголовок', 'asiaterm25' ); ?></label>
    <input type="text" name="sliderims[sliderhead]" id="sliderhead" value="<?php echo esc_attr( get_post_meta($post->ID, 'sliderhead', true) ); ?>" style="width:50%" /></p>

    <p><label for="slidertext"><?php esc_html_e( 'Описание', 'asiaterm25' ); ?></label>
    <input type="text" name="sliderims[slidertext]" id="slidertext" value="<?php echo esc_attr( get_post_meta($post->ID, 'slidertext', true) ); ?>" style="width:50%" /></p>

    <p><label for="sliderlink"><?php esc_html_e( 'Ссылка слайда', 'asiaterm25' ); ?></label>
    <select name="sliderims[sliderlink]" id="sliderlink">
        <option value=""><?php esc_html_e( 'Выберите страницу или запись', 'asiaterm25' ); ?></option>
        <?php
        $args = array('post_type' => array( 'post', 'page' ), 'posts_per_page' => -1, 'post_status' => 'publish');
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) :
            while ( $query->have_posts() ) : $query->the_post();
                echo '<option value="' . get_the_ID() . '" ' . selected( $sliderlink, get_the_ID(), false ) . '>' . get_the_title() . '</option>';
            endwhile;
        endif; wp_reset_postdata();
        ?>
    </select></p>

    <p><label for="sliderbtntext"><?php esc_html_e( 'Текст на кнопке', 'asiaterm25' ); ?></label>
    <input type="text" name="sliderims[sliderbtntext]" id="sliderbtntext" value="<?php echo esc_attr( get_post_meta($post->ID, 'sliderbtntext', true) ); ?>" style="width:50%" /></p>

    <p><label for="sliderfile"><?php esc_html_e( 'Файл слайдера (видео/фото)', 'asiaterm25' ); ?></label><br>
    <input type="hidden" id="sliderfile" name="sliderims[sliderfile]" value="<?php echo esc_attr( get_post_meta($post->ID, 'sliderfile', true) ); ?>" />
    <button class="button upload_slider_file"><?php esc_html_e( 'Выбрать файл', 'asiaterm25' ); ?></button>
    <div id="sliderfile-preview">
        <?php $file_id = get_post_meta($post->ID, 'sliderfile', true);
        if( $file_id ): $file = wp_get_attachment_url($file_id); ?>
            <p><strong><?php echo basename($file); ?></strong>
            <a href="<?php echo esc_url($file); ?>" target="_blank"><?php esc_html_e( 'Смотреть', 'asiaterm25' ); ?></a> |
            <button type="button" class="button remove_slider_file"><?php esc_html_e( 'Удалить', 'asiaterm25' ); ?></button></p>
        <?php endif; ?>
    </div>

    <input type="hidden" name="sliderims_fields_nonce" value="<?php echo wp_create_nonce('sliderims_save'); ?>" />

    <script>
    jQuery(document).ready(function($) {
        $('.upload_slider_file').click(function(e) {
            e.preventDefault();
            var frame = wp.media({
                title: '<?php esc_html_e( "Выберите файл слайдера", "asiaterm25" ); ?>',
                button: { text: '<?php esc_html_e( "Использовать файл", "asiaterm25" ); ?>' },
                multiple: false,
                library: { type: 'video,image' }
            });
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#sliderfile').val(attachment.id);
                $('#sliderfile-preview').html('<p><strong>' + attachment.filename + '</strong> <a href="' + attachment.url + '" target="_blank"><?php esc_html_e( "Смотреть", "asiaterm25" ); ?></a> | <button type="button" class="button remove_slider_file"><?php esc_html_e( "Удалить", "asiaterm25" ); ?></button></p>');
            });
            frame.open();
        });
        $(document).on('click', '.remove_slider_file', function() {
            $('#sliderfile').val(''); $('#sliderfile-preview').html('');
        });
    });
    </script>
    <?php
}

function my_sliderims_fields_update( $post_id ){
    if ( empty( $_POST['sliderims'] )
    || ! wp_verify_nonce( $_POST['sliderims_fields_nonce'], 'sliderims_save' )
    || wp_is_post_autosave( $post_id )
    || wp_is_post_revision( $post_id ) )
        return false;

    $_POST['sliderims'] = array_map( 'sanitize_text_field', $_POST['sliderims'] );

    foreach( $_POST['sliderims'] as $key => $value ){
        if( empty($value) ){
            delete_post_meta( $post_id, $key );
            continue;
        }
        update_post_meta( $post_id, $key, $value );
    }

    return $post_id;
}
add_action( 'save_post', 'my_sliderims_fields_update', 0 );


function create_prod_category_taxonomy() {
    register_taxonomy(
        'prod_category',
        array('page'),
        array(
            'label'             => 'Категории продуктов',
            'public'            => true,
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array(
                'slug'       => 'prod-category',
                'with_front' => false,
            ),
        )
    );
}
add_action('init', 'create_prod_category_taxonomy', 0);

function fix_prod_category_archive($query) {
    if (!is_admin() && $query->is_main_query() && is_tax('prod_category')) {
        $query->set('post_type', 'page');
    }
}
add_action('pre_get_posts', 'fix_prod_category_archive');

function add_prod_category_menu() {
    add_menu_page(
        'Категории продуктов',
        'Категории продуктов',
        'manage_options',
        'edit-tags.php?taxonomy=prod_category&post_type=page',
        '',
        'dashicons-category',
        20
    );
}
add_action('admin_menu', 'add_prod_category_menu');

function add_prod_category_thumbnail_field($term = null) {
    $thumbnail_id  = '';
    $thumbnail_url = '';

    if ($term && is_object($term)) {
        $thumbnail_id  = get_term_meta($term->term_id, 'prod_category_thumbnail', true);
        $thumbnail_url = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : '';
    }
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="prod_category_thumbnail">Миниатюра</label></th>
        <td>
            <input type="hidden" id="prod_category_thumbnail" name="prod_category_thumbnail" value="<?php echo esc_attr($thumbnail_id); ?>">
            <img id="prod_category_thumbnail_preview" src="<?php echo esc_url($thumbnail_url); ?>" style="max-width: 150px; height: auto; display: <?php echo $thumbnail_url ? 'block' : 'none'; ?>; margin-bottom: 10px;">
            <button type="button" class="button upload_image_button">Выбрать изображение</button>
            <button type="button" class="button remove_image_button" style="display: <?php echo $thumbnail_url ? 'inline-block' : 'none'; ?>;">Удалить</button>
            <p class="description">Рекомендуемый размер: 300x300px</p>
        </td>
    </tr>
    <?php
}
add_action('prod_category_add_form_fields', 'add_prod_category_thumbnail_field');
add_action('prod_category_edit_form_fields', 'add_prod_category_thumbnail_field', 10, 2);

function enqueue_prod_category_scripts($hook) {
    if (!in_array($hook, ['edit-tags.php', 'term.php'])) {
        return;
    }
    if (!isset($_GET['taxonomy']) || $_GET['taxonomy'] !== 'prod_category') {
        return;
    }

    wp_enqueue_media();

    $js_path = get_template_directory_uri() . '/js/prod-category-thumbnail.js';
    wp_enqueue_script(
        'prod-category-thumbnail-script',
        $js_path,
        array('jquery'),
        '1.0.0',
        true
    );

    wp_localize_script('prod-category-thumbnail-script', 'prodCategoryL10n', array(
        'title'  => 'Выберите миниатюру категории',
        'button' => 'Использовать это изображение'
    ));
}
add_action('admin_enqueue_scripts', 'enqueue_prod_category_scripts');

function save_prod_category_thumbnail($term_id) {
    if (isset($_POST['prod_category_thumbnail'])) {
        $thumbnail_id = absint($_POST['prod_category_thumbnail']);
        if ($thumbnail_id) {
            update_term_meta($term_id, 'prod_category_thumbnail', $thumbnail_id);
        } else {
            delete_term_meta($term_id, 'prod_category_thumbnail');
        }
    }
}
add_action('edited_prod_category', 'save_prod_category_thumbnail');
add_action('created_prod_category', 'save_prod_category_thumbnail');

function add_prod_category_thumbnail_column($columns) {
    $columns['prod_category_thumbnail'] = 'Миниатюра';
    return $columns;
}
add_filter('manage_edit-prod_category_columns', 'add_prod_category_thumbnail_column');

function show_prod_category_thumbnail_column($content, $column_name, $term_id) {
    if ($column_name === 'prod_category_thumbnail') {
        $thumbnail_id = get_term_meta($term_id, 'prod_category_thumbnail', true);
        if ($thumbnail_id) {
            $thumbnail_url = wp_get_attachment_image_url($thumbnail_id, 'thumbnail');
            if ($thumbnail_url) {
                $content = '<img src="' . esc_url($thumbnail_url) . '" style="max-width: 50px; height: auto;">';
            }
        }
    }
    return $content;
}
add_filter('manage_prod_category_custom_column', 'show_prod_category_thumbnail_column', 10, 3);


function your_prefix_get_all_descendants( $parent_id, $visited = [] ) {
    $descendants = [];

    if ( in_array( $parent_id, $visited ) ) {
        return $descendants;
    }
    $visited[] = $parent_id;

    $children = get_pages( [
        'child_of'     => $parent_id,
        'post_type'    => 'page',
        'post_status'  => 'publish',
        'fields'       => 'ids',
        'hierarchical' => true,
    ] );

    if ( $children ) {
        foreach ( $children as $child_id ) {
            if ( ! in_array( $child_id, $descendants ) ) {
                $descendants[] = $child_id;
                $descendants   = array_merge( $descendants, your_prefix_get_all_descendants( $child_id, $visited ) );
            }
        }
    }

    return $descendants;
}
add_filter( 'rwmb_meta_boxes', 'your_prefix_register_meta_boxes' );

function your_prefix_register_meta_boxes( $meta_boxes ) {
    $prefix = 'prod_';

    // Для всех страниц
    $meta_boxes[] = [
        'title'      => esc_html__( 'Основные параметры', 'asiaterm25' ),
        'id'         => 'product_params_base',
        'post_types' => ['page'],
        'context'    => 'normal',
        'priority'   => 'high',
        'fields'     => [

            [
                'type' => 'textarea',
                'name' => esc_html__( 'Иконка', 'asiaterm25' ),
                'id'   => $prefix . 'icon',
                'desc' => esc_html__( 'Вставьте HTML-код иконки (SVG, Font Awesome и т.д.)', 'asiaterm25' ),
                'rows' => 3,
            ],

            [
                'type'             => 'image_advanced',
                'name'             => esc_html__( 'Галерея', 'asiaterm25' ),
                'id'               => $prefix . 'service_gallery',
                'desc'             => esc_html__( 'Загрузите до 20 изображений', 'asiaterm25' ),
                'max_file_uploads' => 20,
            ],

        ],
    ];

    // Для page-category.php и page-complexproduct.php — иконки с описанием
    $meta_boxes[] = [
        'title'      => esc_html__( 'Параметры категории / Иконки', 'asiaterm25' ),
        'id'         => 'category_params',
        'post_types' => ['page'],
        'context'    => 'normal',
        'priority'   => 'high',
        'show'       => [
            'template' => ['page-category.php', 'page-complexproduct.php'],
        ],
        'fields'     => [
            [
                'name'    => esc_html__( 'Краткое описание', 'asiaterm25' ),
                'id'      => $prefix . 'cat_shortdesc',
                'type'    => 'wysiwyg',
                'options' => [
                    'textarea_rows' => 6,
                    'media_buttons' => false,
                    'teeny'         => true,
                ],
            ],
            [
                'name'       => esc_html__( 'Иконки-преимущества', 'asiaterm25' ),
                'id'         => $prefix . 'cat_features',
                'type'       => 'group',
                'clone'      => true,
                'add_button' => esc_html__( '+ Добавить иконку', 'asiaterm25' ),
                'fields'     => [
                    [
                        'name'             => esc_html__( 'Иконка (SVG/PNG)', 'asiaterm25' ),
                        'id'               => 'feature_icon',
                        'type'             => 'image_advanced',
                        'max_file_uploads' => 1,
                        'desc'             => esc_html__( 'SVG или PNG иконка', 'asiaterm25' ),
                    ],
                    [
                        'name' => esc_html__( 'Заголовок', 'asiaterm25' ),
                        'id'   => 'feature_title',
                        'type' => 'text',
                    ],
                    [
                        'name' => esc_html__( 'Описание', 'asiaterm25' ),
                        'id'   => 'feature_desc',
                        'type' => 'textarea',
                        'rows' => 2,
                    ],
                ],
            ],
        ],
    ];

    // Для page-singleproduct.php и page-complexproduct.php
    $meta_boxes[] = [
        'title'      => esc_html__( 'Параметры товара', 'asiaterm25' ),
        'id'         => 'product_params',
        'post_types' => ['page'],
        'context'    => 'normal',
        'priority'   => 'high',
        'show'       => [
            'template' => ['page-singleproduct.php', 'page-complexproduct.php'],
        ],
        'fields'     => [
		
			[
				'name' => esc_html__( 'Показать на главной', 'asiaterm25' ),
				'id'   => $prefix . 'show_on_home',
				'type' => 'checkbox',
				'desc' => esc_html__( 'Вывести товар в блоке "Популярные товары"', 'asiaterm25' ),
			],
			
			[
				'name'        => esc_html__( 'Цена', 'asiaterm25' ),
				'id'          => $prefix . 'price',
				'type'        => 'text',
				'placeholder' => '999',
			],		

            [
                'type'             => 'image_advanced',
                'name'             => esc_html__( 'Галерея дополнительная', 'asiaterm25' ),
                'id'               => $prefix . 'service_gallery2',
                'desc'             => esc_html__( 'Загрузите до 20 изображений', 'asiaterm25' ),
                'max_file_uploads' => 20,
            ],
			
			[
				'name'        => esc_html__( 'Вариации', 'asiaterm25' ),
				'id'          => $prefix . 'var_titles',
				'type'        => 'text',
				'clone'       => true,
				'add_button'  => esc_html__( '+ Добавить вариацию', 'asiaterm25' ),
				'placeholder' => 'Стандарт / Премиум',
			],

 
            [
                'name'    => esc_html__( 'Технические характеристики', 'asiaterm25' ),
                'id'      => $prefix . 'specs',
                'type'    => 'wysiwyg',
                'options' => [
                    'textarea_rows' => 12,
                    'media_buttons' => true,
                    'teeny'         => false,
                ],
                'desc'    => esc_html__( 'Подробное описание с форматированием, таблицами и изображениями', 'asiaterm25' ),
            ],

            [
                'name'    => esc_html__( 'Краткое описание', 'asiaterm25' ),
                'id'      => $prefix . 'shortdesc',
                'type'    => 'wysiwyg',
                'options' => [
                    'textarea_rows' => 12,
                    'media_buttons' => true,
                    'teeny'         => false,
                ],
                'desc'    => esc_html__( 'Краткое текстовое описание', 'asiaterm25' ),
            ],

            [
                'name' => esc_html__( 'Название блока', 'asiaterm25' ),
                'id'   => $prefix . 'costomdescr_title',
                'type' => 'text',
            ],

            [
                'name'    => esc_html__( 'Произвольный редактор', 'asiaterm25' ),
                'id'      => $prefix . 'costomdescr',
                'type'    => 'wysiwyg',
                'options' => [
                    'textarea_rows' => 12,
                    'media_buttons' => true,
                    'teeny'         => false,
                ],
                'desc'    => esc_html__( 'Краткое текстовое описание', 'asiaterm25' ),
            ],

            [
                'name'    => esc_html__( 'Комплектация', 'asiaterm25' ),
                'id'      => $prefix . 'complect',
                'type'    => 'wysiwyg',
                'options' => [
                    'textarea_rows' => 12,
                    'media_buttons' => true,
                    'teeny'         => false,
                ],
                'desc'    => esc_html__( 'Текстовое описание комплектации', 'asiaterm25' ),
            ],

            [
                'name'             => esc_html__( 'Файлы для скачивания', 'asiaterm25' ),
                'id'               => $prefix . 'downloads',
                'type'             => 'file_advanced',
                'max_file_uploads' => 10,
                'mime_type'        => 'application/pdf,image,application/zip,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'add_button'       => esc_html__( '+ Добавить медиа', 'asiaterm25' ),
                'desc'             => esc_html__( 'PDF, JPG, PNG. Максимум 10 файлов.', 'asiaterm25' ),
            ],

            [
                'name'        => esc_html__( 'Смежные товары', 'asiaterm25' ),
                'id'          => $prefix . 'related_pages',
                'type'        => 'post',
                'post_type'   => 'page',
                'field_type'  => 'select_advanced',
                'multiple'    => true,
                'placeholder' => esc_html__( 'Выберите смежные товары', 'asiaterm25' ),
                'query_args'  => [
                    'post_status'    => 'publish',
                    'posts_per_page' => -1,
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                ],
                'desc'        => esc_html__( 'Только страницы, вложенные в ID 13 (включая подуровни)', 'asiaterm25' ),
            ],

            [
                'name'        => esc_html__( 'Портфолио проекты', 'asiaterm25' ),
                'id'          => $prefix . 'portfolio_pages',
                'type'        => 'post',
                'post_type'   => 'page',
                'field_type'  => 'select_advanced',
                'multiple'    => true,
                'placeholder' => esc_html__( 'Выберите портфолио', 'asiaterm25' ),
                'query_args'  => [
                    'post_status'    => 'publish',
                    'posts_per_page' => -1,
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                ],
                'desc'        => esc_html__( 'Только страницы, вложенные в ID 29 (включая подуровни)', 'asiaterm25' ),
            ],

        ],
    ];

    // Шаблон "О нас"
    $meta_boxes[] = [
        'title'      => esc_html__( 'Контент страницы "О нас"', 'asiaterm25' ),
        'id'         => 'about_params',
        'post_types' => ['page'],
        'context'    => 'normal',
        'priority'   => 'high',
        'show'       => [
            'template' => ['page-about.php'],
        ],
        'fields'     => [
            [
                'type'             => 'image_advanced',
                'name'             => esc_html__( 'Фото компании', 'asiaterm25' ),
                'id'               => 'about_image',
                'max_file_uploads' => 1,
            ],
            [
                'name'    => esc_html__( 'Текст о компании', 'asiaterm25' ),
                'id'      => 'about_text',
                'type'    => 'wysiwyg',
                'options' => ['textarea_rows' => 10, 'media_buttons' => true],
            ],
            [
                'type'             => 'image_advanced',
                'name'             => esc_html__( 'Галерея', 'asiaterm25' ),
                'id'               => 'about_gallery',
                'max_file_uploads' => 20,
            ],
            [
                'name'       => esc_html__( 'Преимущества', 'asiaterm25' ),
                'id'         => 'about_features',
                'type'       => 'group',
                'clone'      => true,
                'add_button' => esc_html__( '+ Добавить преимущество', 'asiaterm25' ),
                'fields'     => [
                    [
                        'name' => esc_html__( 'Номер', 'asiaterm25' ),
                        'id'   => 'about_feature_num',
                        'type' => 'text',
                        'placeholder' => '01',
                        'size' => 5,
                    ],
                    [
                        'name' => esc_html__( 'Заголовок', 'asiaterm25' ),
                        'id'   => 'about_feature_title',
                        'type' => 'text',
                    ],
                    [
                        'name' => esc_html__( 'Описание', 'asiaterm25' ),
                        'id'   => 'about_feature_desc',
                        'type' => 'textarea',
                        'rows' => 3,
                    ],
                ],
            ],
            [
                'name'       => esc_html__( 'Команда', 'asiaterm25' ),
                'id'         => 'about_team',
                'type'       => 'group',
                'clone'      => true,
                'add_button' => esc_html__( '+ Добавить сотрудника', 'asiaterm25' ),
                'fields'     => [
                    [
                        'type'             => 'image_advanced',
                        'name'             => esc_html__( 'Фото', 'asiaterm25' ),
                        'id'               => 'team_photo',
                        'max_file_uploads' => 1,
                    ],
                    [
                        'name' => esc_html__( 'Имя', 'asiaterm25' ),
                        'id'   => 'team_name',
                        'type' => 'text',
                    ],
                    [
                        'name' => esc_html__( 'Должность', 'asiaterm25' ),
                        'id'   => 'team_position',
                        'type' => 'text',
                    ],
                ],
            ],
            [
                'name' => esc_html__( 'HTML-код карты', 'asiaterm25' ),
                'id'   => 'about_map_embed',
                'type' => 'textarea',
                'rows' => 4,
                'desc' => esc_html__( 'Вставьте iframe карты (Google/Yandex/2GIS)', 'asiaterm25' ),
            ],
        ],
    ];

    // Шаблон "Услуги"
    $meta_boxes[] = [
        'title'      => esc_html__( 'Контент страницы "Услуги"', 'asiaterm25' ),
        'id'         => 'services_params',
        'post_types' => ['page'],
        'context'    => 'normal',
        'priority'   => 'high',
        'show'       => [
            'template' => ['page-services.php'],
        ],
        'fields'     => [
            [
                'name'       => esc_html__( 'Список услуг', 'asiaterm25' ),
                'id'         => 'services_list',
                'type'       => 'group',
                'clone'      => true,
                'add_button' => esc_html__( '+ Добавить услугу', 'asiaterm25' ),
                'fields'     => [
                    [
                        'name'        => esc_html__( 'Иконка (CSS-класс)', 'asiaterm25' ),
                        'id'          => 'service_icon',
                        'type'        => 'text',
                        'placeholder' => 'fas fa-building',
                    ],
                    [
                        'name' => esc_html__( 'Заголовок', 'asiaterm25' ),
                        'id'   => 'service_title',
                        'type' => 'text',
                    ],
                    [
                        'name'    => esc_html__( 'Описание', 'asiaterm25' ),
                        'id'      => 'service_desc',
                        'type'    => 'wysiwyg',
                        'options' => ['textarea_rows' => 6, 'media_buttons' => false],
                    ],
                    [
                        'name' => esc_html__( 'Ссылка', 'asiaterm25' ),
                        'id'   => 'service_link',
                        'type' => 'url',
                    ],
                    [
                        'type'             => 'image_advanced',
                        'name'             => esc_html__( 'Изображение', 'asiaterm25' ),
                        'id'               => 'service_image',
                        'max_file_uploads' => 1,
                    ],
                ],
            ],
        ],
    ];

    // Шаблон "Сертификаты"
    $meta_boxes[] = [
        'title'      => esc_html__( 'Контент страницы "Сертификаты"', 'asiaterm25' ),
        'id'         => 'cert_params',
        'post_types' => ['page'],
        'context'    => 'normal',
        'priority'   => 'high',
        'show'       => [
            'template' => ['page-certificates.php'],
        ],
        'fields'     => [
            [
                'name'        => esc_html__( 'YouTube видео URL', 'asiaterm25' ),
                'id'          => 'cert_video_url',
                'type'        => 'url',
                'placeholder' => 'https://www.youtube.com/watch?v=...',
            ],
            [
                'name' => esc_html__( 'Заголовок секции', 'asiaterm25' ),
                'id'   => 'cert_heading',
                'type' => 'text',
            ],
            [
                'name'       => esc_html__( 'Кнопки', 'asiaterm25' ),
                'id'         => 'cert_buttons',
                'type'       => 'group',
                'clone'      => true,
                'add_button' => esc_html__( '+ Добавить кнопку', 'asiaterm25' ),
                'fields'     => [
                    [
                        'name' => esc_html__( 'Текст кнопки', 'asiaterm25' ),
                        'id'   => 'cert_btn_text',
                        'type' => 'text',
                    ],
                    [
                        'name' => esc_html__( 'Ссылка', 'asiaterm25' ),
                        'id'   => 'cert_btn_url',
                        'type' => 'url',
                    ],
                ],
            ],
            [
                'type'             => 'image_advanced',
                'name'             => esc_html__( 'Галерея сертификатов', 'asiaterm25' ),
                'id'               => 'cert_gallery',
                'max_file_uploads' => 20,
            ],
        ],
    ];

    // Шаблон "Партнёрам"
    $meta_boxes[] = [
        'title'      => esc_html__( 'Контент страницы "Партнёрам"', 'asiaterm25' ),
        'id'         => 'partners_params',
        'post_types' => ['page'],
        'context'    => 'normal',
        'priority'   => 'high',
        'show'       => [
            'template' => ['page-partners.php'],
        ],
        'fields'     => [
            [
                'name'    => esc_html__( 'Вступительный текст', 'asiaterm25' ),
                'id'      => 'partners_intro',
                'type'    => 'wysiwyg',
                'options' => ['textarea_rows' => 8, 'media_buttons' => true],
            ],
            [
                'name'       => esc_html__( 'Организации-партнёры (дилеры)', 'asiaterm25' ),
                'id'         => 'partners_brands',
                'type'       => 'group',
                'clone'      => true,
                'add_button' => esc_html__( '+ Добавить организацию', 'asiaterm25' ),
                'fields'     => [
                    [
                        'type'             => 'image_advanced',
                        'name'             => esc_html__( 'Логотип', 'asiaterm25' ),
                        'id'               => 'brand_logo',
                        'max_file_uploads' => 1,
                    ],
                    [
                        'name' => esc_html__( 'Название компании', 'asiaterm25' ),
                        'id'   => 'brand_name',
                        'type' => 'text',
                    ],
                    [
                        'name' => esc_html__( 'Краткое описание', 'asiaterm25' ),
                        'id'   => 'brand_desc',
                        'type' => 'textarea',
                        'rows' => 3,
                    ],
                    [
                        'name'        => esc_html__( 'Тип продукции', 'asiaterm25' ),
                        'id'          => 'brand_product_type',
                        'type'        => 'text',
                        'placeholder' => 'Конвекторы, радиаторы, котлы',
                    ],
                    [
                        'name' => esc_html__( 'Адрес / Страна', 'asiaterm25' ),
                        'id'   => 'brand_address',
                        'type' => 'text',
                    ],
                    [
                        'name' => esc_html__( 'Сайт', 'asiaterm25' ),
                        'id'   => 'brand_website',
                        'type' => 'url',
                    ],
                    [
                        'type'             => 'image_advanced',
                        'name'             => esc_html__( 'Фото продукции', 'asiaterm25' ),
                        'id'               => 'brand_photo',
                        'max_file_uploads' => 1,
                    ],
                ],
            ],
            [
                'type'             => 'image_advanced',
                'name'             => esc_html__( 'Логотипы партнёров (карусель)', 'asiaterm25' ),
                'id'               => 'partners_logos',
                'max_file_uploads' => 20,
            ],
        ],
    ];

    // Шаблон "Контакты"
    $meta_boxes[] = [
        'title'      => esc_html__( 'Контент страницы "Контакты"', 'asiaterm25' ),
        'id'         => 'contact_params',
        'post_types' => ['page'],
        'context'    => 'normal',
        'priority'   => 'high',
        'show'       => [
            'template' => ['page-contact.php'],
        ],
        'desc'       => esc_html__( 'Адрес, телефон, email — из Настройки → Общие → Контактная информация', 'asiaterm25' ),
        'fields'     => [
            [
                'name' => esc_html__( 'Режим работы', 'asiaterm25' ),
                'id'   => 'contact_work_hours',
                'type' => 'text',
                'placeholder' => 'Пн-Пт: 09:00 - 18:00',
            ],
            [
                'name' => esc_html__( 'HTML-код карты', 'asiaterm25' ),
                'id'   => 'contact_map_embed',
                'type' => 'textarea',
                'rows' => 4,
                'desc' => esc_html__( 'Вставьте iframe карты (Google/Yandex/2GIS)', 'asiaterm25' ),
            ],
            [
                'name'    => esc_html__( 'Дополнительная информация', 'asiaterm25' ),
                'id'      => 'contact_extra_info',
                'type'    => 'wysiwyg',
                'options' => ['textarea_rows' => 8, 'media_buttons' => true],
            ],
        ],
    ];

    return $meta_boxes;
}

function allow_svg_uploads($mimes) {
    if (current_user_can('administrator')) {
        $mimes['svg']  = 'image/svg+xml';
        $mimes['svgz'] = 'image/svg+xml';
		$mimes['avif'] = 'image/avif';
    }
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_uploads');

add_filter('file_is_displayable_image', function($result, $path) {
    if (!$result) {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if ($ext === 'avif') {
            $result = true;
        }
    }
    return $result;
}, 10, 2);

function sanitize_svg($file) {
    if ($file['type'] !== 'image/svg+xml') return $file;

    $svg_content = file_get_contents($file['tmp_name']);
    $svg_content = preg_replace('/<script[^>]*>.*?<\/script>/is', '', $svg_content);
    $svg_content = preg_replace('/\s+on\w+=["\'][^"\']*["\']/i', '', $svg_content);
    $svg_content = preg_replace('/(href|xlink:href)\s*=\s*["\']javascript:[^"\']*["\']/i', '', $svg_content);
    file_put_contents($file['tmp_name'], $svg_content);

    return $file;
}
add_filter('wp_handle_upload_prefilter', 'sanitize_svg');  



function duplicate_page_as_draft() {
    if ( !isset($_GET['action']) || $_GET['action'] !== 'duplicate_page' ) return;
    if ( !isset($_GET['post']) || !isset($_GET['nonce']) ) return;
    if ( !wp_verify_nonce($_GET['nonce'], 'duplicate_page_' . $_GET['post']) ) return;
    if ( !current_user_can('edit_posts') ) return;

    $post_id = absint($_GET['post']);
    $post    = get_post($post_id);

    if ( !$post ) return;

    $new_post = [
        'post_title'    => $post->post_title . ' (копия)',
        'post_content'  => $post->post_content,
        'post_excerpt'  => $post->post_excerpt,
        'post_status'   => 'draft',
        'post_type'     => $post->post_type,
        'post_author'   => get_current_user_id(),
        'post_parent'   => $post->post_parent,
        'menu_order'    => $post->menu_order,
        'post_password' => $post->post_password,
    ];

    $new_id = wp_insert_post($new_post);

    if ( is_wp_error($new_id) ) return;

    // Копируем мета-поля
    $meta = get_post_meta($post_id);
    if ($meta) {
        $skip = ['_edit_lock', '_edit_last', '_wp_old_slug', '_wp_trash_meta_status', '_wp_trash_meta_time'];
        foreach ($meta as $key => $values) {
            if ( in_array($key, $skip) ) continue;
            foreach ($values as $value) {
                $value = maybe_unserialize($value);
                if ( is_array($value) ) {
                    update_post_meta($new_id, $key, $value);
                } else {
                    add_post_meta($new_id, $key, $value);
                }
            }
        }
    }

    // Копируем таксономии
    $taxonomies = get_object_taxonomies($post->post_type);
    if ($taxonomies) {
        foreach ($taxonomies as $taxonomy) {
            $terms = wp_get_object_terms($post_id, $taxonomy, ['fields' => 'ids']);
            if ( !empty($terms) && !is_wp_error($terms) ) {
                wp_set_object_terms($new_id, $terms, $taxonomy);
            }
        }
    }

    // Копируем миниатюру
    $thumbnail_id = get_post_thumbnail_id($post_id);
    if ($thumbnail_id) {
        set_post_thumbnail($new_id, $thumbnail_id);
    }

    // Копируем шаблон страницы
    $template = get_page_template_slug($post_id);
    if ($template) {
        update_post_meta($new_id, '_wp_page_template', $template);
    }

    wp_redirect(admin_url('edit.php?post_type=' . $post->post_type . '&duplicated=1'));
    exit;
}
add_action('admin_action_duplicate_page', 'duplicate_page_as_draft');


function duplicate_page_link($actions, $post) {
    if ( !current_user_can('edit_posts') ) return $actions;

    $nonce = wp_create_nonce('duplicate_page_' . $post->ID);
    $url   = admin_url('admin.php?action=duplicate_page&post=' . $post->ID . '&nonce=' . $nonce);

    $actions['duplicate'] = '<a href="' . esc_url($url) . '">Копировать</a>';

    return $actions;
}
add_filter('page_row_actions', 'duplicate_page_link', 10, 2);
add_filter('post_row_actions', 'duplicate_page_link', 10, 2);


function duplicate_page_admin_notice() {
    if ( isset($_GET['duplicated']) ) {
        echo '<div class="notice notice-success is-dismissible"><p>Страница скопирована как черновик.</p></div>';
    }
}
add_action('admin_notices', 'duplicate_page_admin_notice');


// AJAX: отправка формы партнёра на email
function asiaterm_partner_form_send() {
    check_ajax_referer('partner_form_nonce', 'nonce');

    $company  = sanitize_text_field($_POST['company'] ?? '');
    $contact  = sanitize_text_field($_POST['contact_person'] ?? '');
    $email    = sanitize_email($_POST['email'] ?? '');
    $phone    = sanitize_text_field($_POST['phone'] ?? '');
    $message  = sanitize_textarea_field($_POST['message'] ?? '');

    if (empty($company) || empty($contact) || (empty($email) && empty($phone))) {
        wp_send_json_error(['message' => 'Заполните обязательные поля']);
    }

    $to = get_option('my_mymail');
    if (!$to) {
        wp_send_json_error(['message' => 'Email получателя не настроен']);
    }

    $subject = 'Запрос от партнёра: ' . $company;
    $body  = "Организация: {$company}\n";
    $body .= "Контактное лицо: {$contact}\n";
    if ($email) $body .= "Email: {$email}\n";
    if ($phone) $body .= "Телефон: {$phone}\n";
    $body .= "\nСообщение:\n{$message}";

    $headers = ['Content-Type: text/plain; charset=UTF-8'];
    if ($email) {
        $headers[] = 'Reply-To: ' . $email;
    }

    $sent = wp_mail($to, $subject, $body, $headers);

    if ($sent) {
        wp_send_json_success(['message' => 'Запрос успешно отправлен']);
    } else {
        wp_send_json_error(['message' => 'Ошибка при отправке']);
    }
}
add_action('wp_ajax_partner_form_send', 'asiaterm_partner_form_send');
add_action('wp_ajax_nopriv_partner_form_send', 'asiaterm_partner_form_send');


// === SEO ===

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
    $schema = [];
    $site_name = get_bloginfo('name');
    $site_url  = home_url('/');
    $phone     = get_option('my_phone');
    $email     = get_option('my_mymail');
    $address   = get_option('my_adress');
    $logo_url  = get_template_directory_uri() . '/files/logotest.svg';

    // ── Organization / LocalBusiness — на всех страницах ──
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
    $socials = [];
    if (get_option('my_instagramm')) $socials[] = get_option('my_instagramm');
    if (get_option('my_facebook'))   $socials[] = get_option('my_facebook');
    if (get_option('my_youtube'))    $socials[] = get_option('my_youtube');
    if (get_option('my_telegram'))   $socials[] = get_option('my_telegram');
    if (get_option('my_2gis'))       $socials[] = get_option('my_2gis');
    if ($socials) $org['sameAs'] = $socials;
    $schema[] = $org;

    // ── WebSite — на главной ──
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

    // ── WebPage — на обычных страницах ──
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

        // Контакты → ContactPage
        if (is_page_template('page-contact.php')) {
            $page_schema['@type'] = 'ContactPage';
        }
        // О нас → AboutPage
        if (is_page_template('page-about.php')) {
            $page_schema['@type'] = 'AboutPage';
        }

        $schema[] = $page_schema;
    }

    // ── Product — товары ──
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
        // Категория (родительская страница)
        $parent_id = wp_get_post_parent_id(get_the_ID());
        if ($parent_id) {
            $product['category'] = get_the_title($parent_id);
        }
        // Цена
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
        // Вариации
        $var_titles = rwmb_meta('prod_var_titles');
        if ($var_titles) {
            $product['model'] = implode(', ', $var_titles);
        }
        // Галерея
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

    // ── CollectionPage + ItemList — категории и каталог ──
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
        // Дочерние товары как ItemList
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

    // ── BlogPosting — записи блога ──
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

    // ── BreadcrumbList — на всех кроме главной ──
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
add_action('wp_head', 'asiaterm_schema_output', 5);