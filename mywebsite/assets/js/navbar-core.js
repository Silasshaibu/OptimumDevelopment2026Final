document.addEventListener("DOMContentLoaded", () => {

    /* ================= STICKY NAVBAR ================= */
    const navbar = document.querySelector(".navbar");

    // Initialize --scrollY CSS variable
    document.documentElement.style.setProperty('--scrollY', `${window.pageYOffset}px`);

    if (navbar) {
        const stickyOffset = navbar.offsetTop;

        window.addEventListener("scroll", () => {
            // Don't update scrollY if menu is open (body is locked)
            if (document.body.classList.contains('menu-open')) {
                return;
            }
            
            // Update CSS variable for scroll position
            const scrollY = window.pageYOffset || window.scrollY;
            document.documentElement.style.setProperty('--scrollY', `${scrollY}px`);
            
            if (window.pageYOffset > stickyOffset) {
                navbar.classList.add("navbar--sticky");
            } else {
                navbar.classList.remove("navbar--sticky");
            }
        });
    }

    /* ================= ACTIVE LINK (URL BASED) ================= */
    const navLinks = document.querySelectorAll(".one > li > a");

    const currentPath = window.location.pathname
        .replace(/\/$/, "")   // remove trailing slash
        .split("/")
        .pop();

    navLinks.forEach(link => {
        const href = link.getAttribute("href");

        if (!href) return;

        const cleanHref = href.replace(/\/$/, "").split("/").pop();

        if (
            cleanHref === currentPath ||
            (currentPath === "" && cleanHref === "home")
        ) {
            link.parentElement.classList.add("active");
        }
    });

});
