const megaMenuItems = document.querySelectorAll('.megamenu-item');
const megaMenuPanels = document.querySelectorAll('.megamenu-panel');

megaMenuItems.forEach(function (item) {
    item.addEventListener('mouseenter', function () {
        megaMenuItems.forEach(function (i) { i.classList.remove('active'); });
        megaMenuPanels.forEach(function (p) { p.classList.remove('active'); });
        this.classList.add('active');
        var targetId = this.getAttribute('data-target');
        var panel = document.getElementById(targetId);
        if (panel) panel.classList.add('active');
        updateScrollFade(megaMenuRight);
    });
});

var megaMenuRight = document.querySelector('.megamenu-scroll');

function updateScrollFade(el) {
    var atTop = el.scrollTop === 0;
    var atBottom = el.scrollTop + el.clientHeight >= el.scrollHeight - 1;
    var outer = el.closest('.megamenu-right');
    outer.classList.remove('fade-top', 'fade-bottom', 'fade-both');
    if (!atTop && !atBottom) {
        outer.classList.add('fade-both');
    } else if (!atTop) {
        outer.classList.add('fade-top');
    } else if (!atBottom) {
        outer.classList.add('fade-bottom');
    }
}

megaMenuRight.addEventListener('scroll', function () {
    updateScrollFade(this);
});

/* Run once on load so the bottom fade shows immediately if content overflows */
updateScrollFade(megaMenuRight);
