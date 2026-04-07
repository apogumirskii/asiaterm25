<?php /* Template Name: Услуги */ get_header();
include(locate_template('template-parts/menu.php'));
include(locate_template('template-parts/phead.php'));

$services = rwmb_meta('services_list');
?>

<section class="py-5">
    <div class="container">
        <h2 class="section-title"><?php the_title(); ?></h2>

        <?php if ($services) : ?>
        <div class="row g-4">
            <?php foreach ($services as $service) :
                $icon  = $service['service_icon'] ?? 'fas fa-cog';
                $title = $service['service_title'] ?? '';
                $desc  = $service['service_desc'] ?? '';
                $link  = $service['service_link'] ?? '';
                $images = $service['service_image'] ?? [];
            ?>
            <div class="col-lg-6 col-md-6">
                <div class="card h-100">
                    <?php if ($images) :
                        $img_id = is_array($images) ? reset($images) : $images;
                        $img_url = wp_get_attachment_image_url($img_id, 'catalog-thumb');
                        if ($img_url) : ?>
                        <img src="<?php echo esc_url($img_url); ?>"
                             class="card-img-top"
                             loading="lazy"
                             alt="<?php echo esc_attr($title); ?>">
                        <?php endif;
                    endif; ?>
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3">
                            <i class="<?php echo esc_attr($icon); ?> fa-2x"></i>
                        </div>
                        <h5 class="card-title"><?php echo esc_html($title); ?></h5>
                        <?php if ($desc) : ?>
                            <div class="card-text"><?php echo wp_kses_post($desc); ?></div>
                        <?php endif; ?>
                        <?php if ($link) : ?>
                            <a href="<?php echo esc_url($link); ?>" class="btn btn-outline-primary mt-3">
                                <?php esc_html_e('Подробнее', 'asiaterm25'); ?> <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else : ?>
            <div class="text-center">
                <?php the_content(); ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
include(locate_template('page-top/ctasec.php'));
get_footer();
