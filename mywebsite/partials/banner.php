<!-- ============================================================
    BANNER CAROUSEL
============================================================ -->

<section class="banner-section">
    <div class="banner-carousel">

        <!-- Navigation -->
        <button class="banner-btn banner-prev" aria-label="Previous slide">‹</button>
        <button class="banner-btn banner-next" aria-label="Next slide">›</button>

        <!-- Slides -->
        <div class="banner-wrapper">

            <!-- Slide Original Text from Him -->
            <!-- <div class="banner-slide promo" data-link="<$base_url>/promo">
                <div class="banner-container">
                    <div class="banner-media promo">
                        <p class="banner-message">
                            Own a business or know someone that does?<br>
                            Earn <strong>$500</strong> and get up to 100% off new equipment*
                            <span class="bannerDirectionalArrow-CTA"> 
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon banner arrow-long-right">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3"></path>
                                </svg>
                            </span><br class="mobile-break">
                            <a href="<$base_url>/promo"><strong class="cta-promo claim-offer">Claim Offer Now!</strong></a>
                        </p>
                    </div>
                </div>
            </div> -->

            <!-- Slide C -->
            <div class="banner-slide promo" data-link="<?= $base_url ?>/promo">
                <div class="banner-container">
                    <div class="banner-media promo">
                        <p class="banner-message">                            
                            Earn <strong>$500</strong> + 100% off new POS Equipment*
                            <br class="mobile-break">
                            <a class="anchor-cta-promo" href="<?= $base_url ?>/promo"><strong class="cta-promo claim-offer">Claim Offer Now!</strong></a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Slide x -->
            <div class="banner-slide merchant-apply-form" data-link="<?= $base_url ?>/merchant-application">
                <div class="banner-container">
                    <div class="banner-media merchant-apply-form">
                        <p class="banner-message">
                            Want to eliminate up to 100% of your processing fees?
                            <br class="mobile-break">
                            <a class="anchor-cta-promo" href="/merchant-application"><strong class="cta-promo claim-offer">Click Here!</strong></a>
                        </p>
                    </div>
                </div>
            </div>

            

        </div>
    </div>
</section>


<style>
    
    .banner-slide.promo {
        background: #ccc;
    }

    .banner-slide.merchant-apply-form {
        background: orange;
    }


    .banner-message{
        color:#333;
    }
    
</style>
<script>
// ========================================
// DYNAMIC BANNER BACKGROUNDS ROTATION (2-Day Interval)
// ========================================
(function() {
    // Configuration
    const useArray = false; // Set to true to enable image rotation
    
    // Promo banner configuration
    const promoConfig = {
        defaultBg: '#ccc',
        backgrounds: [
            'url(<?= $base_url ?>/assets/images/promo/banner-promo-1.webp) center/cover no-repeat',
            'url(<?= $base_url ?>/assets/images/promo/banner-promo-1.webp) center/cover no-repeat',
            'url(<?= $base_url ?>/assets/images/promo/banner-promo-1.webp) center/cover no-repeat',
            'url(<?= $base_url ?>/assets/images/promo/banner-promo-1.webp) center/cover no-repeat',
            'url(<?= $base_url ?>/assets/images/promo/banner-promo-1.webp) center/cover no-repeat',
            'url(<?= $base_url ?>/assets/images/promo/banner-promo-1.webp) center/cover no-repeat',
            'url(<?= $base_url ?>/assets/images/promo/banner-promo-1.webp) center/cover no-repeat'
        ],
        storageKey: 'promoBannerBg'
    };
    
    // Merchant apply form banner configuration
    const merchantConfig = {
        defaultBg: 'orange',
        backgrounds: [
            'url(<?= $base_url ?>/assets/images/promo/banner-merchant-1.webp) center/cover no-repeat',
            'url(<?= $base_url ?>/assets/images/promo/banner-merchant-1.webp) center/cover no-repeat',
            'url(<?= $base_url ?>/assets/images/promo/banner-merchant-1.webp) center/cover no-repeat',
            'url(<?= $base_url ?>/assets/images/promo/banner-merchant-1.webp) center/cover no-repeat',
            'url(<?= $base_url ?>/assets/images/promo/banner-merchant-1.webp) center/cover no-repeat',
            'url(<?= $base_url ?>/assets/images/promo/banner-merchant-1.webp) center/cover no-repeat',
            'url(<?= $base_url ?>/assets/images/promo/banner-merchant-1.webp) center/cover no-repeat'
        ],
        storageKey: 'merchantBannerBg'
    };

    // Function to apply background rotation
    function applyBannerRotation(selector, config) {
        const banner = document.querySelector(selector);
        if (!banner) return;

        // If useArray is false, use default background and exit
        if (!useArray) {
            banner.style.background = config.defaultBg;
            return;
        }

        // Get stored data from localStorage
        const stored = localStorage.getItem(config.storageKey);
        let currentBg = null;
        let lastChanged = null;

        if (stored) {
            try {
                const data = JSON.parse(stored);
                currentBg = data.background;
                lastChanged = new Date(data.timestamp);
            } catch (e) {
                console.error('Error parsing stored banner data:', e);
            }
        }

        // Check if 2 days have passed
        const now = new Date();
        const twoDaysInMs = 2 * 24 * 60 * 60 * 1000;
        const shouldChange = !lastChanged || (now - lastChanged >= twoDaysInMs);

        // Select new background if needed
        if (shouldChange || !currentBg) {
            const randomIndex = Math.floor(Math.random() * config.backgrounds.length);
            currentBg = config.backgrounds[randomIndex];

            // Store the new selection
            localStorage.setItem(config.storageKey, JSON.stringify({
                background: currentBg,
                timestamp: now.toISOString()
            }));
        }

        // Apply the background
        banner.style.background = currentBg;
    }

    // Apply rotation to both banners
    applyBannerRotation('.banner-slide.promo', promoConfig);
    applyBannerRotation('.banner-slide.merchant-apply-form', merchantConfig);
})();
</script>