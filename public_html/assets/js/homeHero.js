(function () {
    const hero = document.querySelector('.home-hero');
    if (!hero || hero.dataset.carouselReady === 'true') {
        return;
    }

    hero.dataset.carouselReady = 'true';

    const slides = Array.from(hero.querySelectorAll('.home-hero-slide'));
    const dots = Array.from(hero.querySelectorAll('.carousel-dot'));
    const fills = dots.map((dot) => dot.querySelector('.carousel-dot__fill'));
    const playPauseBtn = hero.querySelector('.play-pause-btn');
    const pauseIcon = hero.querySelector('.pause-icon');
    const playIcon = hero.querySelector('.play-icon');
    const interactiveElements = hero.querySelectorAll('a, button, [role="button"], [role="tab"], input, select, textarea');

    if (!slides.length || slides.length !== dots.length || !playPauseBtn || !pauseIcon || !playIcon) {
        return;
    }

    const state = {
        currentIndex: 0,
        slideDurationMs: 6000,
        elapsedInSlideMs: 0,
        slideStartTimestamp: 0,
        autoplayTimeoutId: null,
        progressRafId: null,
        isUserPaused: false,
        isViewportVisible: true
    };

    function clearAutoplayTimer() {
        if (state.autoplayTimeoutId) {
            clearTimeout(state.autoplayTimeoutId);
            state.autoplayTimeoutId = null;
        }
    }

    function clearProgressRaf() {
        if (state.progressRafId) {
            cancelAnimationFrame(state.progressRafId);
            state.progressRafId = null;
        }
    }

    function setPlayPauseUi(isPaused) {
        playPauseBtn.setAttribute('aria-pressed', String(isPaused));
        playPauseBtn.setAttribute('aria-label', isPaused ? 'Play carousel' : 'Pause carousel');
        pauseIcon.style.display = isPaused ? 'none' : 'block';
        playIcon.style.display = isPaused ? 'block' : 'none';
    }

    function setDotProgress(index, ratio) {
        const fill = fills[index];
        if (!fill) {
            return;
        }

        const clamped = Math.max(0, Math.min(1, ratio));
        fill.style.transform = 'scaleX(' + clamped + ')';
    }

    function resetAllDotProgress() {
        fills.forEach((fill) => {
            if (fill) {
                fill.style.transform = 'scaleX(0)';
            }
        });
    }

    function syncActiveState(nextIndex) {
        slides.forEach((slide, index) => {
            const isActive = index === nextIndex;
            slide.classList.toggle('is-active', isActive);
            slide.setAttribute('aria-hidden', String(!isActive));
        });

        dots.forEach((dot, index) => {
            const isActive = index === nextIndex;
            dot.classList.toggle('is-active', isActive);
            dot.setAttribute('aria-current', String(isActive));
        });
    }

    function scheduleNextSlide() {
        clearAutoplayTimer();
        if (state.isUserPaused || !state.isViewportVisible) {
            return;
        }

        const remaining = Math.max(0, state.slideDurationMs - state.elapsedInSlideMs);
        state.autoplayTimeoutId = setTimeout(() => {
            const nextIndex = (state.currentIndex + 1) % slides.length;
            setActiveSlide(nextIndex, true);
        }, remaining);
    }

    function tickProgress() {
        if (!state.isUserPaused && state.isViewportVisible) {
            const now = performance.now();
            state.elapsedInSlideMs = Math.min(state.slideDurationMs, now - state.slideStartTimestamp);
            setDotProgress(state.currentIndex, state.elapsedInSlideMs / state.slideDurationMs);
        }

        state.progressRafId = requestAnimationFrame(tickProgress);
    }

    function startProgressLoop() {
        clearProgressRaf();
        state.progressRafId = requestAnimationFrame(tickProgress);
    }

    function setActiveSlide(nextIndex, resetProgress) {
        state.currentIndex = nextIndex;
        syncActiveState(nextIndex);

        if (resetProgress) {
            state.elapsedInSlideMs = 0;
        }

        state.slideStartTimestamp = performance.now() - state.elapsedInSlideMs;
        resetAllDotProgress();
        setDotProgress(state.currentIndex, state.elapsedInSlideMs / state.slideDurationMs);
        scheduleNextSlide();
    }

    function pauseFromSystem() {
        clearAutoplayTimer();
        if (state.isUserPaused) {
            return;
        }

        state.elapsedInSlideMs = Math.min(state.slideDurationMs, performance.now() - state.slideStartTimestamp);
        setDotProgress(state.currentIndex, state.elapsedInSlideMs / state.slideDurationMs);
    }

    function resumeFromSystem() {
        if (state.isUserPaused) {
            return;
        }

        state.slideStartTimestamp = performance.now() - state.elapsedInSlideMs;
        scheduleNextSlide();
    }

    function toggleUserPause() {
        state.isUserPaused = !state.isUserPaused;
        setPlayPauseUi(state.isUserPaused);

        if (state.isUserPaused) {
            pauseFromSystem();
        } else {
            resumeFromSystem();
        }
    }

    function attachEvents() {
        dots.forEach((dot) => {
            dot.addEventListener('click', (event) => {
                event.stopPropagation();
                const index = Number(dot.dataset.slideIndex);
                if (Number.isInteger(index)) {
                    setActiveSlide(index, true);
                }
            });
        });

        playPauseBtn.addEventListener('click', (event) => {
            event.stopPropagation();
            toggleUserPause();
        });

        hero.addEventListener('click', (event) => {
            if (event.target.closest('a, button, [role="button"], [role="tab"], input, select, textarea')) {
                return;
            }
            toggleUserPause();
        });

        interactiveElements.forEach((element) => {
            element.addEventListener('click', (event) => {
                event.stopPropagation();
            });
        });
    }

    function setupVisibilityObserver() {
        if (!('IntersectionObserver' in window)) {
            return;
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                const wasVisible = state.isViewportVisible;
                state.isViewportVisible = entry.intersectionRatio >= 0.5;

                if (wasVisible && !state.isViewportVisible) {
                    pauseFromSystem();
                } else if (!wasVisible && state.isViewportVisible) {
                    resumeFromSystem();
                }
            });
        }, {
            threshold: [0.5]
        });

        observer.observe(hero);
    }

    syncActiveState(0);
    setPlayPauseUi(false);
    setActiveSlide(0, true);
    startProgressLoop();
    attachEvents();
    setupVisibilityObserver();
})();
