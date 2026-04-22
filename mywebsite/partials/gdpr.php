
    

    <!-- Add this at the end of your <body> GDPR Multi-Choice Cookie Banner -->
    <div id="gdpr-banner" class="gdpr-coookie-intro-request-modal">
        <div class="gdpr-banner-content">
            <h3>Your Privacy Matters to Optimum Payments</h3>
            <p>We use cookies to enhance your experience with our payment processing and merchant services platform. Choose which cookies you'd like to allow:</p>
            
            <div class="gdpr-options-container">
                <div class="cookie-option">
                    <label>
                        <input type="checkbox" id="cookie-essential" checked disabled>
                        <span class="cookie-label">Essential Cookies</span>
                    </label>
                    <small>Required for payment processing, security, fraud prevention, and basic site functionality. Cannot be disabled.</small>
                </div>
                
                <div class="cookie-option">
                    <label>
                        <input type="checkbox" id="cookie-analytics">
                        <span class="cookie-label">Analytics Cookies</span>
                    </label>
                    <small>Help us understand how visitors use our site (Google Analytics). Used to improve performance and user experience.</small>
                </div>
                
                <div class="cookie-option">
                    <label>
                        <input type="checkbox" id="cookie-marketing">
                        <span class="cookie-label">Marketing Cookies</span>
                    </label>
                    <small>Track visits across websites for personalized content and promotions (Facebook Pixel, Google Ads).</small>
                </div>
            </div>

            <div class="gdpr-actions">
                <button class="gdpr-button accept-all" id="accept-all">Accept All</button>
                <button class="gdpr-button accept-selected" id="accept-selected">Save My Preferences</button>
                <button class="gdpr-button reject-all" id="reject-all">Essential Only</button>
            </div>
            
            <div class="gdpr-footer">
                <a class="gdpr-anchor" href="<?= $base_url ?>/privacy-policy">Read Our Full Privacy Policy</a>
                <span class="gdpr-divider">|</span>
                <a class="gdpr-anchor" href="#" id="manage-cookies">Manage Cookie Settings</a>
            </div>
        </div>
    </div>

 
    <?php
    $gaTrackingId = trim((string)($env['GA_TRACKING_ID'] ?? ''));
    if (strtoupper($gaTrackingId) === 'GA_TRACKING_ID') {
        $gaTrackingId = '';
    }
    $facebookPixelId = trim((string)($env['FACEBOOK_PIXEL_ID'] ?? ''));
    if (strtoupper($facebookPixelId) === 'YOUR_PIXEL_ID') {
        $facebookPixelId = '';
    }
    ?>

    <!-- JS Script Consent Management & Script Loading -->
    <script>
    const gdprGaTrackingId = <?= json_encode($gaTrackingId) ?>;
    const gdprFacebookPixelId = <?= json_encode($facebookPixelId) ?>;

    // Check if consent already given
    function checkConsent() {
        let consent = JSON.parse(localStorage.getItem('gdprConsent') || '{}');
        if(!consent.accepted) {
            document.getElementById('gdpr-banner').style.display = 'block';
        } else {
            loadScripts(consent);
        }
    }

    // Accept All Cookies
    document.getElementById('accept-all').addEventListener('click', function() {
        let consent = {
            accepted: true,
            essential: true,
            analytics: true,
            marketing: true
        };
        saveConsent(consent);
    });

    // Save Selected Preferences
    document.getElementById('accept-selected').addEventListener('click', function() {
        let consent = {
            accepted: true,
            essential: true, // always true
            analytics: document.getElementById('cookie-analytics').checked,
            marketing: document.getElementById('cookie-marketing').checked
        };
        saveConsent(consent);
    });

    // Reject All (Essential Only)
    document.getElementById('reject-all').addEventListener('click', function() {
        let consent = {
            accepted: true,
            essential: true,
            analytics: false,
            marketing: false
        };
        saveConsent(consent);
    });

    // Manage Cookies - Reopen Banner
    document.getElementById('manage-cookies').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('gdpr-banner').style.display = 'block';
    });

    // Save consent and hide banner
    function saveConsent(consent) {
        localStorage.setItem('gdprConsent', JSON.stringify(consent));
        document.getElementById('gdpr-banner').style.display = 'none';
        loadScripts(consent);
        sendConsentToServer(consent);
    }

    // Load scripts based on consent
    function loadScripts(consent) {
        if(consent.analytics && gdprGaTrackingId) {
            if (!window.gtag) {
                const gaScript = document.createElement('script');
                gaScript.async = true;
                gaScript.src = 'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(gdprGaTrackingId);
                document.head.appendChild(gaScript);
            }

            window.dataLayer = window.dataLayer || [];
            window.gtag = window.gtag || function(){window.dataLayer.push(arguments);};
            window.gtag('js', new Date());
            window.gtag('config', gdprGaTrackingId);
        }

        if(consent.marketing && gdprFacebookPixelId) {
            // Facebook Pixel
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', gdprFacebookPixelId);
            fbq('track', 'PageView');
        }
    }

    // Send consent to server for logging
    function sendConsentToServer(consent) {
        fetch('<?= $base_url ?>/consent.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(consent)
        }).catch(err => console.log('Consent logging failed:', err));
    }

    // Run on page load
    window.addEventListener('load', checkConsent);
    </script>

    <style>
        .gdpr-coookie-intro-request-modal {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100vw;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: #fff;
            padding: 0;
            z-index: 99999;
            display: none;
            font-family: var(--font-family, sans-serif);
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.3);
        }

        .gdpr-banner-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .gdpr-banner-content h3 {
            margin: 0 0 0.5rem 0;
            font-size: 1.5rem;
            color: #fff;
            font-weight: 600;
        }

        .gdpr-banner-content > p {
            margin: 0 0 1.5rem 0;
            color: #cbd5e1;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .gdpr-options-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .cookie-option {
            background: rgba(255, 255, 255, 0.05);
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.2s ease;
        }

        .cookie-option:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--color-primary, #3674A8);
        }

        .cookie-option label {
            display: flex;
            align-items: center;
            cursor: pointer;
            margin-bottom: 0.5rem;
        }

        .cookie-option input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-right: 10px;
            cursor: pointer;
            accent-color: var(--color-primary, #3674A8);
        }

        .cookie-option input[type="checkbox"]:disabled {
            cursor: not-allowed;
            opacity: 0.6;
        }

        .cookie-label {
            font-weight: 600;
            color: #fff;
            font-size: 1rem;
        }

        .cookie-option small {
            display: block;
            color: #94a3b8;
            font-size: 0.85rem;
            line-height: 1.4;
        }

        .gdpr-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin: 1.5rem 0 1rem 0;
        }

        .gdpr-button {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        .gdpr-button.accept-all {
            background: var(--color-primary, #3674A8);
            color: #fff;
        }

        .gdpr-button.accept-all:hover {
            background: var(--blue-700, #245275);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(54, 116, 168, 0.3);
        }

        .gdpr-button.accept-selected {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .gdpr-button.accept-selected:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--color-primary, #3674A8);
        }

        .gdpr-button.reject-all {
            background: transparent;
            color: #94a3b8;
            border: 1px solid #475569;
        }

        .gdpr-button.reject-all:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #cbd5e1;
        }

        .gdpr-footer {
            text-align: center;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        a.gdpr-anchor {
            text-decoration: none;
            font-weight: 500;
            color: var(--color-primary, #3674A8);
            transition: color 0.2s ease;
            font-size: 0.9rem;
        }

        a.gdpr-anchor:hover {
            color: var(--blue-300, #8AB8DB);
            text-decoration: underline;
        }

        .gdpr-divider {
            margin: 0 1rem;
            color: #475569;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .gdpr-banner-content {
                padding: 1.5rem 1rem;
            }

            .gdpr-banner-content h3 {
                font-size: 1.25rem;
            }

            .gdpr-options-container {
                grid-template-columns: 1fr;
            }

            .gdpr-actions {
                flex-direction: column;
            }

            .gdpr-button {
                width: 100%;
            }

            .gdpr-footer {
                flex-direction: column;
                gap: 0.5rem;
            }

            .gdpr-divider {
                display: none;
            }
        }
    </style>
