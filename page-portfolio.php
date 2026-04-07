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

            <div class="text-center mb-5">
                <h6 class="section-subheading">Наши работы</h6>
                <h1 class="section-heading"><?php the_title(); ?></h1>
                <?php if (get_the_excerpt()) : ?>
                    <p class="text-muted mt-2 mx-auto" style="max-width: 40rem;"><?php the_excerpt(); ?></p>
                <?php endif; ?>
            </div>

            <div class="row g-4">
                <?php foreach ($children as $port) :
                    $port_id = $port->ID;
                    $gallery = rwmb_meta('prod_service_gallery', ['object_type' => 'post'], $port_id);
                    $thumb   = get_the_post_thumbnail_url($port_id, 'large')
                               ?: ($gallery ? reset($gallery)['full_url'] : get_template_directory_uri() . '/img/placeholder.jpg');
                ?>
                    <div class="col-lg-4 col-md-6">
                        <a href="<?php echo esc_url(get_permalink($port_id)); ?>" class="portfolio-card text-decoration-none d-block">
                            <div class="portfolio-card-img">
                                <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($port->post_title); ?>">
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
                                    Подробнее <i class="fas fa-arrow-right ms-1"></i>
                                </span>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (get_the_content()) : ?>
                <div class="portfolio-page-desc mt-5 pt-4 border-top">
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

            <div class="mb-4">
                <h1 class="section-heading"><?php the_title(); ?></h1>
            </div>

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
                            <img src="<?php echo esc_url($img['sizes']['thumbnail'] ?? $img['full_url']); ?>" alt="">
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

    <script>
    jQuery(document).ready(function($) {
        $(document).on('click', '.project-thumb', function() {
            var src = $(this).data('src');
            $('#projectMainImg').attr('src', src);
            $('.project-thumb').removeClass('active');
            $(this).addClass('active');
        });
    });
    </script>

<?php endif; ?>

<?php endif; ?>

<style>
.portfolio-card {
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: transform 0.3s, box-shadow 0.3s;
    background: var(--color-white);
    color: inherit;
}

.portfolio-card:hover {
    transform: translateY(-6px);
    box-shadow: var(--shadow-lg);
}

.portfolio-card-img {
    position: relative;
    overflow: hidden;
    height: 16rem;
}

.portfolio-card-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s;
    display: block;
}

.portfolio-card:hover .portfolio-card-img img {
    transform: scale(1.06);
}

.portfolio-card-overlay {
    position: absolute;
    inset: 0;
    background: rgba(232, 98, 26, 0);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.3s;
}

.portfolio-card-overlay i {
    color: var(--color-white);
    font-size: 2rem;
    opacity: 0;
    transform: scale(0.7);
    transition: all 0.3s;
}

.portfolio-card:hover .portfolio-card-overlay {
    background: rgba(232, 98, 26, 0.5);
}

.portfolio-card:hover .portfolio-card-overlay i {
    opacity: 1;
    transform: scale(1);
}

.portfolio-card-body {
    padding: 1.25rem 1.5rem 1.5rem;
}

.portfolio-card-title {
    font-size: var(--font-size-lg);
    font-weight: 700;
    color: var(--color-black);
    margin-bottom: 0.5rem;
}

.portfolio-card-desc {
    font-size: var(--font-size-sm);
    color: var(--color-text-muted);
    line-height: 1.6;
    margin-bottom: 0.75rem;
}

.portfolio-card-link {
    color: var(--color-primary);
    font-size: var(--font-size-sm);
    font-weight: 600;
    text-decoration: none;
    transition: color var(--transition);
}

.portfolio-card:hover .portfolio-card-link {
    color: var(--color-primary-dark);
}

/* Single project */
.project-gallery-main {
    border-radius: var(--radius-lg);
    overflow: hidden;
    height: 36rem;
}

.project-gallery-main img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: opacity 0.3s;
}

.project-gallery-thumbs {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.project-thumb {
    width: 7rem;
    height: 5rem;
    border-radius: var(--radius-sm);
    overflow: hidden;
    cursor: pointer;
    border: 2px solid transparent;
    transition: border-color var(--transition);
    flex-shrink: 0;
}

.project-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.project-thumb.active,
.project-thumb:hover {
    border-color: var(--color-primary);
}

.project-description {
    font-size: var(--font-size-md);
    color: var(--color-text);
    line-height: 1.8;
    max-width: 50rem;
}

.project-description h2,
.project-description h3 {
    font-weight: 700;
    color: var(--color-black);
    margin: 2rem 0 1rem;
}
</style>

<?php
include locate_template('page-top/ctasec.php');
get_footer();
?>