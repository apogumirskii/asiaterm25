<section class="categories-section py-5">
    <div class="container">

        <?php asiaterm_section_heading( 'Что мы предлагаем', 'Категории товаров' ); ?>

        <div class="row g-4">
            <?php
            $categories = asiaterm_catalog_children();
            asiaterm_prime_thumbnails( $categories );

            foreach ($categories as $cat) :
                $thumb = get_the_post_thumbnail_url($cat->ID, 'catalog-thumb');
                $excerpt = $cat->post_excerpt ?: wp_trim_words($cat->post_content, 20);
           
		   include(locate_template('blocks/category.php')); 
		   
		   endforeach; ?>
        </div>

    </div>
</section>

