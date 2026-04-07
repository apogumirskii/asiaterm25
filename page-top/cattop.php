<section class="categories-section py-5">
    <div class="container">

        <div class="text-center mb-5">
            <h6 class="section-subheading">Что мы предлагаем</h6>
            <h2 class="section-heading">Категории товаров</h2>
        </div>

        <div class="row g-4">
            <?php
            $categories = get_pages([
                'parent'      => 13,
                'post_status' => 'publish',
                'sort_column' => 'menu_order',
            ]);

            foreach ($categories as $cat) :
                $thumb = get_the_post_thumbnail_url($cat->ID, 'catalog-thumb');
                $excerpt = $cat->post_excerpt ?: wp_trim_words($cat->post_content, 20);
           
		   include(locate_template('blocks/category.php')); 
		   
		   endforeach; ?>
        </div>

    </div>
</section>

