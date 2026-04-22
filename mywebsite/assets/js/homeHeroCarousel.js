
/* ===============================
   HOME HERO CAROUSEL SCRIPT
   (FIXES 2 → 6 APPLIED)
   =============================== */

const root = document.querySelector(".homeHero-carousel");
const wrapper = root.querySelector(".carousel-wrapper");
const indicator = root.querySelector(".carousel-indicator");

let slides = root.querySelectorAll(".carousel-wrapper .slide");

let index = 1;
let interval = null;
const autoSlideTime = 3000;

/* ===============================
   CLONE FIRST & LAST SLIDES
   =============================== */
const firstClone = slides[0].cloneNode(true);
const lastClone = slides[slides.length - 1].cloneNode(true);

firstClone.classList.add("clone");
lastClone.classList.add("clone");

wrapper.appendChild(firstClone);
wrapper.insertBefore(lastClone, slides[0]);

slides = root.querySelectorAll(".carousel-wrapper .slide");

let slideWidth = slides[0].clientWidth;
let dragThreshold = slideWidth * 0.2;

/* ===============================
   INITIAL POSITION
   =============================== */
wrapper.style.transform = `translateX(-${slideWidth * index}px)`;

/* ===============================
   INDICATOR SETUP
   =============================== */
const realSlideCount = slides.length - 2;

for (let i = 0; i < realSlideCount; i++) {
    const dot = document.createElement("span");
    dot.classList.add("dot");
    dot.dataset.index = i + 1;
    dot.setAttribute("role", "button");
    dot.setAttribute("aria-label", `Go to slide ${i + 1}`);

    const progress = document.createElement("span");
    progress.classList.add("progress");

    dot.appendChild(progress);
    indicator.appendChild(dot);
}

function resetProgressBars() {
    const bars = indicator.querySelectorAll(".progress");
    bars.forEach(bar => {
        bar.style.animation = "none";
        bar.offsetHeight;
        bar.style.animation = "";
    });
}

function startProgressBar() {
    // if (window.innerWidth > 768) return;

    const active = indicator.querySelector(".dot.active .progress");
    if (!active) return;

    active.style.animationDuration = `${autoSlideTime}ms`;
}

function updateIndicator() {
    const dots = indicator.querySelectorAll(".dot");
    dots.forEach(dot => dot.classList.remove("active"));

    let activeIndex = index - 1;
    if (activeIndex < 0) activeIndex = realSlideCount - 1;
    if (activeIndex >= realSlideCount) activeIndex = 0;

    dots[activeIndex].classList.add("active");

    resetProgressBars();
    startProgressBar();
}

updateIndicator();

/* ===============================
   SLIDE CONTROLS
   =============================== */
function nextSlide() {
    if (index >= slides.length - 1) return;
    index++;
    moveToIndex();
}

function prevSlide() {
    if (index <= 0) return;
    index--;
    moveToIndex();
}

function moveToIndex() {
    wrapper.style.transition = "transform 0.5s ease-in-out";
    wrapper.style.transform = `translateX(-${slideWidth * index}px)`;
    updateIndicator();
}

/* ===============================
   INFINITE LOOP FIX
   =============================== */
wrapper.addEventListener("transitionend", () => {
    if (!slides[index].classList.contains("clone")) return;

    wrapper.style.transition = "none";

    if (index === 0) {
        index = slides.length - 2;
    } else if (index === slides.length - 1) {
        index = 1;
    }

    wrapper.style.transform = `translateX(-${slideWidth * index}px)`;
    updateIndicator();
});

/* ===============================
   AUTOPLAY
   =============================== */
function startAutoSlide() {
    stopAutoSlide();
    interval = setInterval(nextSlide, autoSlideTime);
}

function stopAutoSlide() {
    clearInterval(interval);
}

// Removed hover pause - carousel continues even when hovering




/* ===============================
   DOT CLICK NAVIGATION (FIX #2)
   =============================== */
indicator.addEventListener("click", (e) => {
    const dot = e.target.closest(".dot");
    if (!dot || !dot.dataset.index) return;
    
    e.stopPropagation();

    index = Number(dot.dataset.index);
    moveToIndex();
    
    // Reset the auto-slide timer to prevent conflict
    stopAutoSlide();
    startAutoSlide();
});

/* ===============================
   RESPONSIVE RESIZE (FIX #3)
   =============================== */
window.addEventListener("resize", () => {
    slideWidth = slides[0].clientWidth;
    dragThreshold = slideWidth * 0.2;
    wrapper.style.transition = "none";
    wrapper.style.transform = `translateX(-${slideWidth * index}px)`;
    syncTranslate();
});

/* ===============================
   PREVENT SLIDE CONTENT CLICKS FROM AFFECTING CAROUSEL
   =============================== */
wrapper.addEventListener("click", (e) => {
    // Only allow dot clicks and drag interactions
    // Prevent clicks on slide content (buttons, images, text) from affecting carousel
    if (!e.target.closest(".carousel-indicator")) {
        e.stopPropagation();
    }
});

/* ===============================
   DRAG / SWIPE SUPPORT (FIX #4 & #6)
   =============================== */
let isDragging = false;
let startX = 0;
let currentTranslate = 0;
let prevTranslate = 0;
let animationID = null;

function getPositionX(e) {
    return e.type.includes("mouse") ? e.pageX : e.touches[0].clientX;
}

function setSliderPosition() {
    wrapper.style.transform = `translateX(${currentTranslate}px)`;
}

function animation() {
    if (isDragging) {
        setSliderPosition();
        requestAnimationFrame(animation);
    }
}

function dragStart(e) {
    // Don't start drag on interactive elements (buttons, links, inputs)
    if (e.target.closest('button, a, input, select, textarea')) {
        return;
    }
    
    isDragging = true;
    startX = getPositionX(e);
    prevTranslate = -slideWidth * index;
    wrapper.style.transition = "none";
    animationID = requestAnimationFrame(animation);
    
    // Attach listeners only when dragging starts
    window.addEventListener("mousemove", dragMove);
    window.addEventListener("mouseup", dragEnd);
    wrapper.addEventListener("touchmove", dragMove, { passive: true });
    wrapper.addEventListener("touchend", dragEnd);
}

function dragMove(e) {
    if (!isDragging) return;
    e.preventDefault();
    const currentPosition = getPositionX(e);
    currentTranslate = prevTranslate + currentPosition - startX;
}

function dragEnd(e) {
    if (!isDragging) return;
    
    // Remove listeners when dragging ends
    window.removeEventListener("mousemove", dragMove);
    window.removeEventListener("mouseup", dragEnd);
    wrapper.removeEventListener("touchmove", dragMove);
    wrapper.removeEventListener("touchend", dragEnd);
    
    cancelAnimationFrame(animationID);
    isDragging = false;

    const movedBy = currentTranslate - prevTranslate;
    
    // Only update if there was significant movement (not just a click)
    const hadSignificantMovement = Math.abs(movedBy) > 5; // 5px threshold for click vs drag

    if (hadSignificantMovement) {
        if (movedBy < -dragThreshold) index++;
        else if (movedBy > dragThreshold) index--;

        index = Math.max(0, Math.min(index, slides.length - 1));

        moveToIndex();
        syncTranslate();
    } else {
        // Just a click, not a drag - restore position without updating indicators
        wrapper.style.transition = "transform 0.3s ease-in-out";
        wrapper.style.transform = `translateX(-${slideWidth * index}px)`;
        syncTranslate();
    }
}

wrapper.addEventListener("mousedown", dragStart);
wrapper.addEventListener("touchstart", dragStart, { passive: true });

/* Prevent image dragging */
wrapper.querySelectorAll("img").forEach(img => {
    img.addEventListener("dragstart", e => e.preventDefault());
});

/* ===============================
   SYNC HELPERS
   =============================== */
function syncTranslate() {
    prevTranslate = -slideWidth * index;
    currentTranslate = prevTranslate;
}

syncTranslate();

/* ===============================
   START
   =============================== */
startAutoSlide();