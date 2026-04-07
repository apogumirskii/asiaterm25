<?php get_header(); ?>
<?php include(locate_template('template-parts/menu.php')); ?>

<section id="news" class="py-5 pt-5 mt-5 bg-light">
    <div class="container">
        <h2 class="section-title"><?php echo esc_html(is_category() ? single_cat_title('', false) : __('Новости', 'asiaterm25')); ?></h2>
        <div class="row g-4">
            <?php
            $paged = get_query_var('paged') ? get_query_var('paged') : 1;
            $args = array(
                'post_type'      => 'post',
                'posts_per_page' => 6,
                'orderby'        => 'date',
                'order'          => 'DESC',
                'post_status'    => 'publish',
                'paged'          => $paged
            );
            $query = new WP_Query($args);

            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post(); ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100">
                            <?php if (has_post_thumbnail()) : ?>
                                <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>" class="card-img-top" alt="<?php the_title_attribute(); ?>">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php the_title(); ?></h5>
                                <p class="card-text"><?php echo esc_html(wp_trim_words(get_the_content(), 20)); ?></p>
                                <a href="<?php the_permalink(); ?>" class="btn btn-outline-primary btn-sm"><?php esc_html_e('Подробнее', 'asiaterm25'); ?></a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                <div class="pagination mt-5 d-flex justify-content-center">
                    <?php
                    echo paginate_links(array(
                        'total'   => $query->max_num_pages,
                        'current' => $paged,
                        'prev_text' => __('&laquo; Назад'),
                        'next_text' => __('Вперед &raquo;'),
                        'type'    => 'list',
                    ));
                    wp_reset_postdata();
                    ?>
                </div>
            <?php else : ?>
                <div class="text-center"><p class="text-muted"><?php esc_html_e('Новостей не найдено', 'asiaterm25'); ?></p></div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>