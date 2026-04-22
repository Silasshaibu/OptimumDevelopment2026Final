<!-- Ad Modal Overlay -->
<div class="ad-modal-overlay" id="adModalOverlay"></div>

<!-- Ad Modal -->
<div class="ad-modal" id="adModal">
    <button class="ad-modal-close" id="adModalClose" aria-label="Close modal">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
    
    <div class="ad-modal-content">
        <h2 class="ad-modal-title">Special Offer!</h2>
        <p class="ad-modal-description">
            Get up to 100% off on processing fees for your business.
        </p>
        <img src="<?= $base_url ?>/assets/images/modal/promo-modal/modal-ad-banner.webp" 
             alt="Special Offer" 
             class="ad-modal-image"
             id="adModalImage">
        <a href="<?= $base_url ?>/promo" class="ad-modal-cta">
            Claim Your Offer Now
        </a>
    </div>
</div>

<style>
/* Ad Modal Overlay */
.ad-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.7);
    z-index: 99998;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}

.ad-modal-overlay.active {
    opacity: 1;
    visibility: visible;
}

/* Ad Modal */
.ad-modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0.9);
    max-width: 500px;
    width: 90%;
    background: white;
    border-radius: 12px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    z-index: 99999;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.3s ease;
    overflow: hidden;
}

.ad-modal.active {
    opacity: 1;
    visibility: visible;
    transform: translate(-50%, -50%) scale(1);
}

/* Close Button */
.ad-modal-close {
    position: absolute;
    top: 15px;
    right: 15px;
    width: 36px;
    height: 36px;
    background: rgba(0, 0, 0, 0.1);
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s ease, transform 0.2s ease;
    z-index: 10;
}

.ad-modal-close:hover {
    background: rgba(0, 0, 0, 0.2);
    transform: scale(1.1);
}

.ad-modal-close svg {
    width: 20px;
    height: 20px;
    color: #333;
}

/* Modal Content */
.ad-modal-content {
    padding: 40px 30px 30px;
    text-align: center;
}

.ad-modal-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 15px;
}

.ad-modal-description {
    font-size: 1rem;
    color: #666;
    margin-bottom: 20px;
    line-height: 1.5;
}

.ad-modal-image {
    width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 20px;
}

.ad-modal-cta {
    display: inline-block;
    padding: 14px 32px;
    background: var(--color-primary, #3674A8);
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: 600;
    font-size: 1rem;
    transition: background 0.3s ease, transform 0.2s ease;
}

.ad-modal-cta:hover {
    background: var(--blue-600, #306D9C);
    transform: translateY(-2px);
}

/* Prevent body scroll when modal is active */
body.ad-modal-open {
    overflow: hidden;
}

/* Responsive */
@media (max-width: 768px) {
    .ad-modal {
        max-width: 95%;
        width: 95%;
    }

    .ad-modal-content {
        padding: 35px 20px 25px;
    }

    .ad-modal-title {
        font-size: 1.5rem;
    }

    .ad-modal-description {
        font-size: 0.9rem;
    }
}
</style>

<script>
(function() {
    // ========================================
    // DYNAMIC AD MODAL IMAGE ROTATION (7-Day Interval)
    // ========================================
    const useImageArray = false; // Set to true to enable image rotation
    const defaultImage = '<?= $base_url ?>/assets/images/modal/promo-modal/modal-ad-banner.webp';
    
    // Array of 4 ad modal images (replace with your actual images)
    const adImages = [
        '<?= $base_url ?>/assets/images/modal/promo-modal/modal-ad-banner-1.webp',
        '<?= $base_url ?>/assets/images/modal/promo-modal/modal-ad-banner-2.webp',
        '<?= $base_url ?>/assets/images/modal/promo-modal/modal-ad-banner-3.webp',
        '<?= $base_url ?>/assets/images/modal/promo-modal/modal-ad-banner-4.webp'
    ];

    const adImage = document.getElementById('adModalImage');
    if (adImage) {
        // If useImageArray is false, use default image and exit
        if (!useImageArray) {
            adImage.src = defaultImage;
        } else {
            // Get stored data from localStorage
            const storageKey = 'adModalImage';
            const stored = localStorage.getItem(storageKey);
            let currentImage = null;
            let lastChanged = null;

            if (stored) {
                try {
                    const data = JSON.parse(stored);
                    currentImage = data.image;
                    lastChanged = new Date(data.timestamp);
                } catch (e) {
                    console.error('Error parsing stored ad image data:', e);
                }
            }

            // Check if 7 days have passed
            const now = new Date();
            const sevenDaysInMs = 7 * 24 * 60 * 60 * 1000;
            const shouldChange = !lastChanged || (now - lastChanged >= sevenDaysInMs);

            // Select new image if needed
            if (shouldChange || !currentImage) {
                const randomIndex = Math.floor(Math.random() * adImages.length);
                currentImage = adImages[randomIndex];

                // Store the new selection
                localStorage.setItem(storageKey, JSON.stringify({
                    image: currentImage,
                    timestamp: now.toISOString()
                }));
            }

            // Apply the image
            adImage.src = currentImage;
        }
    }

    // ========================================
    // AD MODAL DISPLAY LOGIC
    // ========================================
    // Configuration
    const SCROLL_TRIGGER = 80; // Pixels to scroll before showing modal
    const SESSION_KEY = 'adModalShown'; // localStorage key

    // Elements
    const overlay = document.getElementById('adModalOverlay');
    const modal = document.getElementById('adModal');
    const closeBtn = document.getElementById('adModalClose');

    if (!overlay || !modal || !closeBtn) return;

    // Check if modal was already shown this session
    const hasSeenModal = sessionStorage.getItem(SESSION_KEY);
    let modalShown = false;

    // Function to show modal
    function showModal() {
        if (modalShown || hasSeenModal) return;
        
        overlay.classList.add('active');
        modal.classList.add('active');
        document.body.classList.add('ad-modal-open');
        
        modalShown = true;
        sessionStorage.setItem(SESSION_KEY, 'true');
    }

    // Function to hide modal
    function hideModal() {
        overlay.classList.remove('active');
        modal.classList.remove('active');
        document.body.classList.remove('ad-modal-open');
    }

    // Scroll event listener
    window.addEventListener('scroll', () => {
        if (window.scrollY >= SCROLL_TRIGGER) {
            showModal();
        }
    });

    // Close button click
    closeBtn.addEventListener('click', hideModal);

    // Close on overlay click
    overlay.addEventListener('click', hideModal);

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            hideModal();
        }
    });
})();
</script>
