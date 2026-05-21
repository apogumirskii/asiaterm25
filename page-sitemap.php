<?php /* Template Name: Карта сайта */ get_header();
include(locate_template('template-parts/menu.php'));
include(locate_template('template-parts/phead.php'));

// Все страницы кроме каталога (ID 13) и его потомков — каталог отдельным блоком
$current_id = get_the_ID();
$catalog_id = 13;

// Соберём все ID-потомков каталога рекурсивно
$catalog_descendants = get_pages([
    'child_of'    => $catalog_id,
    'post_status' => 'publish',
]);
$catalog_excl = [$catalog_id, $current_id];
foreach ($catalog_descendants as $p) $catalog_excl[] = $p->ID;

// Обычные страницы (без каталога)
$all_pages = get_pages([
    'post_status' => 'publish',
    'sort_column' => 'menu_order, post_title',
    'exclude'     => $catalog_excl,
]);

// Сгруппируем по родителю для дерева
$pages_by_parent = [];
foreach ($all_pages as $p) {
    $pages_by_parent[$p->post_parent][] = $p;
}

// Каталог отдельным деревом
$catalog_page = get_post($catalog_id);
$catalog_by_parent = [];
foreach ($catalog_descendants as $p) {
    $catalog_by_parent[$p->post_parent][] = $p;
}
// Сортируем дочерние по menu_order, потом title
foreach ($catalog_by_parent as $pid => &$kids) {
    usort($kids, function ($a, $b) {
        $ord = $a->menu_order <=> $b->menu_order;
        return $ord !== 0 ? $ord : strcasecmp($a->post_title, $b->post_title);
    });
}
unset($kids);

function asiaterm_sitemap_branch($parent_id, $pages_by_parent, $level = 0) {
    if (empty($pages_by_parent[$parent_id])) return;
    $cls = $level === 0 ? 'sitemap-list sitemap-list--root' : 'sitemap-list';
    echo '<ul class="' . esc_attr($cls) . '">';
    foreach ($pages_by_parent[$parent_id] as $page) {
        echo '<li>';
        echo '<a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html($page->post_title) . '</a>';
        asiaterm_sitemap_branch($page->ID, $pages_by_parent, $level + 1);
        echo '</li>';
    }
    echo '</ul>';
}

// Портфолио (CPT)
$portfolios = new WP_Query([
    'post_type'      => 'portfolio',
    'posts_per_page' => -1,
    'orderby'        => ['menu_order' => 'ASC', 'date' => 'DESC'],
    'no_found_rows'  => true,
]);

// Записи (новости)
$posts_q = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'no_found_rows'  => true,
]);

$xml_url = home_url('/wp-sitemap.xml');
?>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sitemap-intro">
                    <i class="fas fa-sitemap me-2" style="color: var(--color-primary);"></i>
                    <?php esc_html_e('Полная навигация по сайту. Для поисковых систем доступна', 'asiaterm25'); ?>
                    <a href="<?php echo esc_url($xml_url); ?>" target="_blank" rel="noopener">
                        XML-карта сайта <i class="fas fa-external-link-alt ms-1"></i>
                    </a>.
                </div>
            </div>
        </div>

        <div class="row g-4">

            <!-- Страницы -->
            <div class="col-lg-6">
                <div class="sitemap-card">
                    <h3 class="sitemap-card-title">
                        <i class="fas fa-file-alt me-2"></i><?php esc_html_e('Страницы', 'asiaterm25'); ?>
                    </h3>
                    <?php asiaterm_sitemap_branch(0, $pages_by_parent); ?>
                </div>
            </div>

            <!-- Каталог -->
            <?php if ($catalog_page) : ?>
            <div class="col-lg-6">
                <div class="sitemap-card">
                    <h3 class="sitemap-card-title">
                        <i class="fas fa-th-large me-2"></i><?php echo esc_html($catalog_page->post_title); ?>
                    </h3>
                    <ul class="sitemap-list sitemap-list--root">
                        <li>
                            <a href="<?php echo esc_url(get_permalink($catalog_page->ID)); ?>"><?php esc_html_e('Все категории', 'asiaterm25'); ?></a>
                            <?php asiaterm_sitemap_branch($catalog_id, $catalog_by_parent, 1); ?>
                        </li>
                    </ul>
                </div>
            </div>
            <?php endif; ?>

            <!-- Проекты -->
            <?php if ($portfolios->have_posts()) : ?>
            <div class="col-lg-6">
                <div class="sitemap-card">
                    <h3 class="sitemap-card-title">
                        <i class="fas fa-images me-2"></i><?php esc_html_e('Проекты', 'asiaterm25'); ?>
                    </h3>
                    <ul class="sitemap-list sitemap-list--root">
                        <?php while ($portfolios->have_posts()) : $portfolios->the_post(); ?>
                            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>

            <!-- Новости -->
            <?php if ($posts_q->have_posts()) : ?>
            <div class="col-lg-6">
                <div class="sitemap-card">
                    <h3 class="sitemap-card-title">
                        <i class="fas fa-newspaper me-2"></i><?php esc_html_e('Новости', 'asiaterm25'); ?>
                    </h3>
                    <ul class="sitemap-list sitemap-list--root">
                        <?php while ($posts_q->have_posts()) : $posts_q->the_post(); ?>
                            <li>
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                <span class="sitemap-date">— <?php echo esc_html(get_the_date()); ?></span>
                            </li>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>

            <!-- XML карта сайта -->
            <div class="col-lg-6">
                <div class="sitemap-card sitemap-card--xml">
                    <h3 class="sitemap-card-title">
                        <i class="fas fa-code me-2"></i><?php esc_html_e('Карта сайта для поисковиков', 'asiaterm25'); ?>
                    </h3>
                    <p class="mb-3"><?php esc_html_e('XML-карта сайта используется поисковыми системами Google, Яндекс и другими для индексирования.', 'asiaterm25'); ?></p>
                    <a href="<?php echo esc_url($xml_url); ?>" target="_blank" rel="noopener" class="btn product-card-btn">
                        <?php esc_html_e('Открыть XML карту сайта', 'asiaterm25'); ?>
                        <i class="fas fa-external-link-alt ms-2"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<?php
include(locate_template('page-top/ctasec.php'));
get_footer();
