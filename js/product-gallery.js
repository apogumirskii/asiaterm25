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
});
