document.addEventListener("DOMContentLoaded", () => {
    const processingBtn = document.getElementById("processing-btn");
    const digitalBtn = document.getElementById("financing-btn");

    const bigMenu = document.querySelector(".BigDropDown-Tray");
    const miniMenu = document.querySelector(".MiniDropDown-Tray");

    const searchIcon = document.querySelector(".desktop-SearchIcon");
    const searchBox = document.querySelector(".searchFieldBoxAndResults");
    const closeSearchBtn = document.querySelector(".close-searchFieldBar");

    /* ================= CORE CLOSE ================= */
    function closeAll() {
        bigMenu?.classList.remove("active");
        miniMenu?.classList.remove("active");
        searchBox?.classList.remove("active");

        processingBtn?.classList.remove("active");
        digitalBtn?.classList.remove("active");
        
        // Re-enable body scrolling
        document.body.style.overflow = "";
    }

    /* ================= SEARCH ================= */
    if (searchIcon && searchBox) {
        searchIcon.addEventListener("click", e => {
            e.stopPropagation();
            const isOpen = searchBox.classList.contains("active");
            closeAll();
            if (!isOpen) searchBox.classList.add("active");
        });
    }

    closeSearchBtn?.addEventListener("click", e => {
        e.stopPropagation();
        searchBox?.classList.remove("active");
    });

    /* ================= DESKTOP HOVER ================= */
    const isDesktopHover =
        window.matchMedia("(hover: hover) and (pointer: fine)").matches;

    if (isDesktopHover && processingBtn && digitalBtn && bigMenu && miniMenu) {

        function openProcessing() {
            closeAll();
            bigMenu.classList.add("active");
            processingBtn.classList.add("active");
            // Disable body scrolling
            document.body.style.overflow = "hidden";
        }

        function openDigital() {
            closeAll();
            miniMenu.classList.add("active");
            digitalBtn.classList.add("active");
            // Disable body scrolling
            document.body.style.overflow = "hidden";
        }

        processingBtn.addEventListener("mouseenter", openProcessing);
        digitalBtn.addEventListener("mouseenter", openDigital);

        function bindClose(trigger, menu) {
            function leave(e) {
                if (
                    !trigger.contains(e.relatedTarget) &&
                    !menu.contains(e.relatedTarget)
                ) {
                    closeAll();
                }
            }

            trigger.addEventListener("mouseleave", leave);
            menu.addEventListener("mouseleave", leave);
        }

        bindClose(processingBtn, bigMenu);
        bindClose(digitalBtn, miniMenu);

        document
            .querySelectorAll(
                ".mainMenu > li:not(#processing-btn):not(#financing-btn)"
            )
            .forEach(li => li.addEventListener("mouseenter", closeAll));
    }

    /* ================= CLICK SAFETY ================= */
    processingBtn?.addEventListener("click", e => e.stopPropagation());
    digitalBtn?.addEventListener("click", e => e.stopPropagation());

    bigMenu?.addEventListener("click", e => e.stopPropagation());
    miniMenu?.addEventListener("click", e => e.stopPropagation());
    searchBox?.addEventListener("click", e => e.stopPropagation());

    /* ================= GLOBAL CLOSE ================= */
    document.addEventListener("click", (e) => {
        // Don't interfere with home hero carousel
        if (e.target.closest("#home-hero")) return;
        
        closeAll();
    });
    document.addEventListener("keydown", e => {
        if (e.key === "Escape") closeAll();
    });
});
