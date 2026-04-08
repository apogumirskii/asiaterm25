<section class="stats-section py-5">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="stats-heading">Наши завершенные проекты</h2>
            <p class="stats-desc">Мы занимаемся организацией отопления в объектах любого размера,<br>жилых домах, офисных зданиях, производствах и ресторанах</p>
        </div>

        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="stat-num"><span class="countup" data-target="580">0</span>+</div>
                <div class="stat-label">Завершенных проектов</div>
            </div>
            <div class="col-md-4">
                <div class="stat-num"><span class="countup" data-target="99">0</span>%</div>
                <div class="stat-label">Эффективность отопления</div>
            </div>
            <div class="col-md-4">
                <div class="stat-num"><span class="countup" data-target="112">0</span>+</div>
                <div class="stat-label">Типов оборудования</div>
            </div>
        </div>

    </div>
</section>

<script>
jQuery(document).ready(function($) {
    function animateCountup() {
        $('.countup').each(function() {
            var $this   = $(this);
            var target  = parseInt($this.data('target'));
            var current = 0;
            var step = Math.ceil(target / (2000 / 16));
            var timer = setInterval(function() {
                current += step;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                $this.text(current);
            }, 16);
        });
    }
    var animated = false;
    $(window).on('scroll', function() {
        if (animated) return;
        var sectionTop = $('.stats-section').offset().top;
        if ($(window).scrollTop() + $(window).height() > sectionTop + 100) {
            animated = true;
            animateCountup();
        }
    });
});
</script>

<?php
$portfolio_query = new WP_Query([
    'post_type'      => 'portfolio',
    'posts_per_page' => 12,
    'orderby'        => 'date',
    'order'          => 'DESC',
]);

if ($portfolio_query->have_posts()) :
    $portfolio_items = [];
    while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
        $pid = get_the_ID();
        $gallery = rwmb_meta('portfolio_gallery', ['object_type' => 'post'], $pid);
        $thumb = get_the_post_thumbnail_url($pid, 'costom-gallery')
                 ?: ($gallery ? reset($gallery)['full_url'] : get_template_directory_uri() . '/files/topimg2.png');
        $portfolio_items[] = [
            'id'      => $pid,
            'title'   => get_the_title(),
            'url'     => get_permalink(),
            'thumb'   => $thumb,
            'gallery' => $gallery ? array_values($gallery) : [],
        ];
    endwhile;
    wp_reset_postdata();
?>

<section class="portfolio-section py-5">
    <div class="container-fluid px-4">

        <div class="owl-carousel owl-portfolio">
            <?php foreach ($portfolio_items as $port) : ?>
                <div class="portfolio-slide"
                     data-page-id="<?php echo $port['id']; ?>"
                     data-title="<?php echo esc_attr($port['title']); ?>"
                     data-url="<?php echo esc_url($port['url']); ?>">
                    <img src="<?php echo esc_url($port['thumb']); ?>" alt="<?php echo esc_attr($port['title']); ?>">
                    <span class="portfolio-title"><?php echo esc_html($port['title']); ?></span>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<!-- Модальное окно портфолио -->
<div class="modal fade" id="portfolioModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-dark border-0">
            <div class="modal-header border-0">
                <h5 class="modal-title text-white" id="portfolioModalTitle"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="owl-carousel owl-portfolio-modal" id="portfolioModalGallery"></div>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <a href="#" id="portfolioModalLink" class="btn portfolio-detail-btn">
                    Подробнее <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {

    var galleries = {
        <?php foreach ($portfolio_items as $port) :
            if (!$port['gallery']) continue;
        ?>
        <?php echo $port['id']; ?>: [
            <?php foreach ($port['gallery'] as $img) : ?>
            '<?php echo esc_url($img['full_url']); ?>',
            <?php endforeach; ?>
        ],
        <?php endforeach; ?>
    };

    $(".owl-portfolio").owlCarousel({
        loop: true,
        margin: 20,
        nav: false,
        dots: false,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsive: {
            0:    { items: 1 },
            576:  { items: 2 },
            768:  { items: 3 },
            1200: { items: 4 },
        }
    });

    $(document).on('click', '.portfolio-slide', function() {
        var pageId = $(this).data('page-id');
        var title  = $(this).data('title');
        var url    = $(this).data('url');
        var imgs   = galleries[pageId] || [];

        $('#portfolioModalTitle').text(title);
        $('#portfolioModalLink').attr('href', url);

        var $gallery = $('#portfolioModalGallery');
        $gallery.html('');

        if (imgs.length) {
            $.each(imgs, function(i, src) {
                $gallery.append('<div class="portfolio-modal-slide"><img src="' + src + '" alt=""></div>');
            });
        } else {
            $gallery.append('<div class="portfolio-modal-slide"><p class="text-white text-center p-4">Галерея не заполнена</p></div>');
        }

        if ($gallery.hasClass('owl-loaded')) {
            $gallery.trigger('destroy.owl.carousel');
            $gallery.removeClass('owl-carousel owl-loaded');
            $gallery.find('.owl-stage-outer').children().unwrap();
        }

        $gallery.addClass('owl-carousel').owlCarousel({
            items: 1,
            loop: imgs.length > 1,
            nav: true,
            dots: true,
            navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
        });

        $('#portfolioModal').modal('show');
    });

});
</script>

<?php endif; ?>
