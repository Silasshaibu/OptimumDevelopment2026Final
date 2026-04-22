document.addEventListener("DOMContentLoaded", () => {

    /* ================= BODY SCROLL ================= */
    let scrollPosition = 0;
    const htmlElement = document.documentElement;

    function lockBody() {
        scrollPosition = window.scrollY || window.pageYOffset;
        
        // Calculate scrollbar width before hiding it
        const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
        
        // Temporarily disable smooth scrolling
        htmlElement.style.scrollBehavior = 'auto';
        
        document.body.style.overflow = 'hidden';
        document.body.style.position = 'fixed';
        document.body.style.top = `-${scrollPosition}px`;
        document.body.style.width = '100%';
        document.body.style.paddingRight = `${scrollbarWidth}px`; // Compensate for scrollbar
        document.body.classList.add("menu-open");
    }

    function unlockBody() {
        document.body.classList.remove("menu-open");
        document.body.style.overflow = '';
        document.body.style.position = '';
        document.body.style.top = '';
        document.body.style.width = '';
        document.body.style.paddingRight = ''; // Remove padding compensation
        
        // Restore scroll position immediately
        requestAnimationFrame(() => {
            window.scrollTo(0, scrollPosition);
        });
        
        // Re-enable smooth scrolling after a short delay
        setTimeout(() => {
            htmlElement.style.scrollBehavior = '';
        }, 50);
    }

    /* ================= MOBILE MENU ================= */
    const hamburger = document.querySelector("svg.icon.hamburger");
    const closeIcon = document.querySelector("svg.icon.close-MobileDropDownMenu");
    const mobileMenu = document.querySelector("nav.main-menu.mobileDropDown");
    const hamburgerContainer = document.querySelector(".mobile-Section .icon");

    function closeMenu() {
        if (!mobileMenu) return;

        mobileMenu.classList.remove("active");
        hamburger?.classList.add("active");
        closeIcon?.classList.remove("active");
        unlockBody();
    }

    if (hamburger && closeIcon && mobileMenu) {

        function toggleMenu(e) {
            // Capture scroll position FIRST, before anything else happens
            const currentScroll = scrollPosition || window.scrollY || window.pageYOffset;
            
            console.log('toggleMenu called!', 'Scroll at function start:', currentScroll);
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            const isOpen = mobileMenu.classList.contains("active");

            mobileMenu.classList.toggle("active", !isOpen);
            hamburger.classList.toggle("active", isOpen);
            closeIcon.classList.toggle("active", !isOpen);

            if (!isOpen) {
                // Opening menu - use the scroll position we captured
                scrollPosition = currentScroll;
                lockBody();
            } else {
                // Closing menu
                unlockBody();
            }
            
            return false;
        }

        // Listen on the span container which wraps both SVGs
        if (hamburgerContainer) {
            // Add a capturing listener that runs BEFORE any other handlers
            hamburgerContainer.addEventListener("click", function(e) {
                // Only save scroll position if menu is currently CLOSED (about to open)
                // When menu is open, body is fixed and window.scrollY is 0, so don't overwrite!
                const isOpen = mobileMenu.classList.contains("active");
                if (!isOpen) {
                    // Menu is closed, about to open - capture real scroll position
                    const capturedScroll = window.scrollY || window.pageYOffset;
                    scrollPosition = capturedScroll;
                }
            }, true);
            
            // Add our toggle handler
            hamburgerContainer.addEventListener("click", toggleMenu, false);
        }
        
        // Also add to individual SVGs as backup
        hamburger.addEventListener("click", function(e) {
            toggleMenu(e);
        });
        
        closeIcon.addEventListener("click", function(e) {
            toggleMenu(e);
        });

        document.addEventListener("keydown", e => {
            if (e.key === "Escape") {
                closeMenu();
            }
        });
    }

    /* ================= MOBILE ACCORDION ================= */
    document.querySelectorAll(".parent-toggle").forEach(parent => {
        parent.addEventListener("click", () => {
            const ul = parent.parentElement.querySelector("ul");
            if (!ul) return;

            const isOpen = ul.classList.contains("show");

            document.querySelectorAll(".parent-toggle").forEach(p => {
                if (p !== parent) {
                    p.classList.remove("open");
                    p.parentElement
                        .querySelectorAll("ul")
                        .forEach(u => u.classList.remove("show"));
                }
            });

            parent.classList.toggle("open", !isOpen);
            ul.classList.toggle("show", !isOpen);
        });
    });

    document.querySelectorAll(".child-toggle").forEach(child => {
        child.addEventListener("click", e => {
            e.stopPropagation();

            const ul = child.parentElement.querySelector("ul");
            if (!ul) return;

            const isOpen = child.classList.contains("active");

            child.parentElement.parentElement
                .querySelectorAll(".child-toggle")
                .forEach(c => {
                    if (c !== child) {
                        c.classList.remove("active");
                        c.parentElement.querySelector("ul")?.classList.remove("show");
                    }
                });

            child.classList.toggle("active", !isOpen);
            ul.classList.toggle("show", !isOpen);
        });
    });

    /* ================= RESPONSIVE BUTTON ================= */
    function updateMobileView() {
        const shopBtn = document.getElementById("shopBtn");
        const searchLi = document.getElementById("searchSectionMain");
        const mobileSection = document.querySelector(".mobile-Section");
        const originalParent = document.querySelector(".searchAndstore-NavSection");

        if (!shopBtn) return;

        if (window.innerWidth <= 1200) {
            shopBtn.textContent = "Store";
            shopBtn.classList.add("btn-primary-sm");
            shopBtn.classList.remove("btn-primary");

            if (searchLi && mobileSection && !mobileSection.contains(searchLi)) {
                mobileSection.appendChild(searchLi);
            }
        } else {
            shopBtn.textContent = "Shop for Supplies";
            shopBtn.classList.add("btn-primary");
            shopBtn.classList.remove("btn-primary-sm");

            if (searchLi && originalParent && !originalParent.contains(searchLi)) {
                originalParent.appendChild(searchLi);
            }

            // 🔧 Safety: close mobile menu if resizing to desktop
            if (mobileMenu?.classList.contains("active")) {
                closeMenu();
            }
        }
    }

    updateMobileView();
    window.addEventListener("resize", updateMobileView);
});
