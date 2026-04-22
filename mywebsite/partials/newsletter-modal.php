<!-- Newsletter Modal Overlay -->
<div class="newsletter-modal-overlay" id="newsletterModalOverlay"></div>

<!-- Newsletter Modal -->
<div class="newsletter-modal" id="newsletterModal">
    <button class="newsletter-modal-close" id="newsletterModalClose" aria-label="Close modal">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
    
    <div class="newsletter-modal-content">
        <img src="<?= $base_url ?>/assets/images/modal/equipment-alert-modal/equipment-alert-banner.webp" 
             alt="Equipment Alert" 
             class="newsletter-modal-image"
             id="newsletterModalImage">
        
        <h2 class="newsletter-modal-title">Don't Miss Out!</h2>
        <p class="newsletter-modal-description">
            Get instant alerts when new free equipment and exclusive offers become available. Be the first to know!
        </p>
        
        <form class="newsletter-form" id="newsletterForm">
            <div class="newsletter-input-wrapper">
                <input type="email" 
                       id="newsletterEmail" 
                       name="email" 
                       placeholder="Enter your email for free equipment alerts" 
                       required
                       autocomplete="email"
                       class="newsletter-input">
                <button type="submit" class="newsletter-submit-btn">
                    Notify Me
                </button>
            </div>
            <p class="newsletter-privacy-note">
                We respect your privacy. Unsubscribe at any time.
            </p>
        </form>
    </div>
</div>

<style>
/* Newsletter Modal Overlay */
.newsletter-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.7);
    z-index: 99996;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}

.newsletter-modal-overlay.active {
    opacity: 1;
    visibility: visible;
}

/* Newsletter Modal */
.newsletter-modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0.9);
    max-width: 500px;
    width: 90vw;
    background: white;
    border-radius: 12px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    z-index: 99997;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.3s ease;
    overflow: hidden;
}

.newsletter-modal.active {
    opacity: 1;
    visibility: visible;
    transform: translate(-50%, -50%) scale(1);
}

/* Close Button */
.newsletter-modal-close {
    position: absolute;
    top: 15px;
    right: 15px;
    width: 36px;
    height: 36px;
    background: rgba(255, 255, 255, 0.9);
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s ease, transform 0.2s ease;
    z-index: 10;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.newsletter-modal-close:hover {
    background: white;
    transform: scale(1.1);
}

.newsletter-modal-close svg {
    width: 20px;
    height: 20px;
    color: #333;
}

/* Modal Content */
.newsletter-modal-content {
    padding: 0;
    text-align: center;
}

.newsletter-modal-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    display: block;
}

.newsletter-modal-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #333;
    margin: 25px 30px 10px;
}

.newsletter-modal-description {
    font-size: 0.95rem;
    color: #666;
    margin: 0 30px 25px;
    line-height: 1.5;
}

/* Newsletter Form */
.newsletter-form {
    padding: 0 30px 30px;
}

.newsletter-input-wrapper {
    display: flex;
    gap: 8px;
    margin-bottom: 12px;
}

.newsletter-input {
    flex: 1;
    padding: 12px 16px;
    border: 2px solid #e0e0e0;
    border-radius: 6px;
    font-size: 0.95rem;
    transition: border-color 0.2s ease;
}

.newsletter-input:focus {
    outline: none;
    border-color: var(--color-primary, #3674A8);
}

.newsletter-submit-btn {
    padding: 12px 24px;
    background: var(--color-primary, #3674A8);
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.2s ease;
    white-space: nowrap;
}

.newsletter-submit-btn:hover {
    background: var(--blue-600, #306D9C);
    transform: translateY(-1px);
}

.newsletter-privacy-note {
    font-size: 0.75rem;
    color: #999;
    margin: 0;
}

/* Prevent body scroll when modal is active */
body.newsletter-modal-open {
    overflow: hidden;
}

/* Responsive */
@media (max-width: 768px) {
    .newsletter-modal {
        max-width: 95%;
        width: 95%;
    }

    .newsletter-modal-title {
        font-size: 1.5rem;
        margin: 20px 20px 10px;
    }

    .newsletter-modal-description {
        font-size: 0.9rem;
        margin: 0 20px 20px;
    }

    .newsletter-form {
        padding: 0 20px 25px;
    }

    .newsletter-input-wrapper {
        flex-direction: column;
    }

    .newsletter-submit-btn {
        width: 100%;
    }
}
</style>

<script>
(function() {
    // ========================================
    // DYNAMIC NEWSLETTER MODAL IMAGE ROTATION (7-Day Interval)
    // ========================================
    const useImageArray = false; // Set to true to enable image rotation
    const defaultImage = '<?= $base_url ?>/assets/images/modal/equipment-alert-modal/equipment-alert-banner.webp';
    
    // Array of 4 equipment alert modal images
    const alertImages = [
        '<?= $base_url ?>/assets/images/modal/equipment-alert-modal/equipment-alert-banner-1.webp',
        '<?= $base_url ?>/assets/images/modal/equipment-alert-modal/equipment-alert-banner-2.webp',
        '<?= $base_url ?>/assets/images/modal/equipment-alert-modal/equipment-alert-banner-3.webp',
        '<?= $base_url ?>/assets/images/modal/equipment-alert-modal/equipment-alert-banner-4.webp'
    ];

    const newsletterImage = document.getElementById('newsletterModalImage');
    if (newsletterImage) {
        // If useImageArray is false, use default image
        if (!useImageArray) {
            newsletterImage.src = defaultImage;
        } else {
            // Get stored data from localStorage
            const storageKey = 'newsletterModalImage';
            const stored = localStorage.getItem(storageKey);
            let currentImage = null;
            let lastChanged = null;

            if (stored) {
                try {
                    const data = JSON.parse(stored);
                    currentImage = data.image;
                    lastChanged = new Date(data.timestamp);
                } catch (e) {
                    console.error('Error parsing stored newsletter image data:', e);
                }
            }

            // Check if 7 days have passed
            const now = new Date();
            const sevenDaysInMs = 7 * 24 * 60 * 60 * 1000;
            const shouldChange = !lastChanged || (now - lastChanged >= sevenDaysInMs);

            // Select new image if needed
            if (shouldChange || !currentImage) {
                const randomIndex = Math.floor(Math.random() * alertImages.length);
                currentImage = alertImages[randomIndex];

                // Store the new selection
                localStorage.setItem(storageKey, JSON.stringify({
                    image: currentImage,
                    timestamp: now.toISOString()
                }));
            }

            // Apply the image
            newsletterImage.src = currentImage;
        }
    }

    // ========================================
    // NEWSLETTER MODAL DISPLAY LOGIC
    // ========================================
    const BOTTOM_THRESHOLD = 100; // Pixels from bottom to trigger modal
    const SESSION_KEY = 'newsletterModalShown';

    // Elements
    const overlay = document.getElementById('newsletterModalOverlay');
    const modal = document.getElementById('newsletterModal');
    const closeBtn = document.getElementById('newsletterModalClose');
    const form = document.getElementById('newsletterForm');

    if (!overlay || !modal || !closeBtn || !form) return;

    // Check if modal was already shown this session
    const hasSeenModal = sessionStorage.getItem(SESSION_KEY);
    let modalShown = false;

    // Check if ad modal is currently active
    function isAdModalActive() {
        const adModal = document.getElementById('adModal');
        const adOverlay = document.getElementById('adModalOverlay');
        return adModal && adModal.classList.contains('active') || 
               adOverlay && adOverlay.classList.contains('active');
    }

    // Check if user reached bottom of page
    function isNearBottom() {
        const scrollPosition = window.scrollY + window.innerHeight;
        const pageHeight = document.documentElement.scrollHeight;
        return pageHeight - scrollPosition <= BOTTOM_THRESHOLD;
    }

    // Function to show modal
    function showModal() {
        if (modalShown || hasSeenModal || isAdModalActive()) return;
        
        overlay.classList.add('active');
        modal.classList.add('active');
        document.body.classList.add('newsletter-modal-open');
        
        modalShown = true;
        sessionStorage.setItem(SESSION_KEY, 'true');
    }

    // Function to hide modal
    function hideModal() {
        overlay.classList.remove('active');
        modal.classList.remove('active');
        document.body.classList.remove('newsletter-modal-open');
    }

    // Scroll event listener - trigger when near bottom
    window.addEventListener('scroll', () => {
        if (isNearBottom()) {
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

    // Form submission
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const email = document.getElementById('newsletterEmail').value;
        const submitBtn = form.querySelector('.newsletter-submit-btn');
        const originalText = submitBtn.textContent;
        
        // Disable button and show loading state
        submitBtn.disabled = true;
        submitBtn.textContent = 'Setting up alerts...';
        
        try {
            // TODO: Replace with your actual newsletter subscription endpoint
            // const response = await fetch('<?= $base_url ?>/_system/subscribe_newsletter.php', {
            //     method: 'POST',
            //     headers: { 'Content-Type': 'application/json' },
            //     body: JSON.stringify({ email })
            // });
            
            // Simulate API call for now
            await new Promise(resolve => setTimeout(resolve, 1000));
            
            // Success
            submitBtn.textContent = '✓ You\'re all set!';
            submitBtn.style.background = '#10b981';
            
            // Close modal after 2 seconds
            setTimeout(() => {
                hideModal();
                form.reset();
                submitBtn.textContent = originalText;
                submitBtn.style.background = '';
                submitBtn.disabled = false;
            }, 2000);
            
        } catch (error) {
            console.error('Newsletter subscription error:', error);
            submitBtn.textContent = 'Try Again';
            submitBtn.disabled = false;
            alert('Failed to subscribe. Please try again.');
        }
    });
})();
</script>
