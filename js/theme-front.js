document.addEventListener('DOMContentLoaded', function () {

    // Hero Slider
    var heroEl = document.querySelector('.swiper-hero');
    if (heroEl && typeof Swiper !== 'undefined') {
        var bulletsContainer = document.getElementById('heroBullets');
        var hero = new Swiper(heroEl, {
            slidesPerView: 1,
            loop: true,
            speed: 800,
            autoplay: { delay: 5000, disableOnInteraction: false, pauseOnMouseEnter: true },
            effect: 'fade',
            fadeEffect: { crossFade: true },
            on: {
                init: function (s) {
                    if (!bulletsContainer) return;
                    bulletsContainer.innerHTML = '';
                    var count = s.slides.length - (s.loopedSlides ? s.loopedSlides * 2 : 0);
                    for (var i = 0; i < count; i++) {
                        var num = (i + 1).toString().padStart(2, '0');
                        var b = document.createElement('div');
                        b.className = 'hero-bullet' + (i === 0 ? ' active' : '');
                        b.dataset.index = i;
                        b.textContent = num;
                        bulletsContainer.appendChild(b);
                    }
                },
                slideChange: function (s) {
                    if (!bulletsContainer) return;
                    var active = s.realIndex;
                    var bullets = bulletsContainer.querySelectorAll('.hero-bullet');
                    bullets.forEach(function (b) { b.classList.remove('active'); });
                    var target = bulletsContainer.querySelector('.hero-bullet[data-index="' + active + '"]');
                    if (target) target.classList.add('active');
                }
            }
        });
        if (bulletsContainer) {
            bulletsContainer.addEventListener('click', function (e) {
                var b = e.target.closest('.hero-bullet');
                if (!b) return;
                hero.slideToLoop(parseInt(b.dataset.index, 10), 500);
            });
        }
    }

    // Popular Products Carousels (могут быть несколько на странице)
    document.querySelectorAll('.swiper-products').forEach(function (el) {
        if (typeof Swiper === 'undefined') return;
        var wrap = el.closest('.position-relative') || el.parentElement;
        var prev = wrap ? wrap.querySelector('.products-prev') : null;
        var next = wrap ? wrap.querySelector('.products-next') : null;
        new Swiper(el, {
            slidesPerView: 1,
            spaceBetween: 24,
            loop: true,
            navigation: { prevEl: prev, nextEl: next },
            breakpoints: {
                576:  { slidesPerView: 2 },
                992:  { slidesPerView: 3 },
                1200: { slidesPerView: 4 }
            }
        });
    });

    // Partners Carousel
    document.querySelectorAll('.swiper-partners').forEach(function (el) {
        if (typeof Swiper === 'undefined') return;
        new Swiper(el, {
            slidesPerView: 2,
            spaceBetween: 0,
            loop: true,
            autoplay: { delay: 3000, disableOnInteraction: false, pauseOnMouseEnter: true },
            breakpoints: {
                600:  { slidesPerView: 4 },
                1000: { slidesPerView: 8 }
            }
        });
    });

    // Video Modal (certificates)
    var videoModal = document.getElementById('videoModal');
    if (videoModal) {
        videoModal.addEventListener('show.bs.modal', function () {
            var frame = document.getElementById('youtubeFrame');
            if (frame) frame.setAttribute('src', frame.dataset.src || '');
        });
        videoModal.addEventListener('hidden.bs.modal', function () {
            var frame = document.getElementById('youtubeFrame');
            if (frame) frame.setAttribute('src', '');
        });
    }

    // Documents Table Filter (partners page)
    var docsTable = document.getElementById('docsTable');
    if (docsTable) {
        var search = document.getElementById('docsSearch');
        var catFilter = document.getElementById('docsCategoryFilter');
        var typeFilter = document.getElementById('docsTypeFilter');
        var rows = Array.prototype.slice.call(docsTable.querySelectorAll('tbody tr'));
        var count = document.getElementById('docsCount');

        function filterDocs() {
            var query = (search && search.value || '').toLowerCase().trim();
            var cat = catFilter ? catFilter.value : '';
            var type = typeFilter ? typeFilter.value : '';
            var visible = 0;

            rows.forEach(function (row) {
                var name = (row.dataset.name || '').toString();
                var page = (row.dataset.page || '').toString();
                var rcat = (row.dataset.category || '').toString();
                var rtype = (row.dataset.type || '').toString();
                var matchName = !query || name.indexOf(query) !== -1 || page.indexOf(query) !== -1;
                var matchCat = !cat || rcat === cat;
                var matchType = !type || rtype === type;

                if (matchName && matchCat && matchType) {
                    row.style.display = '';
                    visible++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (count) count.textContent = 'Найдено документов: ' + visible;
        }

        if (search) search.addEventListener('input', filterDocs);
        if (catFilter) catFilter.addEventListener('change', filterDocs);
        if (typeFilter) typeFilter.addEventListener('change', filterDocs);

        docsTable.addEventListener('click', function (e) {
            var row = e.target.closest('tr[data-href]');
            if (!row) return;
            if (e.target.closest('a')) return;
            window.open(row.dataset.href, '_blank');
        });
    }

    // Portfolio filter
    var filterBtns = document.querySelectorAll('.portfolio-filter-btn');
    if (filterBtns.length) {
        filterBtns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var filter = btn.dataset.filter;
                filterBtns.forEach(function (b) { b.classList.remove('active'); });
                btn.classList.add('active');

                var grid = document.getElementById('portfolioGrid');
                if (!grid) return;
                grid.querySelectorAll('.portfolio-item').forEach(function (item) {
                    var cats = (item.dataset.cats || '').toString();
                    if (filter === '*' || cats.indexOf(filter) !== -1) {
                        item.classList.remove('hidden');
                    } else {
                        item.classList.add('hidden');
                    }
                });
            });
        });
    }

    // Portfolio project gallery thumbs
    document.addEventListener('click', function (e) {
        var thumb = e.target.closest('.project-thumb');
        if (!thumb) return;
        var src = thumb.dataset.src;
        var main = document.getElementById('projectMainImg');
        if (main && src) main.setAttribute('src', src);
        document.querySelectorAll('.project-thumb').forEach(function (t) { t.classList.remove('active'); });
        thumb.classList.add('active');
    });
});
