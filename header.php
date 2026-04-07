<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php $seo_desc = asiaterm_meta_description(); ?>
<meta name="description" content="<?php echo esc_attr($seo_desc); ?>">
<meta name="robots" content="index, follow">
<link rel="canonical" href="<?php echo esc_url(get_permalink()); ?>">

<!-- Open Graph -->
<meta property="og:type" content="<?php echo is_singular() ? (is_page_template(['page-singleproduct.php', 'page-complexproduct.php']) ? 'product' : 'article') : 'website'; ?>">
<meta property="og:title" content="<?php echo esc_attr(wp_get_document_title()); ?>">
<meta property="og:description" content="<?php echo esc_attr($seo_desc); ?>">
<meta property="og:url" content="<?php echo esc_url(get_permalink()); ?>">
<meta property="og:site_name" content="<?php bloginfo('name'); ?>">
<meta property="og:locale" content="<?php echo esc_attr(get_locale()); ?>">
<?php if (has_post_thumbnail()) : ?>
<meta property="og:image" content="<?php echo esc_url(get_the_post_thumbnail_url(null, 'large')); ?>">
<?php endif; ?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
