<?php get_header(); /* Template Name: Category */
include(locate_template('template-parts/menu.php'));
include(locate_template('template-parts/phead.php'));
?>

<section id="category-page" class="py-5">
    <div class="container">

        <?php if (have_posts()) : the_post();
            $current_id = get_the_ID();
            $thumb      = get_the_post_thumbnail_url($current_id, 'catalog-thumb');
            $icon       = rwmb_meta('prod_icon', [], $current_id);
            $var_titles = rwmb_meta('prod_var_titles', [], $current_id);
        ?>

 
        <div class="row g-4 align-items-center mb-5">

 
            <div class="col-lg-4">
			
				<h1 class="cat-hero-title mb-4"><?php the_title(); ?></h1>
                <?php if ($thumb) : ?>
                    <div class="cat-hero-img mb-4">
                        <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>">
                    </div>
                <?php endif; ?>
               
                <?php if (get_the_excerpt()) : ?>
                    <p class="cat-hero-desc"><?php the_excerpt(); ?></p>
                <?php endif; ?>
            </div>
 
            <div class="col-lg-8">
                <?php
                $products = new WP_Query([
                    'post_type'      => 'page',
                    'post_status'    => 'publish',
                    'posts_per_page' => -1,
                    'post_parent'    => $current_id,
                    'orderby'        => 'menu_order',
                    'order'          => 'ASC',
                ]);
                ?>
                <?php if ($products->have_posts()) : ?>
                    <div class="owl-carousel owl-category-products">
                        <?php while ($products->have_posts()) : $products->the_post();
                            $id         = get_the_ID();
                            $thumb      = get_the_post_thumbnail_url($id, 'catalog-thumb');
                            $excerpt    = wp_trim_words(get_the_excerpt() ?: get_the_content(), 20);
                            $price      = rwmb_meta('prod_price', [], $id);
                            $var_titles = rwmb_meta('prod_var_titles', [], $id);
                        ?>
                            <?php include locate_template('blocks/product.php'); ?>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                <?php else : ?>
                    <p class="text-muted">Товары не найдены.</p>
                <?php endif; ?>
            </div>

        </div>
 
 

        <?php endif; ?>

    </div>
</section>

<script>
jQuery(document).ready(function($) {
    $('.owl-category-products').owlCarousel({
        loop: false,
        margin: 24,
        nav: true,
        dots: false,
        navText: [
            "<i class='fas fa-chevron-left'></i>",
            "<i class='fas fa-chevron-right'></i>"
        ],
        responsive: {
            0:   { items: 1 },
            576: { items: 2 },
            992: { items: 2 },
        }
    });
});
</script>

<?php
include locate_template('page-top/ctasec.php');
get_footer();
?>