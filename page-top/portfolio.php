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
            var duration = 2000;
            var step = Math.ceil(target / (duration / 16));

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

    // Запускаем когда блок попадает в зону видимости
    var animated = false;
    $(window).on('scroll', function() {
        if (animated) return;
        var sectionTop = $('.stats-section').offset().top;
        var scrollBottom = $(window).scrollTop() + $(window).height();
        if (scrollBottom > sectionTop + 100) {
            animated = true;
            animateCountup();
        }
    });
});
</script>


<section class="portfolio-section py-5">
    <div class="container-fluid px-4">

        <?php
        $portfolio_pages = get_pages([
            'parent'      => 29,
            'post_status' => 'publish',
            'sort_column' => 'menu_order',
        ]);
        ?>

        <div class="owl-carousel owl-portfolio">
            <?php foreach ($portfolio_pages as $port) :
                $port_id = $port->ID;
                $gallery = rwmb_meta('prod_service_gallery', ['object_type' => 'post'], $port_id);
                $thumb   = get_the_post_thumbnail_url($port_id, 'costom-gallery') ?: ($gallery ? reset($gallery)['full_url'] : get_template_directory_uri() . '/img/placeholder.jpg');
            ?>
                <div class="portfolio-slide"
                     data-page-id="<?php echo $port_id; ?>"
                     data-title="<?php echo esc_attr($port->post_title); ?>"
                     data-url="<?php echo esc_url(get_permalink($port_id)); ?>">
                    <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($port->post_title); ?>">
                    <span class="portfolio-title"><?php echo esc_html($port->post_title); ?></span>
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

    // Галереи страниц (загружаем через AJAX при клике)
    var galleries = {
        <?php foreach ($portfolio_pages as $port) :
            $port_id = $port->ID;
            $gallery = rwmb_meta('prod_service_gallery', ['object_type' => 'post'], $port_id);
            if (!$gallery) continue;
            $images = array_values($gallery);
        ?>
        <?php echo $port_id; ?>: [
            <?php foreach ($images as $img) : ?>
            '<?php echo esc_url($img['full_url']); ?>',
            <?php endforeach; ?>
        ],
        <?php endforeach; ?>
    };

    // Инициализация карусели портфолио
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

    // Клик по слайду
    $(document).on('click', '.portfolio-slide', function() {
        var pageId = $(this).data('page-id');
        var title  = $(this).data('title');
        var url    = $(this).data('url');
        var imgs   = galleries[pageId] || [];

        $('#portfolioModalTitle').text(title);
        $('#portfolioModalLink').attr('href', url);

        // Очищаем и наполняем галерею
        var $gallery = $('#portfolioModalGallery');
        $gallery.html('');

        if (imgs.length) {
            $.each(imgs, function(i, src) {
                $gallery.append('<div class="portfolio-modal-slide"><img src="' + src + '" alt=""></div>');
            });
        } else {
            $gallery.append('<div class="portfolio-modal-slide"><p class="text-white text-center p-4">Галерея не заполнена</p></div>');
        }

        // Инициализируем карусель модалки
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