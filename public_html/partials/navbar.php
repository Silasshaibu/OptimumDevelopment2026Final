    <!--Main Navigation Section-->
    <div class="mainNavigationSection">
        <div class="topnavbarWrapper">
            <div class="topnavbar">
                <div class="topnavbar-inner">
                    <div class="topnavbar-logo">
                        <img src="<?= $base_url ?>/assets/Optimum-Logo.png" alt="Optimum Logo">
                    </div>
                    <div class="topnavbar-content">
                        <div class="topnavbar-links">
                            <a href="#" class="active">Home</a>
                            <a href="#">Promo</a>
                            <a href="#" data-dropdown="megamenu">Processing Solutions <svg
                                    xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6"
                                    fill="none">
                                    <path d="M0.75 0.75L4.75 4.75L8.75 0.75" stroke="#2B2B2B" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg></a>
                            <a href="#" data-dropdown="minimenu">Digital Services <svg
                                    xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6"
                                    fill="none">
                                    <path d="M0.75 0.75L4.75 4.75L8.75 0.75" stroke="#2B2B2B" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg></a>
                            <a href="#">Business Financing</a>
                            <a href="#">About Us</a>
                            <a href="#">Contact Us</a>
                        </div>
                        <div class="topnavbar-actions">
                            <svg class="topnavbar-search" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M9.37891 2.0753C10.732 1.89531 12.109 2.04342 13.3926 2.50792C14.6762 2.97244 15.8293 3.73998 16.7539 4.74425C17.6783 5.74845 18.3471 6.96105 18.7041 8.27843C19.061 9.59584 19.0957 10.9801 18.8047 12.3136C18.5299 13.5728 17.9714 14.7512 17.1748 15.7618L21.707 20.2931H21.7061C21.8015 20.3835 21.8791 20.4913 21.9326 20.6114C21.9873 20.7341 22.0162 20.8668 22.0186 21.0011C22.0209 21.1353 21.9966 21.2691 21.9463 21.3937C21.896 21.5181 21.8205 21.6308 21.7256 21.7257C21.6307 21.8206 21.518 21.8961 21.3936 21.9464C21.269 21.9967 21.1352 22.021 21.001 22.0187C20.8667 22.0163 20.734 21.9864 20.6113 21.9317C20.4913 21.8782 20.3833 21.8015 20.293 21.7062L15.7617 17.1749C14.5552 18.1261 13.1126 18.7341 11.5859 18.9308C9.98381 19.1372 8.3563 18.8828 6.89355 18.1974C5.43072 17.5119 4.19281 16.424 3.32617 15.0607C2.4597 13.6974 1.99985 12.1154 2 10.5001C2.00018 9.13514 2.32918 7.79019 2.95898 6.57921C3.58886 5.36817 4.50162 4.32601 5.61914 3.5421C6.73647 2.75843 8.02607 2.2553 9.37891 2.0753ZM10.5 4.00011C9.64641 4.00011 8.80131 4.16857 8.0127 4.49522C7.22409 4.82188 6.50689 5.29986 5.90332 5.90343C5.29977 6.507 4.82176 7.22421 4.49512 8.0128C4.16849 8.80139 4 9.64655 4 10.5001C4.00001 11.3537 4.16848 12.1988 4.49512 12.9874C4.82169 13.7758 5.29997 14.4923 5.90332 15.0958C6.5069 15.6994 7.22408 16.1783 8.0127 16.505C8.8013 16.8316 9.64642 17.0001 10.5 17.0001C12.2239 17.0001 13.8777 16.3148 15.0967 15.0958C16.3154 13.8769 17 12.2238 17 10.5001C17 8.77623 16.3156 7.12241 15.0967 5.90343C13.8777 4.68444 12.2239 4.00011 10.5 4.00011Z"
                                    fill="#AAAAAA" stroke="#AAAAAA" stroke-width="0.5" />
                            </svg>
                            <button class="topnavbar-cta">Shop
                                For Supplies</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- MegaMenu dropdown content (hidden by default) -->
        <div class="megamenu-outer">
            <div class="megamenu">

                <!-- ========== LEFT PANEL: List Nav Menu Items ========== -->
                <div class="megamenu-left">
                    <ul class="megamenu-list" role="list">

                        <li class="megamenu-item" data-target="panel-dining" role="listitem">
                            <span class="megamenu-item-label">Full Service Fine Dining</span>
                            <svg class="megamenu-item-arrow" width="6" height="12" viewBox="0 0 6 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M1 1L5 6L1 11" stroke="white" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </li>

                        <li class="megamenu-item active" data-target="panel-qsr" role="listitem">
                            <span class="megamenu-item-label">QSR and Food Trucks</span>
                            <svg class="megamenu-item-arrow" width="6" height="12" viewBox="0 0 6 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M1 1L5 6L1 11" stroke="white" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </li>

                        <li class="megamenu-item" data-target="panel-bars" role="listitem">
                            <span class="megamenu-item-label">Bars / Night Clubs / High Volume</span>
                            <svg class="megamenu-item-arrow" width="6" height="12" viewBox="0 0 6 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M1 1L5 6L1 11" stroke="white" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </li>

                        <li class="megamenu-item" data-target="panel-retail" role="listitem">
                            <span class="megamenu-item-label">Retail / Liquor / Smoke Shops</span>
                            <svg class="megamenu-item-arrow" width="6" height="12" viewBox="0 0 6 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M1 1L5 6L1 11" stroke="white" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </li>

                        <li class="megamenu-item" data-target="panel-medical" role="listitem">
                            <span class="megamenu-item-label">Medical</span>
                            <svg class="megamenu-item-arrow" width="6" height="12" viewBox="0 0 6 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M1 1L5 6L1 11" stroke="white" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </li>

                        <li class="megamenu-item" data-target="panel-contractor" role="listitem">
                            <span class="megamenu-item-label">Contractor / Online Payments / Mobile</span>
                            <svg class="megamenu-item-arrow" width="6" height="12" viewBox="0 0 6 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M1 1L5 6L1 11" stroke="white" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </li>

                        <li class="megamenu-item" data-target="panel-basic" role="listitem">
                            <span class="megamenu-item-label">Need a Basic Setup?</span>
                            <svg class="megamenu-item-arrow" width="6" height="12" viewBox="0 0 6 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M1 1L5 6L1 11" stroke="white" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </li>

                    </ul>
                </div>
                <!-- ========== END LEFT PANEL ========== -->


                <!-- ========== RIGHT PANEL: Feature Content ========== -->
                <div class="megamenu-right">
                    <div class="megamenu-scroll">

                        <!-- Panel: Full Service Fine Dining -->
                        <div class="megamenu-panel" id="panel-dining">
                            <div class="megamenu-panel-cards">
                                <div class="megamenu-card">
                                    <div class="megamenu-card-img">
                                        <img src="<?= $base_url ?>/assets/hhd-products/hhd-clover-flex.png" alt="Clover Flex">
                                    </div>
                                    <div class="megamenu-card-body">
                                        <h3 class="megamenu-card-name">Clover Flex</h3>
                                        <p class="megamenu-card-desc">Tableside ordering and payments for full-service
                                            restaurants</p>
                                    </div>
                                </div>
                                <div class="megamenu-card">
                                    <div class="megamenu-card-img">
                                        <img src="<?= $base_url ?>/assets/hhd-products/hhd-clover-go-plus.png" alt="Clover Go Plus">
                                    </div>
                                    <div class="megamenu-card-body">
                                        <h3 class="megamenu-card-name">Clover Go Plus</h3>
                                        <p class="megamenu-card-desc">Accept payments anywhere in your dining room with
                                            ease
                                        </p>
                                    </div>
                                </div>
                                <div class="megamenu-card">
                                    <div class="megamenu-card-img">
                                        <img src="<?= $base_url ?>/assets/hhd-products/hhd-valor-vp-550.png" alt="Valor VP-550">
                                    </div>
                                    <div class="megamenu-card-body">
                                        <h3 class="megamenu-card-name">Valor VP-550</h3>
                                        <p class="megamenu-card-desc">Elegant countertop terminal designed for fine
                                            dining
                                            payment workflows</p>
                                    </div>
                                </div>
                                <div class="megamenu-card">
                                    <div class="megamenu-card-img">
                                        <img src="<?= $base_url ?>/assets/hhd-products/hhd-valor-vp-800.png" alt="Valor VP-800">
                                    </div>
                                    <div class="megamenu-card-body">
                                        <h3 class="megamenu-card-name">Valor VP-800</h3>
                                        <p class="megamenu-card-desc">High-performance terminal with tipping and
                                            split-check
                                            support</p>
                                    </div>
                                </div>
                                <div class="megamenu-card">
                                    <div class="megamenu-card-img">
                                        <img src="<?= $base_url ?>/assets/hhd-products/hhd-valor-vl-100.png" alt="Valor VL-100">
                                    </div>
                                    <div class="megamenu-card-body">
                                        <h3 class="megamenu-card-name">Valor VL-100</h3>
                                        <p class="megamenu-card-desc">Compact lane terminal for seamless guest-facing
                                            payment experiences</p>
                                    </div>
                                </div>
                                <div class="megamenu-card">
                                    <div class="megamenu-card-img">
                                        <img src="<?= $base_url ?>/assets/hhd-products/hhd-valor-vl-110.png" alt="Valor VL-110">
                                    </div>
                                    <div class="megamenu-card-body">
                                        <h3 class="megamenu-card-name">Valor VL-110</h3>
                                        <p class="megamenu-card-desc">Advanced PIN pad with NFC and chip for upscale
                                            dining
                                            environments</p>
                                    </div>
                                </div>
                                <div class="megamenu-card">
                                    <div class="megamenu-card-img">
                                        <img src="<?= $base_url ?>/assets/sup-products/sup-star-micronics-printer.png"
                                            alt="Star Micronics Printer">
                                    </div>
                                    <div class="megamenu-card-body">
                                        <h3 class="megamenu-card-name">Star Micronics Printer</h3>
                                        <p class="megamenu-card-desc">Fast, reliable kitchen and receipt printer built
                                            for
                                            busy restaurant environments</p>
                                    </div>
                                </div>
                                <div class="megamenu-card">
                                    <div class="megamenu-card-img">
                                        <img src="<?= $base_url ?>/assets/sup-products/sup-clover-cash-drawer.png"
                                            alt="Clover Cash Drawer">
                                    </div>
                                    <div class="megamenu-card-body">
                                        <h3 class="megamenu-card-name">Clover Cash Drawer</h3>
                                        <p class="megamenu-card-desc">Durable cash drawer that integrates directly with
                                            your
                                            Clover POS system</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Panel: QSR and Food Trucks -->
                        <div class="megamenu-panel active" id="panel-qsr">
                            <div class="megamenu-panel-cards">
                                <div class="megamenu-card">
                                    <div class="megamenu-card-img">
                                        <img src="<?= $base_url ?>/assets/hhd-products/hhd-clover-flex.png" alt="Union POS">
                                    </div>
                                    <div class="megamenu-card-body">
                                        <h3 class="megamenu-card-name">Union POS</h3>
                                        <p class="megamenu-card-desc">Manage order, sales, and payments in one place</p>
                                    </div>
                                </div>
                                <div class="megamenu-card">
                                    <div class="megamenu-card-img">
                                        <img src="<?= $base_url ?>/assets/hhd-products/hhd-clover-go-plus.png" alt="Clover">
                                    </div>
                                    <div class="megamenu-card-body">
                                        <h3 class="megamenu-card-name">Clover</h3>
                                        <p class="megamenu-card-desc">Do what you do better with the world's smartest
                                            POS
                                            system</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Panel: Bars / Night Clubs / High Volume -->
                        <div class="megamenu-panel" id="panel-bars">
                            <div class="megamenu-panel-cards">
                                <div class="megamenu-card">
                                    <div class="megamenu-card-img">
                                        <img src="<?= $base_url ?>/assets/hhd-products/hhd-clover-flex.png" alt="Clover Flex">
                                    </div>
                                    <div class="megamenu-card-body">
                                        <h3 class="megamenu-card-name">Clover Flex</h3>
                                        <p class="megamenu-card-desc">Fast tableside ordering and payment built for
                                            high-volume
                                            environments</p>
                                    </div>
                                </div>
                                <div class="megamenu-card">
                                    <div class="megamenu-card-img">
                                        <img src="<?= $base_url ?>/assets/hhd-products/hhd-valor-vp-800.png" alt="Valor VP-800">
                                    </div>
                                    <div class="megamenu-card-body">
                                        <h3 class="megamenu-card-name">Valor VP-800</h3>
                                        <p class="megamenu-card-desc">High-volume bar and nightclub payment terminal
                                            with
                                            rapid transaction processing</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Panel: Retail / Liquor / Smoke Shops -->
                        <div class="megamenu-panel" id="panel-retail">
                            <div class="megamenu-panel-cards">
                                <div class="megamenu-card">
                                    <div class="megamenu-card-img">
                                        <img src="<?= $base_url ?>/assets/hhd-products/hhd-valor-vp-550.png" alt="Valor VP-550">
                                    </div>
                                    <div class="megamenu-card-body">
                                        <h3 class="megamenu-card-name">Valor VP-550</h3>
                                        <p class="megamenu-card-desc">Sleek and powerful payment terminal built for
                                            modern
                                            retail environments</p>
                                    </div>
                                </div>
                                <div class="megamenu-card">
                                    <div class="megamenu-card-img">
                                        <img src="<?= $base_url ?>/assets/hhd-products/hhd-clover-go-plus.png" alt="Clover Go Plus">
                                    </div>
                                    <div class="megamenu-card-body">
                                        <h3 class="megamenu-card-name">Clover Go Plus</h3>
                                        <p class="megamenu-card-desc">Mobile payment reader for in-store and on-the-go
                                            retail
                                            transactions</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Panel: Medical -->
                        <div class="megamenu-panel" id="panel-medical">
                            <div class="megamenu-panel-cards">
                                <div class="megamenu-card">
                                    <div class="megamenu-card-img">
                                        <img src="<?= $base_url ?>/assets/hhd-products/hhd-valor-vl-100.png" alt="Valor VL-100">
                                    </div>
                                    <div class="megamenu-card-body">
                                        <h3 class="megamenu-card-name">Valor VL-100</h3>
                                        <p class="megamenu-card-desc">Secure, fast, and reliable payment solutions for
                                            healthcare providers</p>
                                    </div>
                                </div>
                                <div class="megamenu-card">
                                    <div class="megamenu-card-img">
                                        <img src="<?= $base_url ?>/assets/hhd-products/hhd-valor-vl-110.png" alt="Valor VL-110">
                                    </div>
                                    <div class="megamenu-card-body">
                                        <h3 class="megamenu-card-name">Valor VL-110</h3>
                                        <p class="megamenu-card-desc">Advanced medical payment terminal with integrated
                                            patient billing and reporting</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Panel: Contractor / Online Payments / Mobile -->
                        <div class="megamenu-panel" id="panel-contractor">
                            <div class="megamenu-panel-cards">
                                <div class="megamenu-card">
                                    <div class="megamenu-card-img">
                                        <img src="<?= $base_url ?>/assets/hhd-products/hhd-clover-go-plus.png" alt="Clover Go Plus">
                                    </div>
                                    <div class="megamenu-card-body">
                                        <h3 class="megamenu-card-name">Clover Go Plus</h3>
                                        <p class="megamenu-card-desc">Accept payments on-site, on the road, and
                                            everywhere
                                            your business takes you</p>
                                    </div>
                                </div>
                                <div class="megamenu-card">
                                    <div class="megamenu-card-img">
                                        <img src="<?= $base_url ?>/assets/hhd-products/hhd-valor-vl-110.png" alt="Valor VL-110">
                                    </div>
                                    <div class="megamenu-card-body">
                                        <h3 class="megamenu-card-name">Valor VL-110</h3>
                                        <p class="megamenu-card-desc">Flexible mobile payment solution for contractors
                                            and field service teams</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Panel: Need a Basic Setup? -->
                        <div class="megamenu-panel" id="panel-basic">
                            <div class="megamenu-panel-cards">
                                <div class="megamenu-card">
                                    <div class="megamenu-card-img">
                                        <img src="<?= $base_url ?>/assets/hhd-products/hhd-valor-vp-550.png" alt="Valor VP-550">
                                    </div>
                                    <div class="megamenu-card-body">
                                        <h3 class="megamenu-card-name">Valor VP-550</h3>
                                        <p class="megamenu-card-desc">Simple, affordable payment terminal — everything
                                            you
                                            need to get started fast</p>
                                    </div>
                                </div>
                                <div class="megamenu-card">
                                    <div class="megamenu-card-img">
                                        <img src="<?= $base_url ?>/assets/hhd-products/hhd-clover-go-plus.png" alt="Clover Go Plus">
                                    </div>
                                    <div class="megamenu-card-body">
                                        <h3 class="megamenu-card-name">Clover Go Plus</h3>
                                        <p class="megamenu-card-desc">The easiest way to start accepting payments with
                                            minimal setup and zero fuss</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- end megamenu-scroll -->
                </div>
                <!-- ========== END RIGHT PANEL ========== -->

            </div>
        </div>

        <!-- MiniMenu dropdown content (hidden by default) -->
        <div class="minimenu-outer">
            <div class="minimenu">

                <!-- ========== LEARN MORE LINK ========== -->
                <div class="minimenu-topbar">
                    <a href="#" class="minimenu-learn-more">
                        Learn More
                        <svg width="5" height="9" viewBox="0 0 5 9" fill="none" xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true">
                            <path d="M1 1L4 4.5L1 8" stroke="#399CDB" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>

                <!-- ========== SLIDER ========== -->
                <div class="minimenu-slider">

                    <!-- Left Arrow -->
                    <button class="minimenu-arrow minimenu-arrow--prev" id="miniMenuPrev" aria-label="Previous slide">
                        <img src="<?= $base_url ?>/assets/DigitalServices-DropDown/arrow-left.svg" width="40" height="40" alt=""
                            aria-hidden="true">
                    </button>

                    <!-- Track outer — clips overflow -->
                    <div class="minimenu-track-outer" id="miniMenuTrackOuter">
                        <div class="minimenu-track" id="miniMenuTrack">

                            <!-- Card 1: Website Design -->
                            <div class="minimenu-card">
                                <div class="minimenu-card-inner">
                                    <div class="minimenu-card-img minimenu-card-img--webdesign">
                                        <img src="<?= $base_url ?>/assets/DigitalServices-DropDown/WebsiteDesign--DigitalService--Dropdown.png"
                                            alt="Website Design">
                                    </div>
                                    <div class="minimenu-card-body">
                                        <div class="minimenu-card-text">
                                            <h3 class="minimenu-card-name">Website Design</h3>
                                            <p class="minimenu-card-desc">Premium designs at your finger tips</p>
                                        </div>
                                        <div class="minimenu-card-btns">
                                            <a href="#" class="minimenu-btn minimenu-btn--primary">Post Your Brief</a>
                                            <a href="#" class="minimenu-btn minimenu-btn--outline">View Packages</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 2: 3D Printing -->
                            <div class="minimenu-card">
                                <div class="minimenu-card-inner">
                                    <div class="minimenu-card-img minimenu-card-img--3dprinting">
                                        <img src="<?= $base_url ?>/assets/DigitalServices-DropDown/3D-Printing--DigitalService--Dropdown.png"
                                            alt="3D Printing">
                                    </div>
                                    <div class="minimenu-card-body">
                                        <div class="minimenu-card-text">
                                            <h3 class="minimenu-card-name">3D Printing</h3>
                                            <p class="minimenu-card-desc">1-stop shopping for all your 3d-prented needs
                                            </p>
                                        </div>
                                        <div class="minimenu-card-btns">
                                            <a href="#" class="minimenu-btn minimenu-btn--primary">Post Your Brief</a>
                                            <a href="#" class="minimenu-btn minimenu-btn--outline">View Packages</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 3: Branding -->
                            <div class="minimenu-card">
                                <div class="minimenu-card-inner">
                                    <div class="minimenu-card-img minimenu-card-img--branding">
                                        <img src="<?= $base_url ?>/assets/DigitalServices-DropDown/Branding--DigitalService--Dropdown.png"
                                            alt="Branding">
                                    </div>
                                    <div class="minimenu-card-body">
                                        <div class="minimenu-card-text">
                                            <h3 class="minimenu-card-name">Branding</h3>
                                            <p class="minimenu-card-desc">We can handle all form of your branding needs
                                            </p>
                                        </div>
                                        <div class="minimenu-card-btns">
                                            <a href="#" class="minimenu-btn minimenu-btn--primary">Post Your Brief</a>
                                            <a href="#" class="minimenu-btn minimenu-btn--outline">View Packages</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 4: Social Media Marketing -->
                            <div class="minimenu-card">
                                <div class="minimenu-card-inner">
                                    <div class="minimenu-card-img minimenu-card-img--socialmedia">
                                        <img src="<?= $base_url ?>/assets/DigitalServices-DropDown/SocialMediaMarketing--DigitalService--Dropdown.png"
                                            alt="Social Media Marketing">
                                    </div>
                                    <div class="minimenu-card-body">
                                        <div class="minimenu-card-text">
                                            <h3 class="minimenu-card-name">Social Media Marketing</h3>
                                            <p class="minimenu-card-desc">Let market your product on your socials</p>
                                        </div>
                                        <div class="minimenu-card-btns">
                                            <a href="#" class="minimenu-btn minimenu-btn--primary">Post Your Brief</a>
                                            <a href="#" class="minimenu-btn minimenu-btn--outline">View Packages</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 5: SEO & Digital Marketing -->
                            <div class="minimenu-card">
                                <div class="minimenu-card-inner">
                                    <div class="minimenu-card-img minimenu-card-img--seo">
                                        <img src="<?= $base_url ?>/assets/DigitalServices-DropDown/SEO--DigitalService--Dropdown.svg"
                                            alt="SEO &amp; Digital Marketing">
                                    </div>
                                    <div class="minimenu-card-body">
                                        <div class="minimenu-card-text">
                                            <h3 class="minimenu-card-name">SEO &amp; Digital Marketing</h3>
                                            <p class="minimenu-card-desc">Boost your online visibility and search
                                                rankings</p>
                                        </div>
                                        <div class="minimenu-card-btns">
                                            <a href="#" class="minimenu-btn minimenu-btn--primary">Post Your Brief</a>
                                            <a href="#" class="minimenu-btn minimenu-btn--outline">View Packages</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 6: Mobile App Development -->
                            <div class="minimenu-card">
                                <div class="minimenu-card-inner">
                                    <div class="minimenu-card-img minimenu-card-img--mobile">
                                        <img src="<?= $base_url ?>/assets/DigitalServices-DropDown/MobileApp--DigitalService--Dropdown.svg"
                                            alt="Mobile App Development">
                                    </div>
                                    <div class="minimenu-card-body">
                                        <div class="minimenu-card-text">
                                            <h3 class="minimenu-card-name">Mobile App Development</h3>
                                            <p class="minimenu-card-desc">Custom apps for iOS and Android platforms</p>
                                        </div>
                                        <div class="minimenu-card-btns">
                                            <a href="#" class="minimenu-btn minimenu-btn--primary">Post Your Brief</a>
                                            <a href="#" class="minimenu-btn minimenu-btn--outline">View Packages</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Right Arrow -->
                    <button class="minimenu-arrow minimenu-arrow--next" id="miniMenuNext" aria-label="Next slide">
                        <img src="<?= $base_url ?>/assets/DigitalServices-DropDown/arrow-right.svg" width="40" height="40" alt=""
                            aria-hidden="true">
                    </button>

                </div>
                <!-- ========== END SLIDER ========== -->

                <!-- ========== PAGINATION DOTS ========== -->
                <div class="minimenu-dots" id="miniMenuDots"></div>

            </div>
        </div>

        <!-- Search Section -->
        <div class="sr-outer">
            <div class="sr-container">

                <!-- ========== SEARCH BAR ========== -->
                <div class="sr-bar">
                    <input class="sr-input" type="search" id="srInput" placeholder="Search for supplies..."
                        autocomplete="off" aria-label="Search for supplies">
                    <button class="sr-close" id="srClose" aria-label="Close search">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                            <path d="M1 1L13 13M13 1L1 13" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </button>
                </div>

                <!-- ========== RESULTS META ========== -->
                <p class="sr-meta">Found 10 results for 5 products</p>

                <!-- ========== RESULTS AREA ========== -->
                <div class="sr-results-outer">

                    <!-- Results list -->
                    <div class="sr-results" id="srResults">

                        <!-- Row 1 — Clover Flex Paper · Buy Now -->
                        <div class="sr-row sr-row--alt">
                            <div class="sr-img-wrap">
                                <img src="<?= $base_url ?>/assets/sup-products/sup-clover-flex-paper.png" alt="Clover Flex Paper"
                                    class="sr-img">
                            </div>
                            <div class="sr-info">
                                <h3 class="sr-name">Clover Flex Paper</h3>
                                <a href="#" class="sr-badge sr-badge--buy">
                                    Buy Now
                                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none" aria-hidden="true">
                                        <path d="M7 1.5H11.5M11.5 1.5V6M11.5 1.5L5.5 7.5" stroke="currentColor"
                                            stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M5 2.5H2C1.72 2.5 1.5 2.72 1.5 3V11C1.5 11.28 1.72 11.5 2 11.5H10C10.28 11.5 10.5 11.28 10.5 11V7.5"
                                            stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Row 2 — Clover Flex Paper · Learn More -->
                        <div class="sr-row">
                            <div class="sr-img-wrap">
                                <img src="<?= $base_url ?>/assets/sup-products/sup-clover-flex-paper.png" alt="Clover Flex Paper"
                                    class="sr-img">
                            </div>
                            <div class="sr-info">
                                <h3 class="sr-name">Clover Flex Paper</h3>
                                <a href="#" class="sr-badge sr-badge--learn">
                                    Learn More
                                    <svg width="5" height="9" viewBox="0 0 5 9" fill="none" aria-hidden="true">
                                        <path d="M1 1L4 4.5L1 8" stroke="currentColor" stroke-width="1.3"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Row 3 — Clover Station Paper · Buy Now -->
                        <div class="sr-row sr-row--alt">
                            <div class="sr-img-wrap">
                                <img src="<?= $base_url ?>/assets/sup-products/sup-clover-station-paper.png" alt="Clover Station Paper"
                                    class="sr-img">
                            </div>
                            <div class="sr-info">
                                <h3 class="sr-name">Clover Station Paper</h3>
                                <a href="#" class="sr-badge sr-badge--buy">
                                    Buy Now
                                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none" aria-hidden="true">
                                        <path d="M7 1.5H11.5M11.5 1.5V6M11.5 1.5L5.5 7.5" stroke="currentColor"
                                            stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M5 2.5H2C1.72 2.5 1.5 2.72 1.5 3V11C1.5 11.28 1.72 11.5 2 11.5H10C10.28 11.5 10.5 11.28 10.5 11V7.5"
                                            stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Row 4 — Clover Station Paper · Learn More -->
                        <div class="sr-row">
                            <div class="sr-img-wrap">
                                <img src="<?= $base_url ?>/assets/sup-products/sup-clover-station-paper.png" alt="Clover Station Paper"
                                    class="sr-img">
                            </div>
                            <div class="sr-info">
                                <h3 class="sr-name">Clover Station Paper</h3>
                                <a href="#" class="sr-badge sr-badge--learn">
                                    Learn More
                                    <svg width="5" height="9" viewBox="0 0 5 9" fill="none" aria-hidden="true">
                                        <path d="M1 1L4 4.5L1 8" stroke="currentColor" stroke-width="1.3"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Row 5 — Clover Barcode Scanner · Buy Now -->
                        <div class="sr-row sr-row--alt">
                            <div class="sr-img-wrap">
                                <img src="<?= $base_url ?>/assets/sup-products/sup-clover-barcode-scanner.png"
                                    alt="Clover Barcode Scanner" class="sr-img">
                            </div>
                            <div class="sr-info">
                                <h3 class="sr-name">Clover Barcode Scanner</h3>
                                <a href="#" class="sr-badge sr-badge--buy">
                                    Buy Now
                                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none" aria-hidden="true">
                                        <path d="M7 1.5H11.5M11.5 1.5V6M11.5 1.5L5.5 7.5" stroke="currentColor"
                                            stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M5 2.5H2C1.72 2.5 1.5 2.72 1.5 3V11C1.5 11.28 1.72 11.5 2 11.5H10C10.28 11.5 10.5 11.28 10.5 11V7.5"
                                            stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Row 6 — Clover Barcode Scanner · Learn More -->
                        <div class="sr-row">
                            <div class="sr-img-wrap">
                                <img src="<?= $base_url ?>/assets/sup-products/sup-clover-barcode-scanner.png"
                                    alt="Clover Barcode Scanner" class="sr-img">
                            </div>
                            <div class="sr-info">
                                <h3 class="sr-name">Clover Barcode Scanner</h3>
                                <a href="#" class="sr-badge sr-badge--learn">
                                    Learn More
                                    <svg width="5" height="9" viewBox="0 0 5 9" fill="none" aria-hidden="true">
                                        <path d="M1 1L4 4.5L1 8" stroke="currentColor" stroke-width="1.3"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Row 7 — Clover Cash Drawer · Buy Now -->
                        <div class="sr-row sr-row--alt">
                            <div class="sr-img-wrap">
                                <img src="<?= $base_url ?>/assets/sup-products/sup-clover-cash-drawer.png" alt="Clover Cash Drawer"
                                    class="sr-img">
                            </div>
                            <div class="sr-info">
                                <h3 class="sr-name">Clover Cash Drawer</h3>
                                <a href="#" class="sr-badge sr-badge--buy">
                                    Buy Now
                                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none" aria-hidden="true">
                                        <path d="M7 1.5H11.5M11.5 1.5V6M11.5 1.5L5.5 7.5" stroke="currentColor"
                                            stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M5 2.5H2C1.72 2.5 1.5 2.72 1.5 3V11C1.5 11.28 1.72 11.5 2 11.5H10C10.28 11.5 10.5 11.28 10.5 11V7.5"
                                            stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Row 8 — Clover Cash Drawer · Learn More -->
                        <div class="sr-row">
                            <div class="sr-img-wrap">
                                <img src="<?= $base_url ?>/assets/sup-products/sup-clover-cash-drawer.png" alt="Clover Cash Drawer"
                                    class="sr-img">
                            </div>
                            <div class="sr-info">
                                <h3 class="sr-name">Clover Cash Drawer</h3>
                                <a href="#" class="sr-badge sr-badge--learn">
                                    Learn More
                                    <svg width="5" height="9" viewBox="0 0 5 9" fill="none" aria-hidden="true">
                                        <path d="M1 1L4 4.5L1 8" stroke="currentColor" stroke-width="1.3"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Row 9 — DejaVoo Z8 Paper · Buy Now -->
                        <div class="sr-row sr-row--alt">
                            <div class="sr-img-wrap">
                                <img src="<?= $base_url ?>/assets/sup-products/sup-dejavoo-z8-paper.png" alt="DejaVoo Z8 Paper"
                                    class="sr-img">
                            </div>
                            <div class="sr-info">
                                <h3 class="sr-name">DejaVoo Z8 Paper</h3>
                                <a href="#" class="sr-badge sr-badge--buy">
                                    Buy Now
                                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none" aria-hidden="true">
                                        <path d="M7 1.5H11.5M11.5 1.5V6M11.5 1.5L5.5 7.5" stroke="currentColor"
                                            stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M5 2.5H2C1.72 2.5 1.5 2.72 1.5 3V11C1.5 11.28 1.72 11.5 2 11.5H10C10.28 11.5 10.5 11.28 10.5 11V7.5"
                                            stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Row 10 — DejaVoo Z8 Paper · Learn More -->
                        <div class="sr-row">
                            <div class="sr-img-wrap">
                                <img src="<?= $base_url ?>/assets/sup-products/sup-dejavoo-z8-paper.png" alt="DejaVoo Z8 Paper"
                                    class="sr-img">
                            </div>
                            <div class="sr-info">
                                <h3 class="sr-name">DejaVoo Z8 Paper</h3>
                                <a href="#" class="sr-badge sr-badge--learn">
                                    Learn More
                                    <svg width="5" height="9" viewBox="0 0 5 9" fill="none" aria-hidden="true">
                                        <path d="M1 1L4 4.5L1 8" stroke="currentColor" stroke-width="1.3"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                    </div>
                    <!-- end .sr-results -->

                    <!-- ========== CUSTOM SCROLLBAR ========== -->
                    <div class="sr-scrollbar" id="srScrollbar">
                        <button class="sr-sb-arrow sr-sb-arrow--up" id="srScrollUp" aria-label="Scroll up">
                            <svg width="10" height="6" viewBox="0 0 10 6" fill="none" aria-hidden="true">
                                <path d="M1 5.5L5 1.5L9 5.5" stroke="#6B6B6B" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                        <div class="sr-sb-track" id="srSbTrack">
                            <div class="sr-sb-thumb" id="srSbThumb"></div>
                        </div>
                        <button class="sr-sb-arrow sr-sb-arrow--down" id="srScrollDown" aria-label="Scroll down">
                            <svg width="10" height="6" viewBox="0 0 10 6" fill="none" aria-hidden="true">
                                <path d="M1 0.5L5 4.5L9 0.5" stroke="#6B6B6B" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                    <!-- end .sr-scrollbar -->

                </div>
                <!-- end .sr-results-outer -->

            </div>
        </div>

        <!--MobileNavigationMenu-->
        <div class="nav-wrapper">

            <!-- Header -->
            <div class="nav-header">
                <button id="hamburger-btn" aria-label="Open menu">
                    <!-- hamburger icon (default) -->
                    <svg id="icon-hamburger" fill="none" viewBox="0 0 24 24">
                        <path d="M3 12H21M3 6H21M3 18H21" stroke="#AAAAAA" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2.5" />
                    </svg>
                    <!-- close icon (hidden by default) -->
                    <svg id="icon-close" fill="none" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6L18 18" stroke="#AAAAAA" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2.5" />
                    </svg>
                </button>
                <!-- Search -->
                <div class="header-search">
                    <svg fill="none" viewBox="0 0 24 24" width="24" height="24">
                        <g>
                            <path
                                d="M9.37891 2.07531C10.732 1.89532 12.109 2.04343 13.3926 2.50792C14.6762 2.97244 15.8293 3.73998 16.7539 4.74425C17.6783 5.74845 18.3471 6.96105 18.7041 8.27843C19.061 9.59584 19.0957 10.9801 18.8047 12.3136C18.5299 13.5728 17.9714 14.7512 17.1748 15.7618L21.707 20.2931H21.7061C21.8015 20.3835 21.8791 20.4913 21.9326 20.6114C21.9873 20.7341 22.0162 20.8668 22.0186 21.0011C22.0209 21.1354 21.9966 21.2692 21.9463 21.3937C21.896 21.5181 21.8205 21.6308 21.7256 21.7257C21.6307 21.8206 21.518 21.8961 21.3936 21.9464C21.269 21.9967 21.1352 22.021 21.001 22.0187C20.8667 22.0163 20.734 21.9864 20.6113 21.9318C20.4913 21.8782 20.3833 21.8015 20.293 21.7062L15.7617 17.1749C14.5552 18.1261 13.1126 18.7341 11.5859 18.9308C9.98381 19.1372 8.3563 18.8828 6.89355 18.1974C5.43072 17.5119 4.19281 16.424 3.32617 15.0607C2.4597 13.6974 1.99985 12.1154 2 10.5001C2.00018 9.13514 2.32918 7.7902 2.95898 6.57921C3.58886 5.36817 4.50162 4.32602 5.61914 3.5421C6.73647 2.75844 8.02607 2.25531 9.37891 2.07531ZM10.5 4.00011C9.64641 4.00011 8.80131 4.16857 8.0127 4.49523C7.22409 4.82188 6.50689 5.29986 5.90332 5.90343C5.29977 6.507 4.82176 7.22421 4.49512 8.01281C4.16849 8.8014 4 9.64655 4 10.5001C4.00001 11.3537 4.16848 12.1988 4.49512 12.9874C4.82169 13.7758 5.29997 14.4923 5.90332 15.0958C6.5069 15.6994 7.22408 16.1783 8.0127 16.505C8.8013 16.8316 9.64642 17.0001 10.5 17.0001C12.2239 17.0001 13.8777 16.3148 15.0967 15.0958C16.3154 13.8769 17 12.2238 17 10.5001C17 8.77623 16.3156 7.12241 15.0967 5.90343C13.8777 4.68444 12.2239 4.00011 10.5 4.00011Z"
                                fill="#AAAAAA" stroke="#AAAAAA" stroke-width="0.5" />
                        </g>
                    </svg>
                </div>
                <!-- Logo -->
                <a href="#" class="header-logo">
                    <img src="<?= $base_url ?>/assets/ourPartners-logo/OptimumPayments.png" alt="Optimum Payment Solutions" />
                </a>
                <!-- Store button -->
                <a href="#" class="header-store">Store</a>
            </div>

            <!-- Menu panel (hidden until hamburger clicked) -->
            <div id="menu-panel">
                <div class="menu-items">

                    <!-- Home -->
                    <div class="menu-row" data-id="home">
                        <a href="#" class="menu-link"><span>Home</span></a>
                    </div>

                    <!-- Promo -->
                    <div class="menu-row" data-id="promo">
                        <a href="#" class="menu-link"><span>Promo</span></a>
                    </div>

                    <!-- Processing Solutions -->
                    <div class="menu-row" data-id="processing">
                        <button>
                            <span>Processing Solutions</span>
                            <span class="chevron">
                                <svg width="15" height="9" viewBox="0 0 15 9" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.25 1.25L7.25 7.25L13.25 1.25" stroke="#0E0E0E" stroke-opacity="0.7"
                                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </button>
                    </div>
                    <div class="submenu" id="sub-processing">
                        <!-- sub-items rendered by JS -->
                    </div>

                    <!-- Digital Services -->
                    <div class="menu-row" data-id="digital">
                        <button>
                            <span>Digital Services</span>
                            <span class="chevron">
                                <svg width="15" height="9" viewBox="0 0 15 9" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.25 1.25L7.25 7.25L13.25 1.25" stroke="#0E0E0E" stroke-opacity="0.7"
                                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </button>
                    </div>
                    <div class="submenu" id="sub-digital">
                        <div class="digital-inner">
                            <div class="digital-card">
                                <div class="digital-card-img">
                                    <img src="<?= $base_url ?>/assets/DigitalServices-DropDown/WebsiteDesign--DigitalService--Dropdown.png"
                                        alt="Website Design" />
                                </div>
                                <p class="digital-card-title">Website Design</p>
                                <p class="digital-card-desc">Premium designs at your finger tips</p>
                                <div class="digital-card-btns">
                                    <button class="btn-primary">Post Your Brief</button>
                                    <button class="btn-outline">View Packages</button>
                                </div>
                            </div>
                            <div class="digital-card">
                                <div class="digital-card-img">
                                    <img src="<?= $base_url ?>/assets/DigitalServices-DropDown/3D-Printing--DigitalService--Dropdown.png"
                                        alt="3D Printing" />
                                </div>
                                <p class="digital-card-title">3D Printing</p>
                                <p class="digital-card-desc">1-stop shopping for all your 3d-printed needs</p>
                                <div class="digital-card-btns">
                                    <button class="btn-primary">Post Your Brief</button>
                                    <button class="btn-outline">View Packages</button>
                                </div>
                            </div>
                            <div class="digital-card">
                                <div class="digital-card-img">
                                    <img src="<?= $base_url ?>/assets/DigitalServices-DropDown/Branding--DigitalService--Dropdown.png"
                                        alt="Branding" />
                                </div>
                                <p class="digital-card-title">Branding</p>
                                <p class="digital-card-desc">We can handle all form of your branding needs</p>
                                <div class="digital-card-btns">
                                    <button class="btn-primary">Post Your Brief</button>
                                    <button class="btn-outline">View Packages</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Business Financing -->
                    <div class="menu-row" data-id="financing">
                        <button>
                            <span>Business Financing</span>
                            <span class="chevron">
                                <svg width="15" height="9" viewBox="0 0 15 9" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.25 1.25L7.25 7.25L13.25 1.25" stroke="#0E0E0E" stroke-opacity="0.7"
                                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </button>
                    </div>
                    <div class="submenu" id="sub-financing">
                        <div class="financing-inner">
                            <div class="financing-img">
                                <img src="<?= $base_url ?>/assets/ourPartners-logo/RokFinancial.png" alt="ROK Financial" />
                            </div>
                            <p class="financing-title">Get Funding Today</p>
                            <p class="financing-desc">Premium designs at your finger tips</p>
                            <a href="#" class="financing-link">
                                Explore
                                <svg width="3" height="5" fill="none" viewBox="0 0 3 5">
                                    <path d="M0.5 4.5L2.5 2.5L0.5 0.5" stroke="#529DF3" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- About Us -->
                    <div class="menu-row" data-id="about">
                        <button>
                            <span>About Us</span>
                            <span class="chevron">
                                <svg width="15" height="9" viewBox="0 0 15 9" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.25 1.25L7.25 7.25L13.25 1.25" stroke="#0E0E0E" stroke-opacity="0.7"
                                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </button>
                    </div>
                    <div class="submenu" id="sub-about">
                        <div class="about-inner">
                            <p class="about-desc">
                                We are here to help your business accept credit cards in the most secure efficient and
                                economical way
                                possible.<br /><br />
                                Optimum Payment Solution is a premium provider of electronic transaction processing and
                                ATM Placement.
                            </p>
                            <a href="#" class="about-link">
                                Get To Know Us More
                                <svg width="3" height="5" fill="none" viewBox="0 0 3 5">
                                    <path d="M0.5 4.5L2.5 2.5L0.5 0.5" stroke="#529DF3" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                    </div>

                </div><!-- /.menu-items -->

                <!-- Footer -->
                <div class="nav-footer">
                    <div class="social-row">
                        <!-- Facebook -->
                        <a href="#" class="social-icon">
                            <img src="<?= $base_url ?>/assets/footer-icons/facebook-cta-icon.svg" alt="Facebook">
                        </a>
                        <!-- TikTok -->
                        <a href="#" class="social-icon">
                            <img src="<?= $base_url ?>/assets/footer-icons/tiktok-cta-icon.svg" alt="TikTok">
                        </a>
                        <!-- Email/Message -->
                        <a href="#" class="social-icon">
                            <img src="<?= $base_url ?>/assets/footer-icons/mail-cta-icon.svg" alt="Email">
                        </a>
                    </div>
                    <p class="copyright">&#169; Copyright 2026 Optimum Payments LLC All Rights Reserved</p>
                </div>

            </div><!-- /#menu-panel -->

        </div><!-- /.nav-wrapper -->
    </div>


