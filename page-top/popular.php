<section class="products-section py-5">
    <div class="container">

        <div class="text-center mb-5">
            <h6 class="section-subheading">Каталог</h6>
            <h2 class="section-heading">Популярные товары</h2>
        </div>

        <?php
		$featured_pages = new WP_Query([
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'meta_query'     => [
				[
					'key'     => 'prod_show_on_home',
					'value'   => '1',
					'compare' => '=',
				],
			],
		]);
        ?>

        <div class="position-relative">
            <div class="owl-carousel owl-products">

                <?php if ($featured_pages->have_posts()) : ?>
					<?php while ($featured_pages->have_posts()) : $featured_pages->the_post();
						$id         = get_the_ID();
						$thumb      = get_the_post_thumbnail_url($id, 'medium_large');
						$excerpt = wp_trim_words(get_the_excerpt() ?: get_the_content(), 30);
						$price      = rwmb_meta('prod_price', [], $id);
						$var_titles = rwmb_meta('prod_var_titles', [], $id);
					 
					
					include(locate_template('blocks/product.php'));   
					
					endwhile; wp_reset_postdata(); ?>

                <?php else : ?>
  
                <?php endif; ?>

            </div>

            <button class="products-nav products-prev"><i class="fas fa-chevron-left"></i></button>
            <button class="products-nav products-next"><i class="fas fa-chevron-right"></i></button>
        </div>

    </div>
</section>

 