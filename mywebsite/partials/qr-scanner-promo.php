<div class="qr-promo-sidebar" id="qrPromoSidebar">
    <div class="qr-promo-content">
        <span class="qr-promo-text-top">Scan To</span>
        <div class="qr-promo-image">
            <img src="<?= $base_url ?>/assets/images/qr-code-sample.svg" alt="Scan QR Code" loading="lazy">
        </div>
        <span class="qr-promo-text-bottom">Get Free</span>
        <span class="qr-promo-text-bottom">Equipment</span>
    </div>
</div>

<!-- QR Code Modal -->
<div class="qr-modal-overlay" id="qrModalOverlay">
    <div class="qr-modal-container">
        <button class="qr-modal-close" id="qrModalClose">&times;</button>
        <div class="qr-modal-content">
            <h2 class="qr-modal-title">Scan QR Code</h2>
            <p class="qr-modal-subtitle">Get Free Equipment Today!</p>
            <div class="qr-modal-image">
                <img src="<?= $base_url ?>/assets/images/qr-code-sample.svg" alt="Scan QR Code" loading="lazy">
            </div>
            <p class="qr-modal-instructions">Point your phone's camera at the QR code to get started</p>
        </div>
    </div>
</div>

<style>
.qr-promo-sidebar {
    position: fixed;
    left: -120px;
    top: 50%;
    transform: translateY(-50%);
    width: 110px;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border: 2px solid var(--color-primary, #00a651);
    border-left: none;
    border-radius: 0 12px 12px 0;
    box-shadow: 2px 4px 12px rgba(0, 0, 0, 0.15);
    padding: 15px 10px;
    z-index: 9997;
    transition: left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    opacity: 0;
    pointer-events: none;
    cursor: pointer;
}

.qr-promo-sidebar:hover {
    transform: translateY(-50%) scale(1.02);
}

.qr-promo-sidebar.visible {
    left: 0;
    opacity: 1;
    pointer-events: auto;
}

.qr-promo-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    pointer-events: none;
}

.qr-promo-text-top {
    font-size: 14px;
    font-weight: 700;
    color: var(--color-primary, #00a651);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-align: center;
}

.qr-promo-image {
    width: 80px;
    height: 80px;
    padding: 5px;
    background: white;
    border: 2px solid var(--color-primary, #00a651);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.qr-promo-image img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.qr-promo-text-bottom {
    font-size: 13px;
    font-weight: 700;
    color: #333;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    text-align: center;
    line-height: 1.2;
}

/* QR Modal Styles */
.qr-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(5px);
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}

.qr-modal-overlay.active {
    opacity: 1;
    visibility: visible;
}

.qr-modal-container {
    background: white;
    border-radius: 20px;
    padding: 40px;
    max-width: 500px;
    width: 90%;
    position: relative;
    transform: scale(0.7);
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.qr-modal-overlay.active .qr-modal-container {
    transform: scale(1);
}

.qr-modal-close {
    position: absolute;
    top: 15px;
    right: 15px;
    background: #f8f9fa;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    font-size: 28px;
    line-height: 1;
    cursor: pointer;
    color: #333;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.qr-modal-close:hover {
    background: var(--color-primary, #00a651);
    color: white;
    transform: rotate(90deg);
}

.qr-modal-content {
    text-align: center;
}

.qr-modal-title {
    font-size: 28px;
    font-weight: 700;
    color: var(--color-primary, #00a651);
    margin: 0 0 10px 0;
}

.qr-modal-subtitle {
    font-size: 18px;
    font-weight: 600;
    color: #333;
    margin: 0 0 30px 0;
}

.qr-modal-image {
    width: 300px;
    height: 300px;
    margin: 0 auto 20px;
    padding: 20px;
    background: white;
    border: 3px solid var(--color-primary, #00a651);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(0, 166, 81, 0.2);
}

.qr-modal-image img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.qr-modal-instructions {
    font-size: 14px;
    color: #666;
    margin: 0;
    line-height: 1.5;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .qr-promo-sidebar {
        width: 90px;
        padding: 12px 8px;
        left: -100px;
    }
    
    .qr-promo-text-top {
        font-size: 12px;
    }
    
    .qr-promo-image {
        width: 65px;
        height: 65px;
    }
    
    .qr-promo-text-bottom {
        font-size: 11px;
    }

    .qr-modal-container {
        padding: 30px 20px;
    }

    .qr-modal-title {
        font-size: 24px;
    }

    .qr-modal-subtitle {
        font-size: 16px;
    }

    .qr-modal-image {
        width: 250px;
        height: 250px;
    }
}

/* Hide on very small screens */
@media (max-width: 480px) {
    .qr-promo-sidebar {
        display: none;
    }

    .qr-modal-image {
        width: 220px;
        height: 220px;
    }
}
</style>

<script>
(function() {
    const qrPromo = document.getElementById('qrPromoSidebar');
    const qrModal = document.getElementById('qrModalOverlay');
    const qrModalClose = document.getElementById('qrModalClose');
    const scrollThreshold = 1500;
    const timeThreshold = 20000; // 20 seconds
    const visibilityDuration = 30000; // 30 seconds
    
    let visibilityTimer = null;
    let isVisible = false;
    let hasBeenShown = false;
    let timeConditionMet = false;
    let scrollConditionMet = false;
    let footerIsVisible = false;
    
    function checkAndShow() {
        if (timeConditionMet && scrollConditionMet && !hasBeenShown && !isVisible && !footerIsVisible) {
            qrPromo.classList.add('visible');
            isVisible = true;
            hasBeenShown = true;
            
            // Start timer to hide after 30 seconds
            visibilityTimer = setTimeout(() => {
                qrPromo.classList.remove('visible');
                isVisible = false;
            }, visibilityDuration);
        }
    }
    
    // Start time-based condition (20 seconds)
    setTimeout(() => {
        timeConditionMet = true;
        checkAndShow();
    }, timeThreshold);
    
    function handleScroll() {
        const scrollY = window.scrollY || window.pageYOffset;
        
        if (scrollY >= scrollThreshold && !scrollConditionMet) {
            scrollConditionMet = true;
            checkAndShow();
        }
    }
    
    // Open modal on sidebar click
    qrPromo.addEventListener('click', function() {
        qrModal.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        // Hide sidebar and clear timers when modal opens
        qrPromo.classList.remove('visible');
        isVisible = false;
        if (visibilityTimer) clearTimeout(visibilityTimer);
    });

    // Close modal on close button
    qrModalClose.addEventListener('click', function() {
        qrModal.classList.remove('active');
        document.body.style.overflow = '';
    });

    // Close modal on overlay click
    qrModal.addEventListener('click', function(e) {
        if (e.target === qrModal) {
            qrModal.classList.remove('active');
            document.body.style.overflow = '';
        }
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && qrModal.classList.contains('active')) {
            qrModal.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
    
    // Initial check
    handleScroll();
    
    // Listen to scroll events
    window.addEventListener('scroll', handleScroll, { passive: true });
    
    // Footer intersection observer to hide QR sidebar when footer comes into view
    const footer = document.querySelector('.footer-container');
    if (footer) {
        const footerObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Footer is visible, hide QR sidebar and prevent it from showing
                    footerIsVisible = true;
                    qrPromo.classList.remove('visible');
                    isVisible = false;
                    if (visibilityTimer) clearTimeout(visibilityTimer);
                } else {
                    // Footer is not visible anymore
                    footerIsVisible = false;
                }
            });
        }, {
            threshold: 0.1 // Trigger when 10% of footer is visible
        });
        
        footerObserver.observe(footer);
    }
})();
</script>
