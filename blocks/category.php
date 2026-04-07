                <div class="col-xl-4 col-md-6">
                    <div class="category-card text-center">
                        <a href="<?php echo esc_url(get_permalink($cat->ID)); ?>" class="category-img-wrap d-block mb-4">
                            <?php if ($thumb) : ?>
                                <img src="<?php echo esc_url($thumb); ?>" loading="lazy" alt="<?php echo esc_attr($cat->post_title); ?>">
                            <?php else : ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/img/placeholder.jpg" alt="">
                            <?php endif; ?>
                        </a>
                        <a href="<?php echo esc_url(get_permalink($cat->ID)); ?>" class="category-title">
                            <?php echo esc_html($cat->post_title); ?>
                        </a>
                        <?php if ($excerpt) : ?>
                            <p class="category-desc"><?php echo esc_html($excerpt); ?></p>
                        <?php endif; ?>
                    </div>
                </div>