<?php get_header(); /* Template Name: Проекты */
include(locate_template('template-parts/menu.php'));
include(locate_template('template-parts/phead.php'));

// Кэшированный listing портфолио (TTL 12 часов, инвалидация при save_post_portfolio)
$portfolio_data = asiaterm_portfolio_listing();
$items    = $portfolio_data['items'];
$all_cats = $portfolio_data['all_cats'];

if ($items) :
?>

<section id="portfolio-page" class="py-5">
    <div class="container">

        <?php if ($all_cats) : ?>
        <div class="portfolio-filters text-center mb-5">
            <button class="portfolio-filter-btn active" data-filter="*"><?php esc_html_e('Все', 'asiaterm25'); ?></button>
            <?php foreach ($all_cats as $slug => $name) : ?>
                <button class="portfolio-filter-btn" data-filter="<?php echo esc_attr($slug); ?>"><?php echo esc_html($name); ?></button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="row g-4" id="portfolioGrid">
            <?php foreach ($items as $port) : ?>
                <div class="col-lg-4 col-md-6 portfolio-item" data-cats="<?php echo esc_attr($port['cats']); ?>">
                    <a href="<?php echo esc_url($port['url']); ?>" class="portfolio-card text-decoration-none d-block">
                        <div class="portfolio-card-img">
                            <img src="<?php echo esc_url($port['thumb']); ?>" loading="lazy" alt="<?php echo esc_attr($port['title']); ?>">
                            <div class="portfolio-card-overlay">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                        <div class="portfolio-card-body">
                            <h5 class="portfolio-card-title"><?php echo esc_html($port['title']); ?></h5>
                            <?php if ($port['excerpt']) : ?>
                                <p class="portfolio-card-desc"><?php echo esc_html($port['excerpt']); ?></p>
                            <?php endif; ?>
                            <span class="portfolio-card-link">
                                <?php esc_html_e('Подробнее', 'asiaterm25'); ?> <i class="fas fa-arrow-right ms-1"></i>
                            </span>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<?php else : ?>

<section class="py-5">
    <div class="container text-center">
        <i class="fas fa-images fa-3x mb-3" style="color: var(--color-primary); opacity: 0.3;"></i>
        <p class="text-muted"><?php esc_html_e('Проекты появятся здесь после добавления записей в раздел «Портфолио».', 'asiaterm25'); ?></p>
    </div>
</section>

<?php endif; ?>

<?php
include(locate_template('page-top/ctasec.php'));
get_footer();
