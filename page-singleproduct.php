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
                        <?php foreach ($downloads as $file) :
                            $ext = strtolower($file['extension'] ?? pathinfo($file['url'], PATHINFO_EXTENSION));
                            $icon_map = ['pdf' => 'fa-file-pdf text-danger', 'doc' => 'fa-file-word text-primary', 'docx' => 'fa-file-word text-primary', 'xls' => 'fa-file-excel text-success', 'xlsx' => 'fa-file-excel text-success', 'zip' => 'fa-file-archive text-warning', 'rar' => 'fa-file-archive text-warning', 'jpg' => 'fa-file-image text-info', 'jpeg' => 'fa-file-image text-info', 'png' => 'fa-file-image text-info'];
                            $icon_cls = $icon_map[$ext] ?? 'fa-file-alt text-secondary';
                            $fsize = !empty($file['filesize']) ? size_format($file['filesize']) : '';
                        ?>
                            <li class="d-flex align-items-center gap-3 py-2 border-bottom">
                                <i class="fas <?php echo esc_attr($icon_cls); ?> fa-lg"></i>
                                <a href="<?php echo esc_url($file['url']); ?>" target="_blank" rel="noopener" class="flex-grow-1">
                                    <?php echo esc_html($file['title'] ?: $file['name']); ?>
                                </a>
                                <span class="badge bg-light text-dark"><?php echo esc_html(strtoupper($ext)); ?></span>
                                <?php if ($fsize) : ?>
                                    <span class="text-muted small"><?php echo esc_html($fsize); ?></span>
                                <?php endif; ?>
                                <a href="<?php echo esc_url($file['url']); ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary">
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

                <?php if (isset($tabs['portfolio'])) :
                    $port_items = [];
                    foreach ($portfolio as $port_page) {
                        $port_id = is_object($port_page) ? $port_page->ID : $port_page;
                        $port_gallery = rwmb_meta('portfolio_gallery', ['object_type' => 'post'], $port_id);
                        $port_thumb = get_the_post_thumbnail_url($port_id, 'costom-gallery')
                                      ?: ($port_gallery ? reset($port_gallery)['full_url'] : '');
                        $port_items[] = [
                            'id'      => $port_id,
                            'title'   => get_the_title($port_id),
                            'url'     => get_permalink($port_id),
                            'thumb'   => $port_thumb,
                            'gallery' => $port_gallery ? array_values($port_gallery) : [],
                        ];
                    }
                ?>
                <div class="tab-pane fade" id="tab-portfolio">
                    <div class="row g-4">
                        <?php foreach ($port_items as $port) : ?>
                            <div class="col-md-6">
                                <div class="portfolio-card d-block portfolio-slide-product"
                                     data-page-id="<?php echo $port['id']; ?>"
                                     data-title="<?php echo esc_attr($port['title']); ?>"
                                     data-url="<?php echo esc_url($port['url']); ?>"
                                     style="cursor:pointer;">
                                    <div class="portfolio-card-img">
                                        <?php if ($port['thumb']) : ?>
                                            <img src="<?php echo esc_url($port['thumb']); ?>" loading="lazy" alt="<?php echo esc_attr($port['title']); ?>">
                                        <?php endif; ?>
                                        <div class="portfolio-card-overlay">
                                            <i class="fas fa-images"></i>
                                        </div>
                                    </div>
                                    <div class="portfolio-card-body">
                                        <h5 class="portfolio-card-title"><?php echo esc_html($port['title']); ?></h5>
                                        <span class="portfolio-card-link">
                                            <?php esc_html_e('Смотреть галерею', 'asiaterm25'); ?> <i class="fas fa-images ms-1"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Модальное окно портфолио (товар) -->
                <div class="modal fade" id="portfolioModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-fullscreen">
                        <div class="modal-content bg-dark border-0">
                            <div class="modal-header border-0 py-2 px-3">
                                <h6 class="modal-title text-white mb-0" id="portfolioModalTitle"></h6>
                                <div class="d-flex align-items-center gap-3 ms-auto">
                                    <a href="#" id="portfolioModalLink" class="btn btn-sm portfolio-detail-btn">
                                        <?php esc_html_e('Подробнее', 'asiaterm25'); ?> <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                            </div>
                            <div class="modal-body p-0 d-flex align-items-center position-relative">
                                <div class="swiper swiper-portfolio-modal w-100" id="portfolioModalGallery">
                                    <div class="swiper-wrapper"></div>
                                    <div class="swiper-pagination"></div>
                                    <button class="swiper-button-prev" type="button"></button>
                                    <button class="swiper-button-next" type="button"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                document.addEventListener('DOMContentLoaded', function () {
                    if (typeof Swiper === 'undefined') return;

                    var productGalleries = {
                        <?php foreach ($port_items as $port) :
                            if (!$port['gallery']) continue;
                        ?>
                        <?php echo $port['id']; ?>: [
                            <?php foreach ($port['gallery'] as $img) : ?>
                            '<?php echo esc_url(asiaterm_webp_url_swap($img['full_url'])); ?>',
                            <?php endforeach; ?>
                        ],
                        <?php endforeach; ?>
                    };

                    var modalEl = document.getElementById('portfolioModal');
                    var galleryEl = document.getElementById('portfolioModalGallery');
                    var wrapperEl = galleryEl ? galleryEl.querySelector('.swiper-wrapper') : null;
                    var modalSwiper = null;

                    document.addEventListener('click', function (e) {
                        var slide = e.target.closest('.portfolio-slide-product');
                        if (!slide) return;
                        var pageId = slide.dataset.pageId;
                        var title  = slide.dataset.title || '';
                        var url    = slide.dataset.url || '#';
                        var imgs   = productGalleries[pageId] || [];

                        var titleEl = document.getElementById('portfolioModalTitle');
                        var linkEl  = document.getElementById('portfolioModalLink');
                        if (titleEl) titleEl.textContent = title;
                        if (linkEl) linkEl.setAttribute('href', url);

                        if (!wrapperEl) return;
                        wrapperEl.innerHTML = '';

                        if (imgs.length) {
                            imgs.forEach(function (src) {
                                var sl = document.createElement('div');
                                sl.className = 'swiper-slide portfolio-modal-slide';
                                sl.innerHTML = '<img src="' + src + '" alt="">';
                                wrapperEl.appendChild(sl);
                            });
                        } else {
                            var empty = document.createElement('div');
                            empty.className = 'swiper-slide portfolio-modal-slide';
                            empty.innerHTML = '<p class="text-white text-center p-4"><?php echo esc_js(__('Галерея не заполнена', 'asiaterm25')); ?></p>';
                            wrapperEl.appendChild(empty);
                        }

                        if (modalSwiper) {
                            modalSwiper.destroy(true, true);
                            modalSwiper = null;
                        }

                        modalSwiper = new Swiper('#portfolioModalGallery', {
                            slidesPerView: 1,
                            loop: imgs.length > 1,
                            navigation: {
                                prevEl: galleryEl.querySelector('.swiper-button-prev'),
                                nextEl: galleryEl.querySelector('.swiper-button-next')
                            },
                            pagination: {
                                el: galleryEl.querySelector('.swiper-pagination'),
                                clickable: true
                            }
                        });

                        if (modalEl && window.bootstrap && window.bootstrap.Modal) {
                            window.bootstrap.Modal.getOrCreateInstance(modalEl).show();
                        }
                    });
                });
                </script>
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
