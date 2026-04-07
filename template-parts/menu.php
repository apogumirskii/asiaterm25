<?php
$page13 = get_post(13);
$page13_title = $page13 ? $page13->post_title : 'Каталог';
$page13_url   = $page13 ? get_permalink(13) : '#';
$cat_pages = get_pages([
    'parent'      => 13,
    'post_status' => 'publish',
    'sort_column' => 'menu_order',
]);
$wa_number = get_option('my_whatsapp') ?: get_option('my_phone');
?>
<header class="site-header">

    <!-- Верхняя строка -->
    <div class="header-top">
        <div class="container">
            <div class="d-flex align-items-center gap-3">

                <!-- Лого -->
                <a href="<?php echo esc_url(home_url('/')); ?>" class="header-logo me-4">
                    <img src="<?php echo get_template_directory_uri(); ?>/files/logotest.svg" alt="<?php bloginfo('name'); ?>" height="60">
                </a>

                <!-- Поиск -->
                <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="header-search flex-grow-1">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="s" class="form-control border-start-0"
                               placeholder="Поиск товаров..."
                               value="<?php echo get_search_query(); ?>">
                    </div>
                </form>

                <!-- Правые кнопки -->
                <div class="d-flex align-items-center gap-3 ms-3">
					 <a href="https://wa.me/<?php echo preg_replace('/\D/', '', $wa_number); ?>"
					   target="_blank" class="header-top-btn header-top-btn--whatsapp">
						<i class="fab fa-whatsapp"></i> WhatsApp
					</a>
                    <a href="tel:<?php echo esc_attr(get_option('my_phone')); ?>" class="header-top-btn header-top-btn--phone">
                        <i class="fas fa-phone-alt"></i>
                        <?php echo esc_html(get_option('my_phone')); ?>
                    </a>
                </div>

            </div>
        </div>
    </div>

<div class="header-nav-bar">
    <div class="container">
        <div class="d-flex align-items-center">

            <div class="catalog-dropdown">
				<a href="<?php echo esc_url($page13_url); ?>" class="catalog-btn">
					<i class="fas fa-bars me-2"></i> <?php echo esc_html($page13_title); ?>
				</a>
                <ul class="catalog-dropdown-menu">
                    <?php foreach ($cat_pages as $cat) : ?>
                        <li>
                            <a href="<?php echo esc_url(get_permalink($cat->ID)); ?>">
                                <?php if (has_post_thumbnail($cat->ID)) : ?>
                                    <img src="<?php echo esc_url(get_the_post_thumbnail_url($cat->ID, 'thumbnail')); ?>" loading="lazy" alt="">
                                <?php endif; ?>
                                <?php echo esc_html($cat->post_title); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="d-none d-lg-block flex-grow-1">
                <?php
                wp_nav_menu([
                    'theme_location' => 'topmenu',
                    'container'      => false,
                    'menu_class'     => 'header-nav-menu',
                    'fallback_cb'    => false,
                    'walker'         => new Bootstrap5_Walker_Nav_Menu(),
                ]);
                ?>
            </div>

            <button class="navbar-toggler d-lg-none ms-auto" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                <span class="navbar-toggler-icon-bar"></span>
                <span class="navbar-toggler-icon-bar"></span>
                <span class="navbar-toggler-icon-bar"></span>
            </button>

        </div>
    </div>
</div>


</header>

<!-- Мобильное меню -->
<div class="offcanvas offcanvas-start" id="mobileMenu">
    <div class="offcanvas-header">
        <a href="<?php echo esc_url(home_url('/')); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/files/logotest.svg" height="36" alt="">
        </a>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
			<div class="offcanvas-body">
				<?php
				wp_nav_menu([
					'theme_location' => 'topmenu',
					'container'      => false,
					'menu_class'     => 'mobile-nav',
					'fallback_cb'    => false,
				]);
				?>

				<ul class="mobile-nav mobile-catalog-nav">
					<li class="mobile-catalog-heading">
						<a href="<?php echo esc_url($page13_url); ?>">
							<i class="fas fa-bars me-2"></i><?php echo esc_html($page13_title); ?>
						</a>
					</li>
					<?php foreach ($cat_pages as $cat) : ?>
						<li>
							<a href="<?php echo esc_url(get_permalink($cat->ID)); ?>">
								<?php if (has_post_thumbnail($cat->ID)) : ?>
									<img src="<?php echo esc_url(get_the_post_thumbnail_url($cat->ID, 'thumbnail')); ?>" alt="">
								<?php endif; ?>
								<?php echo esc_html($cat->post_title); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
</div>
