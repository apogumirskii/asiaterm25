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
});
