<?php require_once __DIR__ . '/../config.php'; ?>


    <div class="nav-hover-zone">
        <!-- NavBar All Covered Start -->
        <header class="navbar header" role="navigation">

            <!-- Mobile Hamburger -->
            <ul class="mobile-Section">
                <li>
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="icon hamburger active">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon close-MobileDropDownMenu">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"></path>
                        </svg>
                    </span>
                </li>
            </ul>

            <!-- Logo -->
            <ul class="LogoSection-with-MoreMobileTemporalButtons">
                <li class="Logo-Action">
                    <a href="<?= $base_url ?>/">

                        <img src="<?= $base_url ?>/assets/images/logo/optimum-navLogo.webp"
                            alt="Optimum Payments"
                            width="120px" height="auto"> 
                    </a>
                </li>
            </ul>

            <!-- Main Menu - Desktop -->
            <ul class="one mainMenu">
                
                <li><a href="<?= $base_url ?>/">Home</a></li>
                <li><a href="<?= $base_url ?>/promo">Promo</a></li>
                <li id="processing-btn"><a href="javascript:void(0)">Processing Solutions <span class=""> 
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon downCaret">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>

        </span></a></li>
                <li id="financing-btn"><a href="#" onclick="event.preventDefault()">Digital Services <span class=""> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon downCaret">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg> </span></a></li>
                <li><a href="<?= $base_url ?>/business-financing">Business Financing</a></li>
                <li class="about-us"><a href="<?= $base_url ?>/about">About Us</a></li>
                <li class="contact-us"><a href="<?= $base_url ?>/contact-us">Contact Us</a></li>
            </ul>

            <!-- Search + Store -->
            <ul class="searchAndstore-NavSection">
                
                <li id="searchSectionMain">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="icon desktop-SearchIcon">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="m21 21-5.197-5.197M15.803 15.803A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </span>

                    <div class="searchFieldBoxAndResults">
                       <div>
                            
                            <form class="mainNavSearchFormField" method="GET" action="<?= $base_url ?>/main/search/search.php">
                                <input class="searchFieldInput" type="text" name="q" placeholder="Search for supplies.." autocomplete="off">
                                <!-- default search scope -->
                                <input type="hidden" name="type" value="all">

                                <button type="button" class="close-searchButton Main"> 
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon close-searchFieldBar">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>                            
                                </button>
                            </form>
                       </div>
                        
                       <div class="liveSearchResults"></div>
                    </div>
                </li>

                <li>
                    <button id="shopBtn" class="btn-primary" onclick="window.location.href='<?= $base_url ?>/shop'">Shop for Supplies</button>
                </li>
                
            </ul>

            

            </header>


        <!-- Mobile Menu Navigation start -->
        <nav class="main-menu mobileDropDown">
            <ul>
                <!-- Top links -->
                <li><a href="<?= $base_url ?>/">Home</a></li>
                <li><a href="<?= $base_url ?>/promo">Promo</a></li>

                <!-- Processing Solutions Parent - Dynamically Generated -->
                <li class="dropdown">
                    <a class="parent-toggle">Processing Solutions
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="top-caret">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                    </a>
                    <ul class="child-dropdowns" id="mobileProcessingMenu">
                        <!-- Will be populated by JavaScript from menuData -->
                    </ul>
                </li>

                <!-- Digital Services -->
                <li class="dropdown">
                    <a class="parent-toggle">Digital Services
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="top-caret">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </a>
                    <ul class="service-cards">
                        <li>
                            <a href="<?= $base_url ?>/digital-services">
                                <div class="mobileMenu-service-card">
                                    <img src="<?= $base_url ?>/assets/images/MobileMenuImages/Website_Design.webp" alt="Website Design">
                                    <h3>Website Design</h3>
                                    <p class="mobileService-Description">Preimum designs at your fingertips</p>
                                    <p class="mobileMenu--special-link">Explore <span class="service-card-link"> > </span></p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $base_url ?>/digital-services">
                                <div class="mobileMenu-service-card">
                                    <img src="<?= $base_url ?>/assets/images/MobileMenuImages/3dModelingForPrints.webp" alt="3D Printing">
                                    <h3>3D Printing</h3>
                                    <p class="mobileService-Description">1-stop shopping for all your 3D-printed needs</p>
                                    <p class="mobileMenu--special-link">Explore <span class="service-card-link"> > </span></p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $base_url ?>/digital-services">
                                <div class="mobileMenu-service-card">
                                    <img src="<?= $base_url ?>/assets/images/MobileMenuImages/Branding.webp" alt="Branding">
                                    <h3>Branding</h3>
                                    <p class="mobileService-Description">We can handle all form of your branding needs</p>
                                    <p class="mobileMenu--special-link">Explore <span class="service-card-link"> > </span></p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $base_url ?>/digital-services">
                                <div class="mobileMenu-service-card">
                                    <img src="<?= $base_url ?>/assets/images/MobileMenuImages/SocialMediaMarketing-01.webp" alt="Social Media Marketing">
                                    <h3>Social Media Marketing</h3>
                                    <p class="mobileService-Description">Lets market your product on socials</p>
                                    <p class="mobileMenu--special-link">Explore <span class="service-card-link"> > </span></p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Other menus -->
                <li class="dropdown"><a class="parent-toggle">Business Financing
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="top-caret">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg></a>
                    <ul class="service-cards singular">
                        <li>
                            <a href="<?= $base_url ?>/business-financing">
                                <div class="mobileMenu-service-card singular">
                                    <img src="<?= $base_url ?>/assets/images/rokBusinessFinancing/rokfinancial.webp"></img>
                                    <h3>Get Funding Today</h3>
                                    <p class="mobileService-Description">Preimum designs at your fingertips</p>
                                    <p class="mobileMenu--special-link">Explore <span class="service-card-link"> > </span></p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- About Us -->
                <li class="dropdown about-us-dropdown-mobile"><a class="parent-toggle">About Us
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="top-caret">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg></a>
                    <ul class="service-cards singular">
                        <li>
                            <a href="<?= $base_url ?>/about">
                                <div class="mobileMenu-service-card singular about-us-description">
                                    <p class="mobileService-Description">We are here to help your business accept credit cards in the most secure, efficient and economical way possible.
                                        </p>
                                        <p class="mobileService-Description">Optimum Payment Solutions is a premium provider of electronic transaction processing and ATM Placement.
                                        </p>
                                    <p class="mobileMenu--special-link">Get To Know Us More <span class="service-card-link"> > </span></p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <!-- Social Buttons -->
            <div class="mobile-Social-Buttons-section">
                <li class="social-icon-set">
                    <span class="mobileMenu-footer-social-icons">
                        <a href="mailto:info@optimumpayments.com" target="_blank"><img src="<?= $base_url ?>/assets/svgs/mail-social.svg" alt=""></a>
                    </span>
                    <span class="mobileMenu-footer-social-icons">
                        <a href="https://web.facebook.com/p/Optimum-Payment-Solutions-100082955451105/?_rdc=1&_rdr#"><img src="<?= $base_url ?>/assets/svgs/facebook-social.svg" alt=""></a>
                    </span>
                    <span class="mobileMenu-footer-social-icons">
                        <a href="https://web.facebook.com/p/Optimum-Payment-Solutions-100082955451105/?_rdc=1&_rdr#"><img src="<?= $base_url ?>/assets/svgs/tiktok-social.svg" alt=""></a>
                    </span>
                </li>

                <li>
                    <p class="copyright-foot-mobileMenu"> © Copyright <?php echo date('Y'); ?>
                        <strong> Optimum Payments LLC </strong> All Rights Reserved
                    </p>
                </li>
            </div>
            
            
        </nav>
        <!-- Mobile Menu NavBar End -->




        <!-- Processing Solution Mega Menu DropDown Div -->
        <div class="BigDropDown-Tray">

            <!-- LEFT MENU -->
            <ul class="processingSolutionDropDown-1st-Level" id="menu"></ul>

            <!-- GRID -->
            <div class="grid-space-area" id="grid"></div>

        </div>

        <!-- ================= MINI MEGA MENU START================= -->
        <div class="MiniMegaMenu MiniDropDown-Tray">
            <div class="mini-menu-footer">
                <a href="<?= $base_url ?>/digital-services" class="btn-learn-more">
                    Learn More
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="icon arrow-right-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
            </div>
            <div class="mini-services-grid" id="miniServicesGrid"></div>
        </div>
        <!-- ================= MINI MEGA MENU END================= -->


    </div>

        
        <!-- Processing solution Mega Menu Script Start -->
        <script>
            /* ================= DATA ================= */
            const menuData = [
            {
                label: "Full service fine dining",
                products: [
                {
                    name: "Union POS",
                    description: "Manage order, sales, and payments in one place",
                    image: "<?= $base_url ?>/assets/images/MobileMenuImages/UnionPOS-white.webp",
                    href: "<?= $base_url ?>/union"
                },
                {
                    name: "Clover",
                    description: "Do what you do better with the world's smartest POS system",
                    image: "<?= $base_url ?>/assets/images/MobileMenuImages/CloverFlex_MobileNav.webp",
                    href: "<?= $base_url ?>/clover-flex"
                },
                {
                    name: "Tabit",
                    description: "Imprvoved Sales and protect profits by leveraging mobile connectivity",
                    image: "<?= $base_url ?>/assets/images/MobileMenuImages/Tabit-var-1.webp",
                    href: "<?= $base_url ?>/tabit"
                }
                ]
            },

            {
                label: "QSR and Food Trucks",
                products: [
                {
                    name: "Clover",
                    description: "Fast, flexible POS built for quick service environments",
                    image: "<?= $base_url ?>/assets/images/MobileMenuImages/CloverSolo_MobileNav.webp",
                    href: "<?= $base_url ?>/clover-mini"
                },
                {
                    name: "Swipe Simple",
                    description: "For Food and Beverage merchants",
                    image: "<?= $base_url ?>/assets/images/MobileMenuImages/SwipeSimple_Register.webp",
                    href: "<?= $base_url ?>/swipe-simple"
                },
                {
                    name: "Valor",
                    description: "The ultimate all-in-one",
                    image: "<?= $base_url ?>/assets/images/MobileMenuImages/ValorVP800.webp",
                    href: "<?= $base_url ?>/valor-vl100"
                }
                ]
            },

            {
                label: "Bars / Night Clubs / High Volume",
                products: [
                {
                    name: "Union POS",
                    description: "Fast, flexible POS built for quick service environments",
                    image: "<?= $base_url ?>/assets/images/MobileMenuImages/UnionPOS-02.webp",
                    href: "<?= $base_url ?>/union"
                }
                
                ]
            },

            {
                label: "Retail / Liquor / Smoke Shops",
                products: [
                {
                    name: "OctoPOS",
                    description: "Fast, flexible POS built for quick service environments",
                    image: "<?= $base_url ?>/assets/images/MobileMenuImages/OctoPOS.webp",
                    href: "<?= $base_url ?>/octopos"
                },
                
                {
                    name: "Clover",
                    description: "A dual-screen point-of-sale system that does it all.",
                    image: "<?= $base_url ?>/assets/images/MobileMenuImages/CloverDuo_MobileNav.webp",
                    href: "<?= $base_url ?>/clover-station-duo"
                },
                {
                    name: "Swipe Simple",
                    description: "Easy-to-use payment solutions for small businesses.",
                    image: "<?= $base_url ?>/assets/images/MobileMenuImages/SwipeSimple-03.webp",
                    href: "<?= $base_url ?>/swipe-simple#"
                }
                ,
                {
                    name: "Valor",
                    description: "The innovative countertop solution",
                    image: "<?= $base_url ?>/assets/images/MobileMenuImages/ValorVP100.webp",
                    href: "<?= $base_url ?>/valorVP550"
                }
                ]
            },

            {
                label: "Medical",
                products: [
                {
                    name: "Practice Management Bridge",
                    description:
                    "Keeping your patients and your practice healthy requires a partner who understands your needs and technology that simplifies the day-to-day",
                    image: "<?= $base_url ?>/assets/images/MobileMenuImages/Rectangel-Medical-02.webp",
                    href: "<?= $base_url ?>/rectangle"
                }
                ]
            },

            {
                label: "Contractors / Online Payments / Mobile",
                products: [
                {
                    name: "Hyfin",
                    description: "The payment platform that saves you time, money and gets you paid fast!",
                    image: "<?= $base_url ?>/assets/images/MobileMenuImages/Hyfin-02.webp",
                    href: "<?= $base_url ?>/hyfin"
                },
                {
                    name: "NMI",
                    description: "A Customizable Payments and All-in-one Payments Solution",
                    image: "<?= $base_url ?>/assets/images/MobileMenuImages/NMI-04.webp",
                    href: "<?= $base_url ?>/nmi"
                },
                {
                    name: "Clover",
                    description: "A Clover for every small business",
                    image: "<?= $base_url ?>/assets/images/MobileMenuImages/CloverSolo_MobileNav.webp",
                    href: "<?= $base_url ?>/clover-station-solo"
                },
                {
                    name: "Valor",
                    description: "The complete portable solution",
                    image: "<?= $base_url ?>/assets/images/MobileMenuImages/ValorVP550.webp",
                    href: "<?= $base_url ?>/valorVP550"
                }
                ]
            },

            {
                label: "Need a Basic Setup?",
                products: [
                {
                    name: "Terminal Options",
                    description:
                    "Used by small businesses across restaurants, retail, and the service industry",
                    image: "<?= $base_url ?>/assets/images/MobileMenuImages/TerminalOptions.webp",
                    href: "<?= $base_url ?>/terminal"
                }
                ]
            }
            ];

            /* ================= ELEMENTS ================= */
            const menu = document.getElementById("menu");
            const grid = document.getElementById("grid");

            /* ================= BUILD MENU ================= */
            menuData.forEach((item, index) => {
            const li = document.createElement("li");
            li.textContent = item.label;
            li.dataset.index = index;
            if (index === 0) li.classList.add("active");
            menu.appendChild(li);
            });

            /* ================= HEIGHT CALC ================= */
            function syncGridHeight() {
            const items = menu.querySelectorAll("li");
            if (!items.length) return;

            const style = getComputedStyle(items[0]);

            const singleHeight =
                parseFloat(style.lineHeight) +
                parseFloat(style.paddingTop) +
                parseFloat(style.paddingBottom) +
                parseFloat(style.borderBottomWidth);

            grid.style.maxHeight = (singleHeight * items.length) + "px";
            }

            /* ================= RENDER GRID ================= */
            function renderGrid(index) {
            grid.innerHTML = "";

            menuData[index].products.forEach(product => {
                const card = document.createElement("a");
                card.className = "product-grid-item";
                card.href = product.href;

                card.innerHTML = `
                <img
                    class="product-image"
                    src="${product.image}"
                    alt="${product.name}"
                    loading="lazy"
                />

                <div class="product-details">
                    <h3>${product.name}</h3>
                    <p>${product.description}</p>
                </div>
                `;

                grid.appendChild(card);
            });

            grid.scrollTop = 0;
            }




            

            /* ================= EVENTS ================= */
            menu.addEventListener("mouseenter", e => {
            if (e.target.tagName !== "LI") return;

            menu.querySelectorAll("li").forEach(li => li.classList.remove("active"));
            e.target.classList.add("active");

            renderGrid(e.target.dataset.index);
            }, true);

            /* ================= INIT ================= */
            window.addEventListener("load", () => {
            syncGridHeight();
            renderGrid(0);
            });

            window.addEventListener("resize", syncGridHeight);

        </script>
        

        <script>
            (function injectMegaMenuCarets() {

            const menuItems = document.querySelectorAll(
                ".processingSolutionDropDown-1st-Level > li"
            );

            if (!menuItems.length) return;

            const svgMarkup = `
                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="right-caret-desktop-mega-menu"
                    aria-hidden="true">
                <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            `;

            menuItems.forEach(li => {
                // Prevent duplicate injection
                if (li.querySelector(".right-caret-desktop-mega-menu")) return;

                li.insertAdjacentHTML("beforeend", svgMarkup);
            });

            })();
        </script>
        <!-- Processing Solution Mega Menu Script End -->

       
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            if (!window.matchMedia("(hover: hover) and (pointer: fine)").matches) return;

            const processingBtn = document.getElementById("processing-btn");
            const digitalBtn = document.getElementById("financing-btn");
            const bigMenu = document.querySelector(".BigDropDown-Tray");
            const miniMenu = document.querySelector(".MiniDropDown-Tray");

            function closeMenus() {
            bigMenu.classList.remove("active");
            miniMenu.classList.remove("active");
            processingBtn.classList.remove("active");
            digitalBtn.classList.remove("active");
            }

            function openProcessing() {
            closeMenus();
            bigMenu.classList.add("active");
            processingBtn.classList.add("active");
            }

            function openDigital() {
            closeMenus();
            miniMenu.classList.add("active");
            digitalBtn.classList.add("active");
            }

            /* ---------- OPEN ON HOVER ---------- */
            processingBtn.addEventListener("mouseenter", openProcessing);
            digitalBtn.addEventListener("mouseenter", openDigital);

            /* ---------- CLOSE WHEN LEAVING BOTH ---------- */
            function bindClose(trigger, menu) {
            let hovering = false;

            function enter() {
                hovering = true;
            }

            function leave(e) {
                if (!trigger.contains(e.relatedTarget) &&
                    !menu.contains(e.relatedTarget)) {
                hovering = false;
                closeMenus();
                }
            }

            trigger.addEventListener("mouseenter", enter);
            menu.addEventListener("mouseenter", enter);

            trigger.addEventListener("mouseleave", leave);
            menu.addEventListener("mouseleave", leave);
            }

            bindClose(processingBtn, bigMenu);
            bindClose(digitalBtn, miniMenu);

            /* ---------- NORMAL NAV ITEMS CLOSE ---------- */
            document
            .querySelectorAll(".mainMenu > li:not(#processing-btn):not(#financing-btn)")
            .forEach(li => {
                li.addEventListener("mouseenter", closeMenus);
            });
        });
    </script>
        <!-- /NAV SWITCHING SCRIPT/ -->

        <!-- Desktop Hover Menus Start -->
        <style>
            /* ===============================
            DESKTOP HOVER MENUS ONLY
            =============================== */
            @media (hover: hover) and (pointer: fine) {

                /* Mega Menu */
                .nav-item.has-mega .mega-menu {
                opacity: 0;
                visibility: hidden;
                transform: translateY(8px);
                transition: opacity 0.25s ease, transform 0.25s ease;
                }

                /* .nav-item.has-mega:hover .mega-menu {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
                } */

                /* Mini Menu */
                .nav-item.has-mini .mini-menu {
                opacity: 0;
                visibility: hidden;
                transform: translateY(6px);
                transition: opacity 0.2s ease, transform 0.2s ease;
                }

                .nav-item.has-mini:hover .mini-menu {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
                }
            }

            @media (hover: none) {
                .mega-menu,
                .mini-menu {
                opacity: 1 !important;
                visibility: visible !important;
                transform: none !important;
                }

                .mega-menu,
            .mini-menu {
                display: none;
            }

            .mega-menu.active,
            .mini-menu.active {
                display: block;
            }

            }


        </style>
        <!-- Desktop Hover Menus End-->

        <!-- mini mega menu script js -->
        <script>            
        /* ================= DATA ================= */

            const miniMegaMenuData = [
                {
                title: "Website Design",
                description: "Premium designs at your finger tips",
                image: "<?= $base_url ?>/assets/images/MobileMenuImages/Website_Design.webp",
                briefUrl: "<?= $base_url ?>/digital-services-brief-submit",
                packagesUrl: "<?= $base_url ?>/digital-services",
                sectionUrl: "<?= $base_url ?>/digital-services#website-design"
                },
                {
                title: "3D Printing",
                description: "1-stop shopping for all your 3D-printed needs",
                image: "<?= $base_url ?>/assets/images/MobileMenuImages/3dModelingForPrints.webp",
                briefUrl: "<?= $base_url ?>/digital-services-brief-submit",
                packagesUrl: "<?= $base_url ?>/digital-services",
                sectionUrl: "<?= $base_url ?>/digital-services#3d-printing"
                },
                {
                title: "Branding",
                description: "We can handle all form of your branding needs",
                image: "<?= $base_url ?>/assets/images/MobileMenuImages/Branding.webp",
                briefUrl: "<?= $base_url ?>/digital-services-brief-submit",
                packagesUrl: "<?= $base_url ?>/digital-services",
                sectionUrl: "<?= $base_url ?>/digital-services#branding"
                },
                {
                title: "Social Media Marketing",
                description: "Let market your product on your socials",
                image: "<?= $base_url ?>/assets/images/MobileMenuImages/SocialMediaMarketing-01.webp",
                briefUrl: "<?= $base_url ?>/digital-services-brief-submit",
                packagesUrl: "<?= $base_url ?>/digital-services",
                sectionUrl: "<?= $base_url ?>/digital-services#social-media-marketing"
                }
            ];

            /* ================= RENDER ================= */

            const miniServicesGrid = document.getElementById("miniServicesGrid");

            function renderMiniMegaMenu() {
                miniServicesGrid.innerHTML = "";

                miniMegaMenuData.forEach(item => {
                const card = document.createElement("div");
                card.className = "mini-service-card";

                card.innerHTML = `
                    <a href="${item.sectionUrl}" class="card-content-link">
                        <img
                        class="mini-service-image"
                        src="${item.image}"
                        alt="${item.title}"
                        loading="lazy"
                        />

                        <h3>${item.title}</h3>
                        <p>${item.description}</p>
                    </a>
                    <div class="mini-service-actions">
                        <a href="${item.briefUrl}" class="btn-mini-service primary">Post Your Brief</a>
                        <a href="${item.packagesUrl}" class="btn-mini-service secondary">View Packages</a>
                    </div>
                `;

                miniServicesGrid.appendChild(card);
                });
            }

            /* ================= INIT ================= */

            renderMiniMegaMenu();
        </script>


            <!-- Generate Mobile Processing Menu from menuData -->
            <script>
                (function generateMobileProcessingMenu() {
                    const mobileContainer = document.getElementById('mobileProcessingMenu');
                    if (!mobileContainer || typeof menuData === 'undefined') return;

                    menuData.forEach(category => {
                        const li = document.createElement('li');
                        li.className = 'child-dropdown';
                        
                        // Determine if singular class needed (1 product only)
                        const isSingular = category.products.length === 1;
                        
                        li.innerHTML = `
                            <a class="child-toggle">${category.label}
                                <svg class="plus-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <svg class="minus-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                </svg>
                            </a>
                            <ul class="service-cards${isSingular ? ' singular' : ''}">
                                ${category.products.map(product => `
                                    <li><a href="${product.href}">
                                        <div class="mobileMenu-service-card${isSingular ? ' singular' : ''}">
                                            <img src="${product.image}" alt="${product.name}">
                                            <h3>${product.name}</h3>
                                            <p class="mobileService-Description">${product.description}</p>
                                            <p class="mobileMenu--special-link">Explore <span class="service-card-link"> > </span></p>
                                        </div>
                                    </a></li>
                                `).join('')}
                            </ul>
                        `;
                        
                        mobileContainer.appendChild(li);
                    });
                })();
            </script>

            <!-- navbar js script -->
<script>
            
        /* ==========================
        Active Nav Item
        ========================== */
        document.addEventListener("DOMContentLoaded", () => {
            const navItems = document.querySelectorAll(".one > li");

            navItems.forEach(item => {
                item.addEventListener("click", () => {
                    navItems.forEach(i => i.classList.remove("active"));
                    item.classList.add("active");
                });
            });
        });

        
        /* ==========================
        Mobile Adjustments
        ========================== */
        function updateMobileView() {
            const shopBtn = document.getElementById("shopBtn");
            const searchLi = document.getElementById("searchSectionMain");
            const mobileSection = document.querySelector(".mobile-Section");
            const originalParent = document.querySelector(".searchAndstore-NavSection");

            if (!shopBtn) return;

            if (window.innerWidth <= 1200) {
                shopBtn.textContent = "Store";
                shopBtn.classList.remove("btn-primary");
                shopBtn.classList.add("btn-primary-sm");

                if (searchLi && mobileSection && !mobileSection.contains(searchLi)) {
                    mobileSection.appendChild(searchLi);
                }
            } else {
                shopBtn.textContent = "Shop for Supplies";
                shopBtn.classList.remove("btn-primary-sm");
                shopBtn.classList.add("btn-primary");

                if (searchLi && originalParent && !originalParent.contains(searchLi)) {
                    originalParent.appendChild(searchLi);
                }
            }
        }

        window.addEventListener("DOMContentLoaded", updateMobileView);
        window.addEventListener("resize", updateMobileView);
</script>

     
<script>
           
    document.addEventListener("DOMContentLoaded", () => {

    /* ================================
        BODY SCROLL LOCK HELPERS
    ================================= */
    function lockBodyScroll() {
        document.body.classList.add("menu-open");
    }

    function unlockBodyScroll() {
        document.body.classList.remove("menu-open");
    }

    /* ================================
        MOBILE MENU OPEN / CLOSE
    ================================= */
    const hamburger = document.querySelector("svg.icon.hamburger");
    const closeIcon = document.querySelector("svg.icon.close-MobileDropDownMenu");
    const mobileMenu = document.querySelector("nav.main-menu.mobileDropDown");

    if (hamburger && closeIcon && mobileMenu) {

        // Default state
        hamburger.classList.add("active");
        closeIcon.classList.remove("active");
        mobileMenu.classList.remove("active");
        unlockBodyScroll();

        function toggleMobileMenu() {
        const isOpen = mobileMenu.classList.contains("active");

        mobileMenu.classList.toggle("active", !isOpen);
        hamburger.classList.toggle("active", isOpen);
        closeIcon.classList.toggle("active", !isOpen);

        if (!isOpen) {
            lockBodyScroll();
        } else {
            unlockBodyScroll();
        }
        }

        hamburger.addEventListener("click", toggleMobileMenu);
        closeIcon.addEventListener("click", toggleMobileMenu);

        // ESC key closes menu
        document.addEventListener("keydown", e => {
        if (e.key === "Escape") {
            mobileMenu.classList.remove("active");
            hamburger.classList.add("active");
            closeIcon.classList.remove("active");
            unlockBodyScroll();
        }
        });
    }

    /* ================================
        MOBILE ACCORDION MENU
    ================================= */

    // Parent accordion
    document.querySelectorAll(".parent-toggle").forEach(parent => {
        parent.addEventListener("click", () => {
        const parentLi = parent.parentElement;
        const childUl = parentLi.querySelector("ul");

        if (!childUl) return;

        const isOpen = childUl.classList.contains("show");

        // Close all other parents
        document.querySelectorAll(".parent-toggle").forEach(p => {
            if (p !== parent) {
            p.classList.remove("open");
            const li = p.parentElement;
            li.querySelectorAll("ul").forEach(ul => ul.classList.remove("show"));
            li.querySelectorAll(".child-toggle").forEach(c => c.classList.remove("active"));
            }
        });

        parent.classList.toggle("open", !isOpen);
        childUl.classList.toggle("show", !isOpen);
        });
    });

    // Child accordion
    document.querySelectorAll(".child-toggle").forEach(child => {
        child.addEventListener("click", e => {
        e.stopPropagation();

        const childLi = child.parentElement;
        const childUl = childLi.querySelector("ul");

        if (!childUl) return;

        const isActive = child.classList.contains("active");

        // Close siblings
        childLi.parentElement.querySelectorAll(".child-toggle").forEach(sib => {
            if (sib !== child) {
            sib.classList.remove("active");
            const ul = sib.parentElement.querySelector("ul");
            if (ul) ul.classList.remove("show");
            }
        });

        child.classList.toggle("active", !isActive);
        childUl.classList.toggle("show", !isActive);
        });
    });

    });

</script>

<!-- LIVE SEARCH SECTION CSS STYLING START-->
<style>
        .liveSearchResults {
        position: relative;
        background: #fff;
        width: 100%;
        max-height: 300px;
        overflow-y: auto;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        z-index: 1000;
    }

    .search-count-header {
        padding: 8px 15px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid #dee2e6;
        font-size: 13px;
        font-weight: 600;
        color: #495057;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .search-count-header span {
        display: block;
    }

    .live-result-item {
        padding: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .live-result-item.clickable-result {
        transition: background 0.2s ease, transform 0.1s ease;
    }

    .live-result-item.clickable-result:hover {
        background: #f0f4f8;
    }

    .live-result-item.clickable-result:active {
        transform: scale(0.99);
    }

    .live-result-item:hover {
        background: #f5f5f5;
    }

    .result-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
        flex: 1;
    }

    .result-title {
        font-size: 0.95rem;
        color: #333;
        font-weight: 500;
    }

    .result-action-label {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        border-radius: 10px;
        width: fit-content;
    }

    .result-action-label .action-icon {
        width: 12px;
        height: 12px;
        flex-shrink: 0;
    }

    .result-action-label.learn-more {
        background: #fff3e0;
        color: #e65100;
    }

    .result-action-label.buy-now {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .result-action-label.page {
        background: #e3f2fd;
        color: #1976d2;
    }

    .result-image {
        width: 50px;
        height: 50px;
        object-fit: contain;
        flex-shrink: 0;
    }

    li.Logo-Action a{
        display: grid;
    }

    form.mainNavSearchFormField{
        padding:0px;
        gap:0px;

    }

    .searchFieldInput{
        padding-left:1rem;
    }

</style>
 <!-- LIVE SEARCH SECTION CSS STYLING END-->   
  
 
<style>
    .one > li:hover {    
    border-bottom: 3px solid var(--blue-500);
    transition: border-bottom 0.25s ease;
    }


    ul.service-cards{
        padding-left:2rem;
    }

  
    ul.child-dropdowns li.child-dropdown a{
        padding-left:0px;
    }

    li.child-dropdown{
        padding-left:2.5rem;
    }
   

    .service-cards.show li a{
        padding:12px 0px;
    }

    form.mainNavSearchFormField{
            flex-direction: row;

      }
</style>

<!-- JS FOR LIVE SEARCH SECTION -->   
<script>
        const searchIcon = document.querySelector("#searchSectionMain .icon");
        const searchBox = document.querySelector(".searchFieldBoxAndResults");
        const searchInput = document.querySelector(".searchFieldInput");
        const resultsBox = document.querySelector(".liveSearchResults");
        const searchForm = document.querySelector(".mainNavSearchFormField");
        const closeBtn = document.querySelector(".close-searchButton");

        let controller = null;

        // Toggle search box
        searchIcon.addEventListener("click", () => {
            searchBox.classList.toggle("active");
            if (searchBox.classList.contains("active")) {
                searchInput.focus();
            } else {
                searchInput.value = "";
                resultsBox.innerHTML = "";
            }
        });

        // Close on close button
        closeBtn.addEventListener("click", () => {
            searchBox.classList.remove("active");
            searchInput.value = "";
            resultsBox.innerHTML = "";
        });

        // Prevent normal submit when typing
        searchForm.addEventListener("submit", function (e) {
            if (resultsBox.innerHTML.trim() !== "") {
                e.preventDefault();
            }
        });

        searchInput.addEventListener("input", function () {
            const q = this.value.trim();

            if (q.length < 2) {
                resultsBox.innerHTML = "";
                return;
            }

            // Cancel previous request
            if (controller) controller.abort();
            controller = new AbortController();

            fetch(`<?= $base_url ?>/ajax_search.php?q=${encodeURIComponent(q)}`, {
                signal: controller.signal
            })
            .then(res => res.json())
            .then(data => {
                resultsBox.innerHTML = "";

                const results = data.results || [];
                const counts = data.counts || { products: 0, pages: 0, total: 0 };

                if (results.length === 0) {
                    resultsBox.innerHTML = `<div class="no-results">No results found</div>`;
                    return;
                }

                // Add count header
                const countHeader = document.createElement("div");
                countHeader.className = "search-count-header";
                // Calculate actual result count (products show 2 items: Learn More & Buy Now)
                const actualResultCount = (counts.products * 2) + counts.pages;
                let countText = `Found ${actualResultCount} result${actualResultCount !== 1 ? 's' : ''}`;
                if (counts.products > 0) {
                    countText += ` for ${counts.products} product${counts.products !== 1 ? 's' : ''}`;
                }
                countHeader.innerHTML = `<span>${countText}</span>`;
                resultsBox.appendChild(countHeader);

                results.forEach(item => {
                    if (item.type === 'product') {
                        // Extract product ID from 'product_X' format
                        const productId = item.id.replace('product_', '');
                        
                        // Create "Buy Now" result item (first)
                        const buyNowDiv = document.createElement("div");
                        buyNowDiv.className = "live-result-item clickable-result";
                        buyNowDiv.innerHTML = `
                            <img src="${item.image}" alt="${item.name}" class="result-image">
                            <div class="result-info">
                                <span class="result-title">${item.name}</span>
                                <span class="result-action-label buy-now">Buy Now <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="action-icon"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg></span>
                            </div>
                        `;
                        buyNowDiv.onclick = () => window.open(item.link, '_blank');
                        resultsBox.appendChild(buyNowDiv);
                        
                        // Create "Learn More" result item (second)
                        const learnMoreDiv = document.createElement("div");
                        learnMoreDiv.className = "live-result-item clickable-result";
                        learnMoreDiv.innerHTML = `
                            <img src="${item.image}" alt="${item.name}" class="result-image">
                            <div class="result-info">
                                <span class="result-title">${item.name}</span>
                                <span class="result-action-label learn-more">Learn More <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="action-icon"><polyline points="9 18 15 12 9 6"></polyline></svg></span>
                            </div>
                        `;
                        learnMoreDiv.onclick = () => window.location.href = `<?= $base_url ?>/shop-product?id=${productId}`;
                        resultsBox.appendChild(learnMoreDiv);
                    } else {
                        // Page result - single item
                        const div = document.createElement("div");
                        div.className = "live-result-item clickable-result";
                        div.innerHTML = `
                            <img src="${item.image}" alt="${item.name}" class="result-image">
                            <div class="result-info">
                                <span class="result-title">${item.name}</span>
                                <span class="result-action-label page">View Page <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="action-icon"><polyline points="9 18 15 12 9 6"></polyline></svg></span>
                            </div>
                        `;
                        div.onclick = () => window.location.href = item.link;
                        resultsBox.appendChild(div);
                    }
                });
            })
            .catch(err => {
                if (err.name !== "AbortError") console.error(err);
            });
        });
</script>

<style>   
    :root{
        --mobile-Social-Buttons-section-height:75px;
    }
    .mobile-Social-Buttons-section{
        position:fixed;
        bottom:3.5rem;
        width: 100%;
        background-color: #fff;
        height:var(--mobile-Social-Buttons-section-height);
    }

    .mobile-Social-Buttons-section > li{
        border:0px solid transparent !important;
    }

    .mobile-Social-Buttons-section > li:first-child{
        border-top:1px solid #efefef !important;
    }

    .main-menu.mobileDropDown ul{
       height:calc(100% - var(--mobile-Social-Buttons-section-height));
        overflow-y: auto;        
    }
    li.social-icon-set{
        padding-top:.8px;
    }

    .copyright-foot-mobileMenu{
        padding:0px;
    }

    .live-result-item {
        display: flex;
        align-items: center;
        padding: 10px;
        cursor: pointer;
        border-bottom: 1px solid #eee;
    }
    .live-result-item:hover {
        background-color: #f9f9f9;
    }
    .result-image {
        width: 40px;
        height: 40px;
        object-fit: cover;
        margin-right: 10px;
        border-radius: 4px;
    }
    .result-title {
        font-weight: 500;
    }
    .no-results {
        padding: 10px;
        text-align: center;
        color: #666;
    }
</style>