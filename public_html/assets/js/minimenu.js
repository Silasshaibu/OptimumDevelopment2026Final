(function () {
    var track = document.getElementById('miniMenuTrack');
    var trackOuter = document.getElementById('miniMenuTrackOuter');
    var prevBtn = document.getElementById('miniMenuPrev');
    var nextBtn = document.getElementById('miniMenuNext');
    var dotsContainer = document.getElementById('miniMenuDots');

    var cards = Array.prototype.slice.call(track.querySelectorAll('.minimenu-card'));
    var totalCards = cards.length;
    var currentIndex = 0;
    var GAP = 24;

    function getVisibleCount() {
        var vw = window.innerWidth;
        if (vw > 968) return 4;
        if (vw > 430) return 2;
        return 1;
    }

    function getCardWidth() {
        var visible = getVisibleCount();
        return Math.floor((trackOuter.offsetWidth - GAP * (visible - 1)) / visible);
    }

    function getMaxIndex() {
        return Math.max(0, totalCards - getVisibleCount());
    }

    function setCardWidths() {
        var w = getCardWidth();
        cards.forEach(function (card) {
            card.style.width = w + 'px';
            card.style.flexBasis = w + 'px';
        });
    }

    function buildDots() {
        var maxIndex = getMaxIndex();
        dotsContainer.innerHTML = '';
        for (var i = 0; i <= maxIndex; i++) {
            var dot = document.createElement('button');
            dot.className = 'minimenu-dot' + (i === currentIndex ? ' active' : '');
            dot.setAttribute('aria-label', 'Slide ' + (i + 1));
            (function (idx) {
                dot.addEventListener('click', function () {
                    currentIndex = idx;
                    updateSlider();
                });
            })(i);
            dotsContainer.appendChild(dot);
        }
    }

    function updateSlider() {
        var maxIndex = getMaxIndex();
        currentIndex = Math.min(currentIndex, maxIndex);

        var cardWidth = getCardWidth();
        track.style.transform = 'translateX(-' + (currentIndex * (cardWidth + GAP)) + 'px)';

        var dots = dotsContainer.querySelectorAll('.minimenu-dot');
        dots.forEach(function (dot, i) {
            dot.classList.toggle('active', i === currentIndex);
        });

        prevBtn.classList.toggle('minimenu-arrow--disabled', currentIndex === 0);
        nextBtn.classList.toggle('minimenu-arrow--disabled', currentIndex >= maxIndex);
    }

    prevBtn.addEventListener('click', function () {
        if (currentIndex > 0) {
            currentIndex--;
            updateSlider();
        }
    });

    nextBtn.addEventListener('click', function () {
        if (currentIndex < getMaxIndex()) {
            currentIndex++;
            updateSlider();
        }
    });

    window.addEventListener('resize', function () {
        setCardWidths();
        buildDots();
        updateSlider();
    });

    /* Init */
    setCardWidths();
    buildDots();
    updateSlider();
})();
