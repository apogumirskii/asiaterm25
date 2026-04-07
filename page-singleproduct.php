<?php /* Template Name: Single product */ get_header();
include(locate_template('template-parts/menu.php'));
include(locate_template('template-parts/phead.php'));
?>

<section id="product" class="py-2">
    <div class="container">
        <?php while (have_posts()) : the_post();
            $gallery        = rwmb_meta('prod_service_gallery', ['object_type' => 'post'], get_the_ID());
            $shortdesc      = rwmb_meta('prod_shortdesc');
            $specs          = rwmb_meta('prod_specs');
            $complect       = rwmb_meta('prod_complect');
            $costomdescr_title = rwmb_meta('prod_costomdescr_title');
            $costomdescr    = rwmb_meta('prod_costomdescr');
            $downloads      = rwmb_meta('prod_downloads', ['object_type' => 'post'], get_the_ID());
			$var_titles 	= rwmb_meta('prod_var_titles');
            $related        = rwmb_meta('prod_related_pages', ['object_type' => 'post'], get_the_ID());
            $portfolio      = rwmb_meta('prod_portfolio_pages', ['object_type' => 'post'], get_the_ID());
        ?>

        <div class="row g-4 mb-5">
            <div class="col-lg-6">
                <?php include(locate_template('template-parts/product-gallery.php')); ?>
            </div>
            <?php include(locate_template('template-parts/product-header.php')); ?>
        </div>

        <?php
        $tabs = [];
        if ($shortdesc)    $tabs['desc'] = __('Описание', 'asiaterm25');
        if ($specs)        $tabs['specs']    = __('Технические параметры', 'asiaterm25');
        if ($costomdescr)  $tabs['custom']   = $costomdescr_title ?: __('Дополнительно', 'asiaterm25');
        if ($complect)     $tabs['complect'] = __('Комплектация', 'asiaterm25');
        if ($downloads)    $tabs['download'] = __('Скачать', 'asiaterm25');
        if ($related)      $tabs['related']  = __('Смежные товары', 'asiaterm25');
        if ($portfolio)    $tabs['portfolio']= __('Проекты', 'asiaterm25');
        ?>

        <?php if ($tabs) : ?>
			<div class="product-tabs mb-5">
				<div class="row g-0">
					<div class="col-md-3">
						<ul class="nav flex-column nav-tabs-vertical" id="productTabs">
							<?php $first = true; foreach ($tabs as $key => $label) : ?>
								<li class="nav-item">
									<a class="nav-link <?php echo $first ? 'active' : ''; ?>"
									   data-bs-toggle="tab"
									   href="#tab-<?php echo esc_attr($key); ?>">
										<?php echo esc_html($label); ?>
										<i class="fas fa-chevron-right ms-auto"></i>
									</a>
								</li>
							<?php $first = false; endforeach; ?>
						</ul>
					</div>
					<div class="col-md-9">
						<div class="tab-content p-4 border border-start-0">

               <?php if (isset($tabs['desc'])) : ?>
					<div class="tab-pane fade show active" id="tab-desc">
						<?php echo apply_filters('the_content', get_the_content()); ?>
					</div>
				<?php endif; ?>

                <?php if (isset($tabs['specs'])) : ?>
                <div class="tab-pane fade" id="tab-specs">
                    <?php echo do_shortcode(wp_kses_post($specs)); ?>
                </div>
                <?php endif; ?>

                <?php if (isset($tabs['custom'])) : ?>
                <div class="tab-pane fade" id="tab-custom">
                    <?php echo do_shortcode(wp_kses_post($costomdescr)); ?>
                </div>
                <?php endif; ?>

                <?php if (isset($tabs['complect'])) : ?>
                <div class="tab-pane fade" id="tab-complect">
                    <?php echo do_shortcode(wp_kses_post($complect)); ?>
                </div>
                <?php endif; ?>

                <?php if (isset($tabs['download'])) : ?>
                <div class="tab-pane fade" id="tab-download">
                    <ul class="list-unstyled download-list">
                        <?php foreach ($downloads as $file) : ?>
                            <li class="d-flex align-items-center gap-3 py-2 border-bottom">
                                <i class="fas fa-file-pdf fa-lg text-danger"></i>
                                <a href="<?php echo esc_url($file['url']); ?>" target="_blank" class="flex-grow-1">
                                    <?php echo esc_html($file['title'] ?: $file['name']); ?>
                                </a>
                                <span class="text-muted small"><?php echo esc_html(strtoupper($file['extension'] ?? '')); ?></span>
                                <a href="<?php echo esc_url($file['url']); ?>" download class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-download"></i>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <?php if (isset($tabs['related'])) : ?>
                <div class="tab-pane fade" id="tab-related">
                    <div class="row g-3">
                        <?php foreach ($related as $rel_page) :
                            $rel_id = is_object($rel_page) ? $rel_page->ID : $rel_page;
                        ?>
                            <div class="col-6 col-md-3">
                                <a href="<?php echo esc_url(get_permalink($rel_id)); ?>" class="card h-100 text-decoration-none">
                                    <?php if (has_post_thumbnail($rel_id)) : ?>
                                        <img src="<?php echo esc_url(get_the_post_thumbnail_url($rel_id, 'catalog-thumb')); ?>"
                                             class="card-img-top" loading="lazy" alt="">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <p class="card-text small fw-bold"><?php echo esc_html(get_the_title($rel_id)); ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (isset($tabs['portfolio'])) : ?>
                <div class="tab-pane fade" id="tab-portfolio">
                    <div class="row g-3">
                        <?php foreach ($portfolio as $port_page) :
                            $port_id = is_object($port_page) ? $port_page->ID : $port_page;
                        ?>
                            <div class="col-6 col-md-3">
                                <a href="<?php echo esc_url(get_permalink($port_id)); ?>" class="card h-100 text-decoration-none">
                                    <?php if (has_post_thumbnail($port_id)) : ?>
                                        <img src="<?php echo esc_url(get_the_post_thumbnail_url($port_id, 'catalog-thumb')); ?>"
                                             class="card-img-top" loading="lazy" alt="">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <p class="card-text small fw-bold"><?php echo esc_html(get_the_title($port_id)); ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
        <?php endif; ?>

        <?php endwhile; ?>
    </div>
    </div>
</section>

<?php
include(locate_template('page-top/ctasec.php'));
get_footer(); ?>
