// Search functionality
(function () {
    const searchIcon = document.querySelector('.topnavbar-search');
    const searchOuter = document.querySelector('.sr-outer');
    const srInput = document.getElementById('srInput');
    const srClose = document.getElementById('srClose');
    const results = document.getElementById('srResults');
    const sbThumb = document.getElementById('srSbThumb');
    const sbTrack = document.getElementById('srSbTrack');
    const btnUp = document.getElementById('srScrollUp');
    const btnDown = document.getElementById('srScrollDown');

    // Toggle search section
    searchIcon.addEventListener('click', function (e) {
        e.preventDefault();
        const isVisible = searchOuter.style.display === 'block';
        searchOuter.style.display = isVisible ? 'none' : 'block';
        if (!isVisible) {
            // Focus on search input when opening
            setTimeout(() => srInput.focus(), 100);
        }
    });

    // Close search section when close button is clicked
    srClose.addEventListener('click', function () {
        searchOuter.style.display = 'none';
        srInput.value = '';
    });

    /* ---------- thumb geometry ---------- */
    function thumbH() {
        var ratio = results.clientHeight / results.scrollHeight;
        return Math.max(24, Math.round(sbTrack.clientHeight * ratio));
    }

    function updateScrollbar() {
        var h = thumbH();
        var maxScroll = results.scrollHeight - results.clientHeight;
        var maxTop = sbTrack.clientHeight - h;
        var top = maxScroll > 0 ? (results.scrollTop / maxScroll) * maxTop : 0;
        sbThumb.style.height = h + 'px';
        sbThumb.style.top = top + 'px';
        btnUp.disabled = results.scrollTop <= 0;
        btnDown.disabled = results.scrollTop >= maxScroll - 1;
    }

    /* ---------- sync on native scroll ---------- */
    results.addEventListener('scroll', updateScrollbar);

    /* ---------- arrow buttons ---------- */
    btnUp.addEventListener('click', function () {
        results.scrollBy({ top: -84, behavior: 'smooth' });
    });
    btnDown.addEventListener('click', function () {
        results.scrollBy({ top: 84, behavior: 'smooth' });
    });

    /* ---------- thumb drag ---------- */
    var dragging = false;
    var dragStartY = 0;
    var dragStartScroll = 0;

    sbThumb.addEventListener('mousedown', function (e) {
        dragging = true;
        dragStartY = e.clientY;
        dragStartScroll = results.scrollTop;
        document.body.style.userSelect = 'none';
        e.preventDefault();
    });

    document.addEventListener('mousemove', function (e) {
        if (!dragging) return;
        var delta = e.clientY - dragStartY;
        var maxTop = sbTrack.clientHeight - thumbH();
        var scrollRatio = maxTop > 0 ? delta / maxTop : 0;
        results.scrollTop = dragStartScroll + scrollRatio * (results.scrollHeight - results.clientHeight);
    });

    document.addEventListener('mouseup', function () {
        if (dragging) {
            dragging = false;
            document.body.style.userSelect = '';
        }
    });

    /* ---------- track click (jump) ---------- */
    sbTrack.addEventListener('click', function (e) {
        if (e.target !== sbTrack) return;
        var rect = sbTrack.getBoundingClientRect();
        var ratio = (e.clientY - rect.top) / sbTrack.clientHeight;
        results.scrollTop = ratio * (results.scrollHeight - results.clientHeight);
    });

    /* ---------- mouse wheel ---------- */
    results.addEventListener('wheel', function (e) {
        e.preventDefault();
        results.scrollTop += e.deltaY;
    }, { passive: false });

    /* ---------- init ---------- */
    updateScrollbar();
    window.addEventListener('resize', updateScrollbar);
})();

/* Star rating interaction for testimonial form */
(function () {
    var container = document.getElementById('ratingStars');
    if (!container) return; // Exit if rating stars don't exist on this page

    var labels = container.querySelectorAll('label');
    var currentRating = 0;

    function updateStars(rating) {
        labels.forEach(function (lbl) {
            var val = parseInt(lbl.getAttribute('data-value'));
            if (val <= rating) {
                lbl.classList.add('active');
            } else {
                lbl.classList.remove('active');
            }
        });
    }

    labels.forEach(function (lbl) {
        lbl.addEventListener('click', function () {
            currentRating = parseInt(this.getAttribute('data-value'));
            updateStars(currentRating);
        });
        lbl.addEventListener('mouseenter', function () {
            updateStars(parseInt(this.getAttribute('data-value')));
        });
    });

    container.addEventListener('mouseleave', function () {
        updateStars(currentRating);
    });
})();

/* Marquee control for partner logos */
(function () {
    // Default marquee state - set to false to stop animation
    var marquee = false;

    // Function to check if marquee should be active based on screen size
    function shouldMarqueeBeActive() {
        return window.innerWidth <= 986;
    }

    // Function to start marquee animation
    function startMarquee() {
        if (shouldMarqueeBeActive()) {
            var rows = document.querySelectorAll('.partners-section__row');
            rows.forEach(function(row) {
                row.classList.add('marquee-active');
            });
        }
    }

    // Function to stop marquee animation
    function stopMarquee() {
        var rows = document.querySelectorAll('.partners-section__row');
        rows.forEach(function(row) {
            row.classList.remove('marquee-active');
        });
    }

    // Function to update marquee state
    function updateMarquee() {
        if (marquee && shouldMarqueeBeActive()) {
            startMarquee();
        } else {
            stopMarquee();
        }
    }

    // Initial check on page load
    updateMarquee();

    // Update on window resize
    window.addEventListener('resize', updateMarquee);

    // Expose functions globally for external control
    window.marqueeControl = {
        start: function() {
            marquee = true;
            updateMarquee();
        },
        stop: function() {
            marquee = false;
            updateMarquee();
        },
        toggle: function() {
            marquee = !marquee;
            updateMarquee();
        },
        isActive: function() {
            return marquee;
        }
    };
})();