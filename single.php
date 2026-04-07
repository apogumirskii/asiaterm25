<?php get_header();
include(locate_template('template-parts/menu.php'));
include(locate_template('template-parts/phead.php'));
?>

<section id="single-post" class="py-5">
    <div class="container">
        <?php if (have_posts()) : the_post(); ?>

        <div class="row justify-content-center">
            <div class="col-lg-8">

                <?php if (has_post_thumbnail()) : ?>
                <div class="single-featured-img mb-4">
                    <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'costom-gallery')); ?>"
                         class="img-fluid rounded w-100"
                         alt="<?php the_title_attribute(); ?>">
                </div>
                <?php endif; ?>

                <div class="single-meta d-flex flex-wrap gap-3 mb-4 text-muted">
                    <span><i class="fas fa-calendar-alt me-1"></i><?php echo get_the_date('d F Y'); ?></span>
                    <?php $cats = get_the_category();
                    if ($cats) : ?>
                        <span><i class="fas fa-folder me-1"></i><?php echo esc_html($cats[0]->name); ?></span>
                    <?php endif; ?>
                    <span><i class="fas fa-user me-1"></i><?php the_author(); ?></span>
                </div>

                <h1 class="single-title mb-4"><?php the_title(); ?></h1>

                <div class="single-content">
                    <?php the_content(); ?>
                </div>

                <?php $tags = get_the_tags();
                if ($tags) : ?>
                <div class="single-tags mt-4 pt-3 border-top">
                    <i class="fas fa-tags me-2 text-muted"></i>
                    <?php foreach ($tags as $tag) : ?>
                        <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>"
                           class="badge bg-light text-dark text-decoration-none me-1"><?php echo esc_html($tag->name); ?></a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <nav class="single-nav d-flex justify-content-between mt-5 pt-4 border-top">
                    <?php
                    $prev = get_previous_post();
                    $next = get_next_post();
                    ?>
                    <div>
                        <?php if ($prev) : ?>
                            <a href="<?php echo esc_url(get_permalink($prev)); ?>" class="text-decoration-none">
                                <small class="text-muted d-block"><i class="fas fa-arrow-left me-1"></i><?php esc_html_e('Предыдущая', 'asiaterm25'); ?></small>
                                <?php echo esc_html(wp_trim_words($prev->post_title, 6)); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="text-end">
                        <?php if ($next) : ?>
                            <a href="<?php echo esc_url(get_permalink($next)); ?>" class="text-decoration-none">
                                <small class="text-muted d-block"><?php esc_html_e('Следующая', 'asiaterm25'); ?><i class="fas fa-arrow-right ms-1"></i></small>
                                <?php echo esc_html(wp_trim_words($next->post_title, 6)); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </nav>
            </div>
        </div>

        <?php endif; ?>

        <?php
        $related = new WP_Query([
            'post_type'      => 'post',
            'posts_per_page' => 3,
            'post__not_in'   => [get_the_ID()],
            'category__in'   => $cats ? [$cats[0]->term_id] : [],
            'orderby'        => 'date',
            'order'          => 'DESC',
        ]);

        if ($related->have_posts()) : ?>
        <div class="related-posts mt-5 pt-5 border-top">
            <h3 class="section-title"><?php esc_html_e('Похожие статьи', 'asiaterm25'); ?></h3>
            <div class="row g-4">
                <?php while ($related->have_posts()) : $related->the_post(); ?>
                <div class="col-md-4">
                    <div class="card h-100">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'catalog-thumb')); ?>"
                                 class="card-img-top"
                                 loading="lazy"
                                 alt="<?php the_title_attribute(); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <small class="text-muted"><?php echo get_the_date('d F Y'); ?></small>
                            <h5 class="card-title mt-2"><?php the_title(); ?></h5>
                            <p class="card-text"><?php echo esc_html(wp_trim_words(get_the_content(), 15)); ?></p>
                            <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                                <?php esc_html_e('Подробнее', 'asiaterm25'); ?> <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php
include(locate_template('page-top/ctasec.php'));
get_footer();
