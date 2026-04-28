<?php

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

    $taxonomies = get_object_taxonomies($post->post_type);
    if ($taxonomies) {
        foreach ($taxonomies as $taxonomy) {
            $terms = wp_get_object_terms($post_id, $taxonomy, ['fields' => 'ids']);
            if ( !empty($terms) && !is_wp_error($terms) ) {
                wp_set_object_terms($new_id, $terms, $taxonomy);
            }
        }
    }

    $thumbnail_id = get_post_thumbnail_id($post_id);
    if ($thumbnail_id) {
        set_post_thumbnail($new_id, $thumbnail_id);
    }

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
