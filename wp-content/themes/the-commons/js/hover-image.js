/**
 * Front end: show a 250px image for .hover-image text.
 * Mouse: appears on hover with its bottom-right corner at the cursor and follows the cursor.
 * Touch: tap the text to show it, tap anywhere else (or scroll) to hide it.
 * Uses event delegation on document so it also works in popout content loaded by AJAX.
 */
(function () {
    var preview = null;
    var activeEl = null;
    var lastX = 0;
    var lastY = 0;

    function getPreview() {
        if (!preview) {
            preview = document.createElement('img');
            preview.className = 'hover-image-preview';
            preview.alt = '';
            // Show once the new image has loaded (so the previous picture never flashes)
            preview.addEventListener('load', function () {
                if (!activeEl) return;
                preview.classList.add('is-visible');
                position();
            });
            document.body.appendChild(preview);
        }
        return preview;
    }

    // Bottom-right corner at the pointer; flip to the other side near the left/top edge
    function position() {
        if (!preview || !activeEl) return;
        var w = preview.offsetWidth;
        var h = preview.offsetHeight;
        var vw = document.documentElement.clientWidth;
        var vh = document.documentElement.clientHeight;
        var left = lastX - w;
        var top = lastY - h;
        if (left < 0) left = lastX;
        if (top < 0) top = lastY;
        left = Math.max(0, Math.min(left, vw - w));
        top = Math.max(0, Math.min(top, vh - h));
        preview.style.left = left + 'px';
        preview.style.top = top + 'px';
    }

    function show(target, x, y) {
        var url = target.getAttribute('data-image');
        if (!url) return;
        activeEl = target;
        lastX = x;
        lastY = y;
        var img = getPreview();
        if (img.getAttribute('src') !== url) {
            img.classList.remove('is-visible');
            img.setAttribute('src', url); // the load handler shows it
        } else {
            img.classList.add('is-visible');
            position();
        }
    }

    function hide() {
        activeEl = null;
        if (preview) preview.classList.remove('is-visible');
    }

    // Mouse hover
    document.addEventListener('pointerover', function (e) {
        if (e.pointerType !== 'mouse') return;
        var target = e.target.closest && e.target.closest('.hover-image');
        if (target) show(target, e.clientX, e.clientY);
    });
    document.addEventListener('pointermove', function (e) {
        if (e.pointerType !== 'mouse' || !activeEl) return;
        lastX = e.clientX;
        lastY = e.clientY;
        position();
    });
    document.addEventListener('pointerout', function (e) {
        if (e.pointerType !== 'mouse' || !activeEl) return;
        // Ignore moves between elements inside the same hover text
        if (e.relatedTarget && activeEl.contains(e.relatedTarget)) return;
        if (activeEl.contains(e.target)) hide();
    });

    // Touch: tap to toggle, tap elsewhere to close.
    // pointerup instead of click: iOS doesn't reliably fire click on plain text,
    // and a swipe/scroll ends in pointercancel, so this only runs for real taps.
    document.addEventListener('pointerup', function (e) {
        if (e.pointerType === 'mouse') return;
        var target = e.target.closest && e.target.closest('.hover-image');
        if (target) {
            if (activeEl === target) {
                hide();
            } else {
                show(target, e.clientX, e.clientY);
            }
        } else if (activeEl) {
            hide();
        }
    });

    // The preview is fixed to the screen, so hide it when anything scrolls (including the popout)
    document.addEventListener('scroll', function () {
        if (activeEl) hide();
    }, true);
})();
