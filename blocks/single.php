<div class="col-md-6 col-lg-4">
    <div class="card h-100">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
			
                <span class="badge bg-primary me-2">
    <?php
    $categories = get_the_category();
    if ($categories) {
        // Берем ПОСЛЕДНЮЮ категорию (самую глубокую)
        $last_category = end($categories);
        echo esc_html($last_category->name);
    } else {
        esc_html_e('Новости', 'asiaterm25');
    }
    ?>
</span>

                <small class="text-muted">
                    <?php echo get_the_date('d F Y'); ?>
                </small>
            </div>
            
            <h5 class="card-title">
                <?php the_title(); ?>
            </h5>
            
            <p class="card-text">
                <?php 
                $excerpt = get_the_excerpt();
                echo wp_trim_words($excerpt, 20, '...'); 
                ?>
            </p>
            
				<a href="<?php the_permalink(); ?>" class="text-decoration-none">
					<?php esc_html_e('Подробнее', 'asiaterm25'); ?>
					<i class="fas fa-arrow-right ms-1"></i>
				</a> 
        </div>
    </div>
</div> 