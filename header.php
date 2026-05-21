<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php
// Yandex / Google webmaster verification
$yandex_v = get_option('my_yandex_verification');
$google_v = get_option('my_google_verification');
if ($yandex_v) : ?>
<meta name="yandex-verification" content="<?php echo esc_attr($yandex_v); ?>">
<?php endif; if ($google_v) : ?>
<meta name="google-site-verification" content="<?php echo esc_attr($google_v); ?>">
<?php endif; ?>

<?php $seo_desc = asiaterm_meta_description(); ?>
<meta name="description" content="<?php echo esc_attr($seo_desc); ?>">
<meta name="robots" content="index, follow">
<link rel="canonical" href="<?php echo esc_url(get_permalink()); ?>">

<?php
// Geo meta (для Яндекс.Карт и локального поиска)
$geo_lat = get_option('my_geo_lat');
$geo_lng = get_option('my_geo_lng');
if ($geo_lat && $geo_lng) : ?>
<meta name="ICBM" content="<?php echo esc_attr($geo_lat . ', ' . $geo_lng); ?>">
<meta name="geo.position" content="<?php echo esc_attr($geo_lat . ';' . $geo_lng); ?>">
<meta name="geo.placename" content="Бишкек">
<meta name="geo.region" content="KG-B">
<?php endif; ?>

<!-- Open Graph -->
<meta property="og:type" content="<?php echo is_singular() ? (is_page_template(['page-singleproduct.php', 'page-complexproduct.php']) ? 'product' : 'article') : 'website'; ?>">
<meta property="og:title" content="<?php echo esc_attr(wp_get_document_title()); ?>">
<meta property="og:description" content="<?php echo esc_attr($seo_desc); ?>">
<meta property="og:url" content="<?php echo esc_url(get_permalink()); ?>">
<meta property="og:site_name" content="<?php bloginfo('name'); ?>">
<meta property="og:locale" content="<?php echo esc_attr(get_locale()); ?>">
<?php
if (has_post_thumbnail()) :
    $og_img_id  = get_post_thumbnail_id();
    $og_meta    = $og_img_id ? wp_get_attachment_image_src($og_img_id, 'large') : null;
    $og_img_url = get_the_post_thumbnail_url(null, 'large');
?>
<meta property="og:image" content="<?php echo esc_url($og_img_url); ?>">
<?php if ($og_meta) : ?>
<meta property="og:image:width" content="<?php echo (int) $og_meta[1]; ?>">
<meta property="og:image:height" content="<?php echo (int) $og_meta[2]; ?>">
<meta property="og:image:type" content="<?php echo esc_attr(get_post_mime_type($og_img_id)); ?>">
<?php endif; ?>
<?php endif; ?>

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo esc_attr(wp_get_document_title()); ?>">
<meta name="twitter:description" content="<?php echo esc_attr($seo_desc); ?>">
<?php if (has_post_thumbnail()) : ?>
<meta name="twitter:image" content="<?php echo esc_url(get_the_post_thumbnail_url(null, 'large')); ?>">
<?php endif; ?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
