<?php get_header();
include(locate_template('template-parts/menu.php'));
?>

<section class="page-header">
    <div class="container">
        <h1 class="page-header-title">404</h1>
        <p style="color: rgba(255,255,255,0.6); margin-bottom: 0;"><?php esc_html_e('Страница не найдена', 'asiaterm25'); ?></p>
    </div>
</section>

<section class="py-5">
    <div class="container text-center">
        <div style="max-width: 500px; margin: 0 auto;">
            <i class="fas fa-map-signs fa-4x mb-4" style="color: var(--color-primary); opacity: 0.5;"></i>
            <h2 class="mb-3"><?php esc_html_e('Страница не найдена', 'asiaterm25'); ?></h2>
            <p class="text-muted mb-4"><?php esc_html_e('Запрашиваемая страница не существует или была перемещена. Воспользуйтесь поиском или вернитесь на главную.', 'asiaterm25'); ?></p>

            <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="mb-4">
                <div class="input-group" style="max-width: 400px; margin: 0 auto;">
                    <input type="text" name="s" class="form-control" placeholder="<?php esc_attr_e('Поиск по сайту...', 'asiaterm25'); ?>">
                    <button class="btn" type="submit" style="background: var(--color-primary); color: #fff;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn company-btn-primary">
                <i class="fas fa-home me-2"></i><?php esc_html_e('На главную', 'asiaterm25'); ?>
            </a>
        </div>
    </div>
</section>

<?php
include(locate_template('page-top/ctasec.php'));
get_footer();
