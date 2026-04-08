jQuery(document).ready(function($) {
    var $main = $(".owl-product-gallery");
    var $thumbs = $(".owl-product-thumbs");

    if (!$main.length) return;

    $main.owlCarousel({
        items: 1,
        loop: true,
        nav: true,
        dots: false,
        navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"]
    });

    $thumbs.owlCarousel({
        items: 5,
        loop: false,
        nav: false,
        dots: false,
        margin: 8
    });

    $thumbs.on('click', '.product-thumb', function() {
        var idx = $(this).closest('.owl-item').index();
        $main.trigger('to.owl.carousel', [idx, 300]);
    });

    // Product tabs: prevent scroll jump on tab click (mobile)
    $('#productTabs').on('click', '.nav-link', function(e) {
        e.preventDefault();
        var $this = $(this);
        $this.tab('show');
        var tabsTop = $('.product-tabs').offset().top - 100;
        if ($(window).scrollTop() > tabsTop) {
            $('html, body').scrollTop(tabsTop);
        }
    });

    // Clickable download rows
    $('.download-list li').css('cursor', 'pointer').on('click', function(e) {
        if ($(e.target).closest('a').length) return;
        var href = $(this).find('a').first().attr('href');
        if (href) window.open(href, '_blank');
    });
});
