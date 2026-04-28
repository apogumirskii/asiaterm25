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
document.addEventListener('DOMContentLoaded', function () {
    var animated = false;
    function animateCountup() {
        document.querySelectorAll('.countup').forEach(function (el) {
            var target  = parseInt(el.dataset.target, 10) || 0;
            var current = 0;
            var step = Math.ceil(target / (2000 / 16));
            var timer = setInterval(function () {
                current += step;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                el.textContent = current;
            }, 16);
        });
    }
    var statsSection = document.querySelector('.stats-section');
    if (!statsSection) return;
    window.addEventListener('scroll', function () {
        if (animated) return;
        var rect = statsSection.getBoundingClientRect();
        if (rect.top + 100 < window.innerHeight) {
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

        <div class="swiper swiper-portfolio">
            <div class="swiper-wrapper">
            <?php foreach ($portfolio_items as $port) : ?>
                <div class="swiper-slide portfolio-slide"
                     data-page-id="<?php echo $port['id']; ?>"
                     data-title="<?php echo esc_attr($port['title']); ?>"
                     data-url="<?php echo esc_url($port['url']); ?>">
                    <img src="<?php echo esc_url($port['thumb']); ?>" alt="<?php echo esc_attr($port['title']); ?>" loading="lazy">
                    <span class="portfolio-title"><?php echo esc_html($port['title']); ?></span>
                </div>
            <?php endforeach; ?>
            </div>
        </div>

    </div>
</section>

<!-- Модальное окно портфолио -->
<div class="modal fade" id="portfolioModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content bg-dark border-0">
            <div class="modal-header border-0 py-2 px-3">
                <h6 class="modal-title text-white mb-0" id="portfolioModalTitle"></h6>
                <div class="d-flex align-items-center gap-3 ms-auto">
                    <a href="#" id="portfolioModalLink" class="btn btn-sm portfolio-detail-btn">
                        Подробнее <i class="fas fa-arrow-right ms-1"></i>
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

    var galleries = {
        <?php foreach ($portfolio_items as $port) :
            if (!$port['gallery']) continue;
        ?>
        <?php echo $port['id']; ?>: [
            <?php foreach ($port['gallery'] as $img) : ?>
            '<?php echo esc_url(asiaterm_webp_url_swap($img['full_url'])); ?>',
            <?php endforeach; ?>
        ],
        <?php endforeach; ?>
    };

    new Swiper('.swiper-portfolio', {
        loop: true,
        spaceBetween: 20,
        autoplay: { delay: 3000, disableOnInteraction: false, pauseOnMouseEnter: true },
        breakpoints: {
            576:  { slidesPerView: 2 },
            768:  { slidesPerView: 3 },
            1200: { slidesPerView: 4 }
        }
    });

    var modalEl = document.getElementById('portfolioModal');
    var modalGallery = document.getElementById('portfolioModalGallery');
    var modalWrapper = modalGallery ? modalGallery.querySelector('.swiper-wrapper') : null;
    var modalSwiper = null;

    document.addEventListener('click', function (e) {
        var slide = e.target.closest('.portfolio-slide');
        if (!slide) return;
        var pageId = slide.dataset.pageId;
        var title  = slide.dataset.title || '';
        var url    = slide.dataset.url || '#';
        var imgs   = galleries[pageId] || [];

        var titleEl = document.getElementById('portfolioModalTitle');
        var linkEl  = document.getElementById('portfolioModalLink');
        if (titleEl) titleEl.textContent = title;
        if (linkEl) linkEl.setAttribute('href', url);

        if (!modalWrapper) return;
        modalWrapper.innerHTML = '';

        if (imgs.length) {
            imgs.forEach(function (src) {
                var slideDiv = document.createElement('div');
                slideDiv.className = 'swiper-slide portfolio-modal-slide';
                slideDiv.innerHTML = '<img src="' + src + '" alt="">';
                modalWrapper.appendChild(slideDiv);
            });
        } else {
            var empty = document.createElement('div');
            empty.className = 'swiper-slide portfolio-modal-slide';
            empty.innerHTML = '<p class="text-white text-center p-4">Галерея не заполнена</p>';
            modalWrapper.appendChild(empty);
        }

        if (modalSwiper) {
            modalSwiper.destroy(true, true);
            modalSwiper = null;
        }

        modalSwiper = new Swiper('#portfolioModalGallery', {
            slidesPerView: 1,
            loop: imgs.length > 1,
            navigation: {
                prevEl: modalGallery.querySelector('.swiper-button-prev'),
                nextEl: modalGallery.querySelector('.swiper-button-next')
            },
            pagination: {
                el: modalGallery.querySelector('.swiper-pagination'),
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
