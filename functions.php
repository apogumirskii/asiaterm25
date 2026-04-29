<?php

if ( ! function_exists('rwmb_meta') ) {
    function rwmb_meta($key, $args = '', $post_id = null) { return ''; }
}

$inc = get_template_directory() . '/inc/';
require_once $inc . 'setup.php';
require_once $inc . 'svg-support.php';
require_once $inc . 'menu.php';
require_once $inc . 'emoji-disable.php';
require_once $inc . 'cache-helpers.php';
require_once $inc . 'asset-prime.php';
require_once $inc . 'template-helpers.php';
require_once $inc . 'breadcrumbs.php';
require_once $inc . 'contact-options.php';
require_once $inc . 'comments-disable.php';
require_once $inc . 'cpt-slider.php';
require_once $inc . 'cpt-portfolio.php';
require_once $inc . 'meta-boxes.php';
require_once $inc . 'post-duplicate.php';
require_once $inc . 'ajax-handlers.php';
require_once $inc . 'seo-schema.php';
require_once $inc . 'webp.php';
require_once $inc . 'admin-cleanup.php';
