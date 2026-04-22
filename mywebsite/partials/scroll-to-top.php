    <div class="screen-action-interface">

        <!-- Scroll To Top Button -->
        <button class="scroll-to-top" id="scrollTopBtn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon slim-long-up-arrow">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
            </svg>
        </button>    
    
        <!-- Facebook Messenger Go To Button -->
        <button class="facebook-messenger"  onclick="window.open('https://web.facebook.com/p/Optimum-Payment-Solutions-100082955451105/?_rdc=1&_rdr#')" aria-label="Open Messenger">
            <img src="<?= $base_url ?>/assets/images/logo/messenger.svg" alt="FB Messenger">
        </button>  

    </div>

    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/screen-action-interface.css">

    <script>
        const scrollBtn = document.getElementById("scrollTopBtn");
        let lastScrollTop = 0;
        let hideTimeout = null;

        // Hide button initially
        scrollBtn.style.display = "none";

        // Show button only when scrolling up
        window.addEventListener("scroll", () => {
            const scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
            const isScrollingUp = scrollTop < lastScrollTop;
            
            // Clear any existing timeout
            if (hideTimeout) {
                clearTimeout(hideTimeout);
                hideTimeout = null;
            }

            // Show button only when scrolling up AND scrolled down at least 50px
            if (isScrollingUp && scrollTop > 50) {
                scrollBtn.style.display = "block";
                
                // Auto-hide after 10 seconds
                hideTimeout = setTimeout(() => {
                    scrollBtn.style.display = "none";
                }, 10000);
            } 
            // Hide when scrolling down
            else if (!isScrollingUp) {
                scrollBtn.style.display = "none";
            }
            
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        });

        // Smooth scroll to top
        scrollBtn.addEventListener("click", () => {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });

    </script>

    <!-- Hide visibility until after scroll Y 100  to evade blocking content -->
    <script>
        document.addEventListener("scroll", () => {
            const element = document.querySelector(".screen-action-interface");

            if (window.scrollY >= 100) {
                element.classList.add("active");
            } else {
                element.classList.remove("active");
            }
            });
    </script>
