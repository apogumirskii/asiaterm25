jQuery(document).ready(function($) {

    // Hero Slider
    var $owl = $(".owl-hero");
    if ($owl.length) {
        $owl.owlCarousel({
            items: 1,
            loop: true,
            nav: false,
            dots: false,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            smartSpeed: 1000,
            onInitialized: function(e) {
                buildBullets(e.item.count, e.item.index);
            },
            onChanged: function(e) {
                updateBullets(e.item.index % e.item.count);
            }
        });

        function buildBullets(count, active) {
            var $b = $('#heroBullets').empty();
            for (var i = 0; i < count; i++) {
                var num = (i + 1).toString().padStart(2, '0');
                $b.append('<div class="hero-bullet' + (i === active ? ' active' : '') + '" data-index="' + i + '">' + num + '</div>');
            }
        }

        function updateBullets(active) {
            $('.hero-bullet').removeClass('active').filter('[data-index="' + active + '"]').addClass('active');
        }

        $(document).on('click', '.hero-bullet', function() {
            $owl.trigger('to.owl.carousel', [$(this).data('index'), 500]);
        });
    }

    // Popular Products Carousel
    var $products = $(".owl-products");
    if ($products.length) {
        $products.owlCarousel({
            loop: true,
            margin: 24,
            nav: true,
            dots: false,
            navText: ['', ''],
            navContainer: false,
            responsive: {
                0:    { items: 1 },
                576:  { items: 2 },
                992:  { items: 3 },
                1200: { items: 4 }
            }
        });

        $('.products-prev').click(function() {
            $products.trigger('prev.owl.carousel');
        });
        $('.products-next').click(function() {
            $products.trigger('next.owl.carousel');
        });
    }

    // Partners Carousel
    var $partners = $(".owl-partners");
    if ($partners.length) {
        $partners.owlCarousel({
            loop: true,
            margin: 0,
            nav: false,
            dots: false,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            responsive: {
                0:    { items: 2 },
                600:  { items: 4 },
                1000: { items: 8 }
            }
        });
    }

    // Video Modal (certificates)
    var $videoModal = $('#videoModal');
    if ($videoModal.length) {
        $videoModal.on('show.bs.modal', function() {
            $('#youtubeFrame').attr('src', $('#youtubeFrame').data('src'));
        });
        $videoModal.on('hidden.bs.modal', function() {
            $('#youtubeFrame').attr('src', '');
        });
    }

    // Documents Table Filter (partners page)
    var $docsTable = $('#docsTable');
    if ($docsTable.length) {
        var $search = $('#docsSearch');
        var $catFilter = $('#docsCategoryFilter');
        var $typeFilter = $('#docsTypeFilter');
        var $rows = $docsTable.find('tbody tr');
        var $count = $('#docsCount');
        var total = $rows.length;

        function filterDocs() {
            var query = $search.val().toLowerCase().trim();
            var cat = $catFilter.val();
            var type = $typeFilter.val();
            var visible = 0;

            $rows.each(function() {
                var $row = $(this);
                var matchName = !query || $row.data('name').indexOf(query) !== -1 || $row.data('page').indexOf(query) !== -1;
                var matchCat = !cat || $row.data('category') === cat;
                var matchType = !type || $row.data('type') === type;

                if (matchName && matchCat && matchType) {
                    $row.show();
                    visible++;
                } else {
                    $row.hide();
                }
            });

            $count.text('Найдено документов: ' + visible);
        }

        $search.on('input', filterDocs);
        $catFilter.on('change', filterDocs);
        $typeFilter.on('change', filterDocs);
    }

    // Clickable document rows
    $('#docsTable').on('click', 'tr[data-href]', function(e) {
        if ($(e.target).closest('a').length) return;
        window.open($(this).data('href'), '_blank');
    });

    // Portfolio filter
    var $filterBtns = $('.portfolio-filter-btn');
    if ($filterBtns.length) {
        $filterBtns.on('click', function() {
            var filter = $(this).data('filter');
            $filterBtns.removeClass('active');
            $(this).addClass('active');

            $('#portfolioGrid .portfolio-item').each(function() {
                if (filter === '*' || $(this).data('cats').indexOf(filter) !== -1) {
                    $(this).removeClass('hidden');
                } else {
                    $(this).addClass('hidden');
                }
            });
        });
    }

    // Portfolio project gallery thumbs
    $(document).on('click', '.project-thumb', function() {
        var src = $(this).data('src');
        $('#projectMainImg').attr('src', src);
        $('.project-thumb').removeClass('active');
        $(this).addClass('active');
    });
});
