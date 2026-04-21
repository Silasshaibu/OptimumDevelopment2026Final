(function () {
    var carousel = document.querySelector('.tsp-carousel');
    var track = document.querySelector('.tsp-block--body');
    var cards = Array.prototype.slice.call(document.querySelectorAll('.tsp-card'));
    var viewToggle = document.querySelector('.tst-view-all-btn');
    var currentIndex = 0;
    var isGridView = false;

    if (!carousel || !track || cards.length === 0 || !viewToggle) {
        return;
    }

    function getVisibleCards() {
        return window.innerWidth <= 430 ? 1 : 2;
    }

    function getGap() {
        return parseFloat(window.getComputedStyle(track).columnGap || window.getComputedStyle(track).gap || '0');
    }

    function getMaxIndex() {
        return Math.max(cards.length - getVisibleCards(), 0);
    }

    function updateIndicators() {
        var footSvgs = document.querySelectorAll('.tsp-block--foot .tsp-nav svg');
        if (footSvgs.length === 2) {
            if (isGridView) {
                footSvgs[0].style.fill = '#BABABA';
                footSvgs[1].style.fill = '#BABABA';
            } else {
                var maxIndex = getMaxIndex();
                footSvgs[0].style.fill = currentIndex > 0 ? '#399CDB' : '#BABABA';
                footSvgs[1].style.fill = currentIndex < maxIndex ? '#399CDB' : '#BABABA';
            }
        }
    }

    function renderCarousel() {
        if (isGridView) {
            track.classList.add('tsp-block--body--grid');
            carousel.style.overflow = 'visible';
            track.style.transform = 'translateX(0)';
        } else {
            var maxIndex = getMaxIndex();
            var step = cards[0].offsetWidth + getGap();

            currentIndex = Math.min(currentIndex, maxIndex);
            track.classList.remove('tsp-block--body--grid');
            carousel.style.overflow = 'hidden';
            track.style.transform = 'translateX(' + (currentIndex * step * -1) + 'px)';
        }

        updateIndicators();
    }

    viewToggle.addEventListener('click', function () {
        isGridView = !isGridView;
        viewToggle.setAttribute('aria-expanded', String(isGridView));
        viewToggle.querySelector('span').textContent = isGridView ? 'View Less' : 'View All';
        renderCarousel();
    });

    var footPrev = document.querySelector('.tsp-block--foot .tsp-nav svg:first-child');
    var footNext = document.querySelector('.tsp-block--foot .tsp-nav svg:last-child');

    if (footPrev) {
        footPrev.addEventListener('click', function () {
            if (currentIndex <= 0 || isGridView) {
                return;
            }
            currentIndex -= 1;
            renderCarousel();
        });
    }

    if (footNext) {
        footNext.addEventListener('click', function () {
            var maxIndex = getMaxIndex();
            if (currentIndex >= maxIndex || isGridView) {
                return;
            }
            currentIndex += 1;
            renderCarousel();
        });
    }

    window.addEventListener('resize', renderCarousel);
    renderCarousel();
}());