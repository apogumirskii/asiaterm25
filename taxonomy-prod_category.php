<?php get_header();
include(locate_template('template-parts/menu.php'));
 ?>
<section id="category" class="py-5 pt-5 mt-5">
    <div class="container">
        <h2 class="section-title"><?php echo esc_html(single_term_title('', false)); ?></h2>
 
        <div class="row g-4">
            <?php
            $current_category = get_queried_object();
            $args = array(
                'post_type'      => 'page',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'prod_category',
                        'field'    => 'slug',
                        'terms'    => $current_category->slug
                    )
                )
            );
            $child_pages = get_posts($args);
            
            if ($child_pages) :
                foreach ($child_pages as $child) :
                    $thumbnail = get_the_post_thumbnail_url($child->ID, 'medium') ?: get_template_directory_uri() . '/img/placeholder.jpg';
                    $icon = get_post_meta($child->ID, 'prod_icon', true) ?: '<i class="fas fa-star"></i>';
                    $terms = wp_get_post_terms($child->ID, 'prod_category', array('fields' => 'slugs'));
                    $term_classes = $terms ? implode(' ', array_map('esc_attr', $terms)) : '';
            ?>
            <div class="col-md-6 col-lg-4 product-item <?php echo $term_classes; ?>">
                <div class="card h-100">
                    <img src="<?php echo esc_url($thumbnail); ?>" class="card-img-top product-card-img" alt="<?php echo esc_attr(get_the_title($child->ID)); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo esc_html(get_the_title($child->ID)); ?></h5>
                        <p class="card-text"><?php 
                            $content = get_post_field('post_content', $child->ID);
                            echo esc_html(strtok($content, '.') . '.'); 
                        ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-primary"><?php echo $icon; ?></span>
                            <a href="<?php echo esc_url(get_permalink($child->ID)); ?>" class="btn btn-outline-primary btn-sm"><?php _e('Подробнее', 'casiatrade25'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                endforeach;
            else :
                echo '<div class="text-center"><p class="text-muted">' . esc_html__('В этой категории пока нет товаров', 'asiaterm25') . '</p></div>';
            endif;
            ?>
        </div>
    </div>
 
</section>
<?php include(locate_template('page-top/ctasec.php'));

get_footer(); ?>