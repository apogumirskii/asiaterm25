(function () {
    'use strict';

    var groups = {};
    var current = { group: null, index: 0 };
    var overlay = null;
    var imgEl = null;
    var captionEl = null;
    var counterEl = null;
    var touchStartX = 0;

    function buildOverlay() {
        if (overlay) return;
        overlay = document.createElement('div');
        overlay.className = 'atlb-overlay';
        overlay.innerHTML =
            '<button type="button" class="atlb-close" aria-label="Закрыть"><i class="fas fa-times"></i></button>' +
            '<button type="button" class="atlb-prev" aria-label="Назад"><i class="fas fa-chevron-left"></i></button>' +
            '<button type="button" class="atlb-next" aria-label="Вперёд"><i class="fas fa-chevron-right"></i></button>' +
            '<div class="atlb-counter"></div>' +
            '<div class="atlb-stage"><img class="atlb-img" alt=""></div>' +
            '<div class="atlb-caption"></div>';
        document.body.appendChild(overlay);
        imgEl = overlay.querySelector('.atlb-img');
        captionEl = overlay.querySelector('.atlb-caption');
        counterEl = overlay.querySelector('.atlb-counter');

        overlay.querySelector('.atlb-close').addEventListener('click', close);
        overlay.querySelector('.atlb-prev').addEventListener('click', prev);
        overlay.querySelector('.atlb-next').addEventListener('click', next);
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) close();
        });

        overlay.addEventListener('touchstart', function (e) {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });
        overlay.addEventListener('touchend', function (e) {
            var dx = e.changedTouches[0].screenX - touchStartX;
            if (Math.abs(dx) < 40) return;
            if (dx < 0) next(); else prev();
        }, { passive: true });
    }

    function rebuildGroups() {
        groups = {};
        document.querySelectorAll('a[data-lightbox]').forEach(function (a) {
            var name = a.getAttribute('data-lightbox') || 'default';
            if (!groups[name]) groups[name] = [];
            groups[name].push({
                href: a.getAttribute('href'),
                title: a.getAttribute('data-title') || a.getAttribute('title') || '',
                el: a
            });
        });
    }

    function open(group, index) {
        rebuildGroups();
        if (!groups[group] || !groups[group][index]) return;
        buildOverlay();
        current.group = group;
        current.index = index;
        render();
        document.body.classList.add('atlb-open');
        overlay.classList.add('atlb-visible');
    }

    function render() {
        var items = groups[current.group] || [];
        if (!items.length) return;
        var item = items[current.index];
        if (!item) return;
        imgEl.setAttribute('src', item.href);
        imgEl.setAttribute('alt', item.title || '');
        captionEl.textContent = item.title || '';
        if (items.length > 1) {
            counterEl.textContent = (current.index + 1) + ' / ' + items.length;
            counterEl.style.display = '';
            overlay.querySelector('.atlb-prev').style.display = '';
            overlay.querySelector('.atlb-next').style.display = '';
        } else {
            counterEl.style.display = 'none';
            overlay.querySelector('.atlb-prev').style.display = 'none';
            overlay.querySelector('.atlb-next').style.display = 'none';
        }
    }

    function close() {
        if (!overlay) return;
        overlay.classList.remove('atlb-visible');
        document.body.classList.remove('atlb-open');
        imgEl.setAttribute('src', '');
    }

    function prev() {
        var items = groups[current.group] || [];
        if (items.length < 2) return;
        current.index = (current.index - 1 + items.length) % items.length;
        render();
    }

    function next() {
        var items = groups[current.group] || [];
        if (items.length < 2) return;
        current.index = (current.index + 1) % items.length;
        render();
    }

    document.addEventListener('click', function (e) {
        var link = e.target.closest('a[data-lightbox]');
        if (!link) return;
        e.preventDefault();
        var name = link.getAttribute('data-lightbox') || 'default';
        rebuildGroups();
        var items = groups[name] || [];
        var idx = -1;
        for (var i = 0; i < items.length; i++) {
            if (items[i].el === link) { idx = i; break; }
        }
        if (idx < 0) idx = 0;
        open(name, idx);
    });

    document.addEventListener('keydown', function (e) {
        if (!overlay || !overlay.classList.contains('atlb-visible')) return;
        if (e.key === 'Escape') close();
        else if (e.key === 'ArrowLeft') prev();
        else if (e.key === 'ArrowRight') next();
    });

    window.AsiatermLightbox = { open: open, close: close, next: next, prev: prev };
})();
