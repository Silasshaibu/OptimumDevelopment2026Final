(function () {
    var carousel = document.querySelector('.tsp-carousel');
    var track = document.querySelector('.tsp-block--body');
    var cards = Array.prototype.slice.call(document.querySelectorAll('.tsp-card'));
    var previousButton = document.querySelector('.tsp-nav__btn--prev');
    var nextButton = document.querySelector('.tsp-nav__btn--next');
    var nav = document.querySelector('.tsp-nav');
    var viewToggle = document.querySelector('.tsp-view-all');
    var currentIndex = 0;
    var isGridView = false;

    if (!carousel || !track || cards.length === 0 || !previousButton || !nextButton || !nav || !viewToggle) {
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

    function updateButtons() {
        var maxIndex = getMaxIndex();
        previousButton.disabled = isGridView || currentIndex <= 0;
        nextButton.disabled = isGridView || currentIndex >= maxIndex;
        nav.hidden = isGridView;
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

        updateButtons();
    }

    previousButton.addEventListener('click', function () {
        if (currentIndex <= 0 || isGridView) {
            return;
        }

        currentIndex -= 1;
        renderCarousel();
    });

    nextButton.addEventListener('click', function () {
        var maxIndex = getMaxIndex();

        if (currentIndex >= maxIndex || isGridView) {
            return;
        }

        currentIndex += 1;
        renderCarousel();
    });

    viewToggle.addEventListener('click', function () {
        isGridView = !isGridView;
        viewToggle.setAttribute('aria-expanded', String(isGridView));
        viewToggle.querySelector('span').textContent = isGridView ? 'View Less' : 'View All';
        renderCarousel();
    });

    window.addEventListener('resize', renderCarousel);
    renderCarousel();
}());