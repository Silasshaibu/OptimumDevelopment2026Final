
        <div class="hero">
            <div class="hero-content">
                <div class="hero-text-wrapper">
                <h1 class="hero-title promo display-70">
                    Own a business 
                    <div class="promo display-70 special-accent mod">OR</div></h1>
                  <h1 class="hero-title promo display-70 "> know someone that does?</h1>                     
                <p class="hero-subtitle display-70">
                    <strong><span class="special-accent-promo-intro">Save up to 100%</span> on processing fees and <span class="special-accent-promo-intro">get up to 100% off</span> new equipment*
                </p> 
                </div>
                
                <div class="hero-cta-wrapper">
                        <button class="btn-primary promo-cta-text" id="claimOfferBtn">CLAIM OFFER NOW</button>
                        <span class="terms-text">Terms apply. Choose the option that suits you!</span>
                </div>
            </div>
        </div>
        

        <!--Promo Body Start-->
        <div class="cards-grid">
        <!-- Card 1 -->
        <div class="card ">
            <h3 class="card-title">Mobile businesses, auto shops, medical, and much more! </h3>
            <p class="card-description">Let our system propel your business to bigger profits,      deeper loyalty and greater operational excellence.</p>
            <img class="mobileBusiness-UnionImage" src="<?= $base_url ?>/assets/images/promo/union_platform-webp.webp" width="50%" height="fit-content">
            
        </div>
        <!-- Card 1 -->
        <div class="card ">
            <h3 class="card-title">Retail</h3>
            <p class="card-description"> All-in-one system built for small-medium sized restaurant and retail businesses.  </p>
             <img class="retail-CloverSetImage" src="<?= $base_url ?>/assets/images/promo/duo2022-printer-mini3-flex3-go3.webp" width="75%" height="fit-content" alt="">
        </div>
        <!-- Card 1 -->
        <div class="card ">
            <h3 class="card-title">Mobile businesses, auto shops, medical, and much more!                        </h3>
            <p class="card-description">Flexible, portable terminals for a variety of business types, from mobile services to medical facilities.
                        </p>
                         <img class="mobileBusiness-HandHeldPOS-sets" src="<?= $base_url ?>/assets/images/promo/Valor_with-CloverFlex-trans.webp" width="25%" height="fit-content">
        </div>  
        </div>
        <!--Promo Body End-->
        


        <!-- ============================
            TAB BUTTONS
        ============================ -->
        <div class="tabs" role="tablist">
            <button class="tab-button active" data-tab="tab1" aria-selected="true">
            Refer A Business (Earn $500)
            </button>

            <button class="tab-button" data-tab="tab2" aria-selected="false">
            For Business Owners
            </button>
        </div>

        <!-- ============================
            TAB 1
        ============================ -->
        <section id="tab1" class="promoSection tab-content active" role="tabpanel">
            <div class="form-section promo">

            <p class="Terms-Apply-Promo">
                *Free equipment and referral payout is based on processing amounts.
            </p>

            <div class="form-section promo-info">
                <p class="subtitle display">
                Refer them and get paid up to $500* when they start processing!
                </p>
            </div>

            <form id="referralForm">
                <fieldset class="mainContainer-formOnly">
                <legend class="promo-info-formtype">REFER A BUSINESS</legend>

                <div class="promo-info-formtype--wrapper">

                    <div class="form-section-header">
                        <h3 class="section-title">Your Information (Referrer)</h3>
                    </div>

                    <div>
                    <label for="referrerName">Your Name</label>
                    <input id="referrerName" name="referrerName" type="text" placeholder="Your Name" required autocomplete="name">
                    </div>

                    <div>
                    <label for="referrerPhone">Phone</label>
                    <input id="referrerPhone" name="referrerPhone" type="tel" placeholder="+1 (555) 555-5555" required autocomplete="tel">
                    </div>

                    <div>
                    <label for="referrerEmail">Email*</label>
                    <input id="referrerEmail" name="referrerEmail" type="email" placeholder="example@email.com" required autocomplete="email">
                    </div>

                    <div class="form-section-header">
                        <h3 class="section-title">Business Being Referred</h3>
                    </div>

                    <div>
                    <label for="refBusinessName">Business Name</label>
                    <input id="refBusinessName" name="refBusinessName" type="text" placeholder="Business Name" required autocomplete="off">
                    </div>

                    <div>
                    <label for="refOwnerName">Owner's Name</label>
                    <input id="refOwnerName" name="refOwnerName" type="text" placeholder="Owner's Name" required autocomplete="off">
                    </div>

                    <div id="refOwnerPhoneWrapper">
                    <label for="refOwnerPhone">Business Owner's Phone Number</label>
                    <input id="refOwnerPhone" name="refOwnerPhone" type="tel" placeholder="+1 (555) 555-5555" required autocomplete="off">
                    </div>

                    <div>
                    <label for="refOwnerEmail">Business Email*</label>
                    <input id="refOwnerEmail" name="refOwnerEmail" type="email" placeholder="example@email.com" autocomplete="off">
                    </div>

                </div>

                <button class="btn-primary cta-business btn-fullwidth" type="submit">Submit</button>

                </fieldset>
            </form>
            </div>
        </section>

        <!-- ============================
            TAB 2
        ============================ -->
        <section id="tab2" class="promoSection tab-content" role="tabpanel">
            <div class="form-section promo mainContainer-formOnly">

            <p class="Terms-Apply-Promo">
                *Free equipment and referral payout is based on processing amounts.
            </p>

            <div class="form-section promo-info">
                <p class="subtitle display">
                Save up to 100% on processing fees and <br >
                get up to 100% off new upgraded equipment?
                </p>
            </div>

            <form id="businessOwnerForm">
                <fieldset class="mainContainer-form-with-infosection">
                <legend class="promo-info-formtype">FOR BUSINESS OWNERS</legend>

                <label for="ownerName">Your Name</label>
                <input id="ownerName" name="ownerName" type="text" placeholder="Your Name" required autocomplete="name">

                <label for="businessName">Business Name</label>
                <input id="businessName" name="businessName" type="text" placeholder="Business Name" required autocomplete="organization">

                <label for="ownerPhone">Phone</label>
                <input id="ownerPhone" name="ownerPhone" type="tel" placeholder="+1 (555) 555-5555" required autocomplete="tel">

                <label for="ownerEmail">Email*</label>
                <input id="ownerEmail" name="ownerEmail" type="email" placeholder="example@email.com" required autocomplete="email">

                <button class="btn-primary cta-business btn-fullwidth" type="submit">Submit</button>
                </fieldset>
            </form>

            </div>
        </section>

        <!-- ============================
            SCRIPT 
        ============================ -->
        <script>
        // Tab Switching
        const tabs = document.querySelectorAll(".tab-button");
        const contents = document.querySelectorAll(".tab-content");

        tabs.forEach(tab => {
            tab.addEventListener("click", () => {
            tabs.forEach(t => {
                t.classList.remove("active");
                t.setAttribute("aria-selected", "false");
            });
            contents.forEach(c => c.classList.remove("active"));

            tab.classList.add("active");
            tab.setAttribute("aria-selected", "true");
            document.getElementById(tab.dataset.tab).classList.add("active");
            });
        });

        // Validation Functions
        function validateEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }

        function validatePhone(phone) {
            const digits = phone.replace(/^\+1\s*/, '').replace(/\D/g, '');
            return digits.length === 10;
        }

        // Phone number formatting with fixed +1 prefix
        function formatPhoneWithPrefix(value) {
            const prefix = '+1 ';
            let digits = value.replace(/^\+1\s*/, '').replace(/\D/g, '');
            digits = digits.slice(0, 10);
            
            if (digits.length === 0) {
                return prefix;
            } else if (digits.length <= 3) {
                return `${prefix}(${digits}`;
            } else if (digits.length <= 6) {
                return `${prefix}(${digits.slice(0, 3)}) ${digits.slice(3)}`;
            } else {
                return `${prefix}(${digits.slice(0, 3)}) ${digits.slice(3, 6)}-${digits.slice(6)}`;
            }
        }

        // Real-time phone number duplicate checking
        function checkPhoneMatch() {
            const referrerPhone = document.getElementById('referrerPhone').value;
            const refOwnerPhone = document.getElementById('refOwnerPhone').value;
            const wrapper = document.getElementById('refOwnerPhoneWrapper');
            const refOwnerInput = document.getElementById('refOwnerPhone');

            if (referrerPhone && refOwnerPhone && referrerPhone === refOwnerPhone) {
                wrapper.classList.add('phone-match-error');
                refOwnerInput.style.borderColor = '#dc3545';
            } else {
                wrapper.classList.remove('phone-match-error');
                refOwnerInput.style.borderColor = '';
            }
        }

        function showMessage(messageId, message, type) {
            const titles = {
                success: 'Success!',
                error: 'Error'
            };
            showNotificationModal(type, titles[type] || 'Notice', message);
        }

        // ==========================================
        // REFERRAL FORM (Tab 1)
        // ==========================================
        document.getElementById('referralForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            // Get form data
            const formData = new FormData(e.target);
            const errors = [];

            // Validate referrer information
            const referrerName = formData.get('referrerName');
            if (!referrerName || referrerName.trim().length < 2) {
                errors.push('Please enter your full name');
            }

            const referrerEmail = formData.get('referrerEmail');
            if (!referrerEmail || !validateEmail(referrerEmail)) {
                errors.push('Please enter a valid email address');
            }

            const referrerPhone = formData.get('referrerPhone');
            if (!referrerPhone || !validatePhone(referrerPhone)) {
                errors.push('Please enter a valid phone number');
            }

            // Validate business information
            const refBusinessName = formData.get('refBusinessName');
            if (!refBusinessName || refBusinessName.trim().length < 2) {
                errors.push('Please enter the business name');
            }

            const refOwnerName = formData.get('refOwnerName');
            if (!refOwnerName || refOwnerName.trim().length < 2) {
                errors.push('Please enter the business owner\'s name');
            }

            const refOwnerPhone = formData.get('refOwnerPhone');
            if (!refOwnerPhone || !validatePhone(refOwnerPhone)) {
                errors.push('Please enter a valid business owner\'s phone number');
            }

            const refOwnerEmail = formData.get('refOwnerEmail');
            if (refOwnerEmail && !validateEmail(refOwnerEmail)) {
                errors.push('Please enter a valid business email address');
            }

            // Check for duplicate phone numbers (final validation)
            if (referrerPhone && refOwnerPhone && referrerPhone === refOwnerPhone) {
                errors.push('Your phone number and the business owner\'s phone number cannot be the same');
            }

            if (errors.length > 0) {
                showMessage('referral-message', 'Please fix the following errors:\\n\\n• ' + errors.join('\\n• '), 'error');
                return;
            }

            const submitBtn = e.target.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="loading-spinner"></span> Submitting...';

            const data = {
                referrer_name: referrerName,
                referrer_email: referrerEmail,
                referrer_phone: referrerPhone,
                business_name: refBusinessName,
                owner_name: refOwnerName,
                owner_phone: refOwnerPhone,
                owner_email: refOwnerEmail || null
            };

            try {
                const response = await fetch('<?= $base_url ?>/_system/submit_business_referral.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    showMessage('referral-message', '✓ ' + result.message, 'success');
                    e.target.reset();
                } else {
                    if (result.errors) {
                        showMessage('referral-message', 'Please fix the following errors:\\n\\n• ' + result.errors.join('\\n• '), 'error');
                    } else {
                        showMessage('referral-message', '✗ ' + result.message, 'error');
                    }
                }
            } catch (error) {
                showMessage('referral-message', 'An error occurred. Please try again later or contact us directly at (800) 770-5520', 'error');
                console.error('Submission error:', error);
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        });

        // ==========================================
        // BUSINESS OWNER FORM (Tab 2)
        // ==========================================
        document.getElementById('businessOwnerForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            // Get form data
            const formData = new FormData(e.target);
            const errors = [];

            const ownerName = formData.get('ownerName');
            if (!ownerName || ownerName.trim().length < 2) {
                errors.push('Please enter your full name');
            }

            const businessName = formData.get('businessName');
            if (!businessName || businessName.trim().length < 2) {
                errors.push('Please enter your business name');
            }

            const ownerPhone = formData.get('ownerPhone');
            if (!ownerPhone || !validatePhone(ownerPhone)) {
                errors.push('Please enter a valid phone number');
            }

            const ownerEmail = formData.get('ownerEmail');
            if (!ownerEmail || !validateEmail(ownerEmail)) {
                errors.push('Please enter a valid email address');
            }

            if (errors.length > 0) {
                showMessage('owner-message', 'Please fix the following errors:\\n\\n• ' + errors.join('\\n• '), 'error');
                return;
            }

            const submitBtn = e.target.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="loading-spinner"></span> Submitting...';

            const data = {
                owner_name: ownerName,
                business_name: businessName,
                phone: ownerPhone,
                email: ownerEmail
            };

            try {
                const response = await fetch('<?= $base_url ?>/_system/submit_business_owner.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    showMessage('owner-message', '✓ ' + result.message, 'success');
                    e.target.reset();
                } else {
                    if (result.errors) {
                        showMessage('owner-message', 'Please fix the following errors:\\n\\n• ' + result.errors.join('\\n• '), 'error');
                    } else {
                        showMessage('owner-message', '✗ ' + result.message, 'error');
                    }
                }
            } catch (error) {
                showMessage('owner-message', 'An error occurred. Please try again later or contact us directly at (800) 770-5520', 'error');
                console.error('Submission error:', error);
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        });

        // Real-time validation feedback for all email fields
        ['referrerEmail', 'refOwnerEmail', 'ownerEmail'].forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.addEventListener('blur', function() {
                    if (this.value && !validateEmail(this.value)) {
                        this.style.borderColor = '#dc3545';
                    } else {
                        this.style.borderColor = '';
                    }
                });
            }
        });

        // Real-time validation feedback for all phone fields
        ['referrerPhone', 'refOwnerPhone', 'ownerPhone'].forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                // Add listeners for referral form phone matching
                if (fieldId === 'referrerPhone' || fieldId === 'refOwnerPhone') {
                    field.addEventListener('input', checkPhoneMatch);
                    field.addEventListener('blur', checkPhoneMatch);
                }

                // On focus, ensure +1 prefix and position cursor
                field.addEventListener('focus', function(e) {
                    if (!e.target.value || e.target.value === '') {
                        e.target.value = '+1 ';
                    }
                    setTimeout(() => {
                        e.target.setSelectionRange(3, 3);
                    }, 0);
                });

                // Format as user types
                field.addEventListener('input', function(e) {
                    const cursorPos = e.target.selectionStart;
                    const formatted = formatPhoneWithPrefix(e.target.value);
                    e.target.value = formatted;
                    
                    if (cursorPos < 3) {
                        e.target.setSelectionRange(3, 3);
                    }
                });

                // Validate on blur
                field.addEventListener('blur', function() {
                    if (this.value && !validatePhone(this.value)) {
                        this.style.borderColor = '#dc3545';
                    } else {
                        this.style.borderColor = '';
                    }
                });
            }
        });

        // CLAIM OFFER NOW button - Scroll to tabs with pulse effect
        (function() {
            const claimOfferBtn = document.getElementById('claimOfferBtn');
            const tabsSection = document.querySelector('.tabs');

            if (!claimOfferBtn || !tabsSection) return;

            claimOfferBtn.addEventListener('click', () => {
                // Scroll to tabs section
                tabsSection.scrollIntoView({ behavior: 'smooth', block: 'center' });

                // Add pulse animation
                tabsSection.classList.remove('tabs-pulse');
                void tabsSection.offsetWidth; // Force reflow
                tabsSection.classList.add('tabs-pulse');

                // Remove pulse class after animation completes
                setTimeout(() => tabsSection.classList.remove('tabs-pulse'), 1800);
            });
        })();
        </script>

    <!-- End Of Promo Body -->


    <!-- form styling -->
    <style>
    /* Loading Spinner */
    .loading-spinner {
        display: inline-block;
        width: 14px;
        height: 14px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 0.8s linear infinite;
        margin-right: 8px;
        vertical-align: middle;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Phone Match Error */
    #refOwnerPhoneWrapper.phone-match-error::after {
        content: 'This phone number matches the referrer\'s phone number';
        display: block;
        color: #dc3545;
        font-size: 14px;
        margin-top: 5px;
        position: absolute;
    }

    #refOwnerPhoneWrapper {
        position: relative;
    }

    /* Form Section Headers */
    .form-section-header {
        grid-column: 1 / -1;
        margin-top: 20px;
        margin-bottom: 10px;
        padding-bottom: 8px;
        border-bottom: 2px solid var(--color-primary);
    }

    .form-section-header:first-child {
        margin-top: 0;
    }

    .section-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--color-primary);
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* PULSE EFFECT FOR TABS */
    .tabs.tabs-pulse {
      position: relative;
      overflow: visible;
      animation: tabsPulse 1.6s cubic-bezier(0.22, 1, 0.36, 1);
    }

    @keyframes tabsPulse {
      0% {
        box-shadow: 0 0 0 0 rgba(54, 116, 168, 0),
                    0 0 0 0 rgba(54, 116, 168, 0);
      }
      40% {
        box-shadow: 0 0 0 6px rgba(54, 116, 168, 0.35),
                    0 0 30px 12px rgba(54, 116, 168, 0.45);
      }
      70% {
        box-shadow: 0 0 0 10px rgba(54, 116, 168, 0.18),
                    0 0 45px 20px rgba(54, 116, 168, 0.25);
      }
      100% {
        box-shadow: 0 0 0 0 rgba(54, 116, 168, 0),
                    0 0 0 0 rgba(54, 116, 168, 0);
      }
    }

    .tabs.tabs-pulse::after {
      content: "";
      position: absolute;
      inset: 0;
      border-radius: inherit;
      box-shadow: inset 0 0 40px rgba(54, 116, 168, 0.25);
      pointer-events: none;
    }
    </style>

    <!-- hero styling -->
 
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/promo-hero.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/promo-mid-section.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/promo-form.css">
    <script>
    // ========================================
    // DYNAMIC HERO BACKGROUND ROTATION (7-Day Interval)
    // ========================================
    (function() {
        // Configuration
        const useArray = false; // Set to true to enable image rotation
        const defaultBg = 'url(<?= $base_url ?>/assets/images/promo/HeroBanner1.webp) center/cover no-repeat';
        
        // Array of hero background images (currently 7 duplicates - replace later)
        const heroBackgrounds = [
            'url(<?= $base_url ?>/assets/images/promo/HeroBanner1.webp) center/cover no-repeat',
            'url(<?= $base_url ?>/assets/images/promo/HeroBanner1.webp) center/cover no-repeat',
            'url(<?= $base_url ?>/assets/images/promo/HeroBanner1.webp) center/cover no-repeat',
            'url(<?= $base_url ?>/assets/images/promo/HeroBanner1.webp) center/cover no-repeat',
            'url(<?= $base_url ?>/assets/images/promo/HeroBanner1.webp) center/cover no-repeat',
            'url(<?= $base_url ?>/assets/images/promo/HeroBanner1.webp) center/cover no-repeat',
            'url(<?= $base_url ?>/assets/images/promo/HeroBanner1.webp) center/cover no-repeat'
        ];

        const hero = document.querySelector('.hero');
        if (!hero) return;

        // If useArray is false, use default background and exit
        if (!useArray) {
            hero.style.background = defaultBg;
            return;
        }

        // Get stored data from localStorage
        const storageKey = 'promoHeroBg';
        const stored = localStorage.getItem(storageKey);
        let currentBg = null;
        let lastChanged = null;

        if (stored) {
            try {
                const data = JSON.parse(stored);
                currentBg = data.background;
                lastChanged = new Date(data.timestamp);
            } catch (e) {
                console.error('Error parsing stored hero background data:', e);
            }
        }

        // Check if 7 days have passed
        const now = new Date();
        const sevenDaysInMs = 7 * 24 * 60 * 60 * 1000; // 7 days in milliseconds
        const shouldChange = !lastChanged || (now - lastChanged >= sevenDaysInMs);

        // Select new background if needed
        if (shouldChange || !currentBg) {
            // Randomly select a background from the array
            const randomIndex = Math.floor(Math.random() * heroBackgrounds.length);
            currentBg = heroBackgrounds[randomIndex];

            // Store the new selection
            localStorage.setItem(storageKey, JSON.stringify({
                background: currentBg,
                timestamp: now.toISOString()
            }));
        }

        // Apply the background
        hero.style.background = currentBg;
    })();
    </script>