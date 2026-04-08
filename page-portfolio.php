<?php get_header(); /* Template Name: Portfolio */
include(locate_template('template-parts/menu.php'));
include(locate_template('template-parts/phead.php'));
?>

<?php if (have_posts()) : the_post();
    $current_id = get_the_ID();
    $children   = get_pages([
        'parent'      => $current_id,
        'post_status' => 'publish',
        'sort_column' => 'menu_order',
    ]);
?>

<?php if ($children) : ?>

    <section id="portfolio-page" class="py-5">
        <div class="container">

            <?php if (get_the_excerpt()) : ?>
            <div class="text-center mb-5">
                <p class="company-text mx-auto" style="max-width: 40rem;"><?php the_excerpt(); ?></p>
            </div>
            <?php endif; ?>

            <div class="row g-4">
                <?php foreach ($children as $port) :
                    $port_id = $port->ID;
                    $gallery = rwmb_meta('prod_service_gallery', ['object_type' => 'post'], $port_id);
                    $thumb   = get_the_post_thumbnail_url($port_id, 'costom-gallery')
                               ?: ($gallery ? reset($gallery)['full_url'] : get_template_directory_uri() . '/files/topimg2.png');
                ?>
                    <div class="col-lg-4 col-md-6">
                        <a href="<?php echo esc_url(get_permalink($port_id)); ?>" class="portfolio-card text-decoration-none d-block">
                            <div class="portfolio-card-img">
                                <img src="<?php echo esc_url($thumb); ?>" loading="lazy" alt="<?php echo esc_attr($port->post_title); ?>">
                                <div class="portfolio-card-overlay">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                            <div class="portfolio-card-body">
                                <h5 class="portfolio-card-title"><?php echo esc_html($port->post_title); ?></h5>
                                <?php if ($port->post_excerpt) : ?>
                                    <p class="portfolio-card-desc"><?php echo esc_html($port->post_excerpt); ?></p>
                                <?php endif; ?>
                                <span class="portfolio-card-link">
                                    <?php esc_html_e('Подробнее', 'asiaterm25'); ?> <i class="fas fa-arrow-right ms-1"></i>
                                </span>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (get_the_content()) : ?>
                <div class="project-description mt-5 pt-4 border-top">
                    <?php the_content(); ?>
                </div>
            <?php endif; ?>

        </div>
    </section>

<?php else : ?>

    <?php
    $gallery = rwmb_meta('prod_service_gallery', ['object_type' => 'post'], $current_id);
    $images  = $gallery ? array_values($gallery) : [];
    ?>

    <section id="project-page" class="py-5">
        <div class="container">

            <?php if ($images) : ?>
            <div class="project-gallery mb-5">
                <div class="project-gallery-main mb-3">
                    <img src="<?php echo esc_url($images[0]['full_url']); ?>"
                         id="projectMainImg"
                         alt="<?php the_title_attribute(); ?>">
                </div>

                <?php if (count($images) > 1) : ?>
                <div class="project-gallery-thumbs">
                    <?php foreach ($images as $i => $img) : ?>
                        <div class="project-thumb <?php echo $i === 0 ? 'active' : ''; ?>"
                             data-src="<?php echo esc_url($img['full_url']); ?>">
                            <img src="<?php echo esc_url($img['sizes']['thumbnail'] ?? $img['full_url']); ?>" loading="lazy" alt="">
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if (get_the_content()) : ?>
            <div class="project-description">
                <?php the_content(); ?>
            </div>
            <?php endif; ?>

        </div>
    </section>

<?php endif; ?>

<?php endif; ?>

<?php
include locate_template('page-top/ctasec.php');
get_footer();
?>
