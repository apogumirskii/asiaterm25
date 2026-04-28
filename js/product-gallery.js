document.addEventListener('DOMContentLoaded', function () {

    var mainEl = document.querySelector('.swiper-product-gallery');
    var thumbsEl = document.querySelector('.swiper-product-thumbs');
    if (!mainEl || typeof Swiper === 'undefined') {
        attachProductTabs();
        attachDownloadRows();
        return;
    }

    var thumbs = null;
    if (thumbsEl) {
        thumbs = new Swiper(thumbsEl, {
            slidesPerView: 5,
            spaceBetween: 8,
            watchSlidesProgress: true,
            slideToClickedSlide: true,
        });
    }

    var nextBtn = mainEl.querySelector('.swiper-button-next') || (mainEl.parentElement && mainEl.parentElement.querySelector('.swiper-button-next'));
    var prevBtn = mainEl.querySelector('.swiper-button-prev') || (mainEl.parentElement && mainEl.parentElement.querySelector('.swiper-button-prev'));

    new Swiper(mainEl, {
        slidesPerView: 1,
        loop: true,
        navigation: { prevEl: prevBtn, nextEl: nextBtn },
        thumbs: thumbs ? { swiper: thumbs } : undefined
    });

    attachProductTabs();
    attachDownloadRows();

    function attachProductTabs() {
        var tabs = document.getElementById('productTabs');
        if (!tabs) return;
        tabs.addEventListener('click', function (e) {
            var link = e.target.closest('.nav-link');
            if (!link) return;
            e.preventDefault();
            if (window.bootstrap && window.bootstrap.Tab) {
                var tab = window.bootstrap.Tab.getOrCreateInstance(link);
                tab.show();
            }
            var section = document.querySelector('.product-tabs');
            if (!section) return;
            var top = section.getBoundingClientRect().top + window.pageYOffset - 100;
            if (window.pageYOffset > top) {
                window.scrollTo({ top: top, behavior: 'smooth' });
            }
        });
    }

    function attachDownloadRows() {
        document.querySelectorAll('.download-list li').forEach(function (li) {
            li.style.cursor = 'pointer';
            li.addEventListener('click', function (e) {
                if (e.target.closest('a')) return;
                var a = li.querySelector('a');
                if (a && a.href) window.open(a.href, '_blank');
            });
        });
    }
});
