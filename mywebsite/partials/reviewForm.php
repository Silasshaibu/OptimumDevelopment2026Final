 <div class="review-Section">
    <div class="review-container">
      <div class="left">
        <img class="review-logo"
             src="./assets/images/logo/logo-optimum-payment_optimized_sm.png"
             width="110"
             alt="Optimum-Payments">
      </div>

      <div class="right">
        <h1 class="review-intro">Enjoy our service and products?</h1>
        <p>Please leave a <strong class="review-accent">review</strong> below.</p>

        <form id="reviewForm" class="reviewSection">
          <div class="form reviewSection">

            <p id="ratingLabel">Your overall rating*</p>
            <div class="stars" id="starRating">
              <svg class="reviewStar" data-value="1" viewBox="0 0 24 24"><path d="M12 2l3 7h7l-5.5 4.5L18 21l-6-4-6 4 1.5-7.5L2 9h7z"/></svg>
              <svg class="reviewStar" data-value="2" viewBox="0 0 24 24"><path d="M12 2l3 7h7l-5.5 4.5L18 21l-6-4-6 4 1.5-7.5L2 9h7z"/></svg>
              <svg class="reviewStar" data-value="3" viewBox="0 0 24 24"><path d="M12 2l3 7h7l-5.5 4.5L18 21l-6-4-6 4 1.5-7.5L2 9h7z"/></svg>
              <svg class="reviewStar" data-value="4" viewBox="0 0 24 24"><path d="M12 2l3 7h7l-5.5 4.5L18 21l-6-4-6 4 1.5-7.5L2 9h7z"/></svg>
              <svg class="reviewStar" data-value="5" viewBox="0 0 24 24"><path d="M12 2l3 7h7l-5.5 4.5L18 21l-6-4-6 4 1.5-7.5L2 9h7z"/></svg>
            </div>

            <input type="hidden" id="rating" required>

            <label for="reviewText">Your review*</label>
            <textarea id="reviewText" name="review" required placeholder="Tell people your review"></textarea>

            <label for="reviewName">Your name*</label>
            <input type="text" id="reviewName" name="name" placeholder="Tell us your name" required autocomplete="name">

            <label for="reviewEmail">Your email*</label>
            <input type="email" id="reviewEmail" name="email" placeholder="example@email.com" required autocomplete="email">

            <div class="checkbox">
              <input type="checkbox" id="privacyAgree" name="privacy_agreed" required>
              <label class="terms-checkbox" for="privacyAgree">
                <p class="subtle">I agree to <a class="terms-link" href="<?= $base_url ?>/privacy-policy">Optimum-Payments Privacy</a> Notice</p>
              </label>
            </div>

            <button class="btn-primary btn-fullwidth" type="submit">
              Submit Review <span class="reviewFormDirectionalArrow-CTA"> 
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon banner arrow-long-right">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3"></path>
                                </svg>
                            </span>
            </button>

          </div>
        </form>
      </div>
    </div>
  </div>

  <div id="feedbackToReviewSection" class="feedbackToReviewSection">
    <span class="feedback-icon">    
      <svg xmlns="http://www.w3.org/2000/svg" class="feedback-icon-svg" width="24" height="22" fill="none" viewBox="0 0 24 22" data-testid="icon-buddy"><path fill="#fdfdfe" fill-rule="evenodd" d="M22.362.827C21.72.5 20.88.5 19.2.5H3.3C1.755.5.983.5.575.819A1.5 1.5 0 000 1.969c-.01.517.453 1.135 1.38 2.371l1.14 1.52c.178.237.267.356.33.487a1.5 1.5 0 01.122.365C3 6.855 3 7.003 3 7.3v9.4c0 1.68 0 2.52.327 3.162a3 3 0 001.311 1.311c.642.327 1.482.327 3.162.327h11.4c1.68 0 2.52 0 3.162-.327a3 3 0 001.311-1.311C24 19.22 24 18.38 24 16.7V5.3c0-1.68 0-2.52-.327-3.162a3 3 0 00-1.31-1.311zM9.277 11.937a1.125 1.125 0 00-1.948 1.126 7.123 7.123 0 006.171 3.562 7.123 7.123 0 006.171-3.562 1.125 1.125 0 10-1.947-1.126 4.872 4.872 0 01-4.224 2.438 4.873 4.873 0 01-4.223-2.438zM10.5 8a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM18 9.5a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" clip-rule="evenodd"></path></svg>
    </span>
    Feedback
  </div>

  <link rel="stylesheet" href="<?= $base_url ?>/assets/css/reviewFormSection.css">
  
<style>

 span.reviewFormDirectionalArrow-CTA{
    display: inline-block;
  }

  @media(max-width:768px){
     .feedbackToReviewSection{
    display:none !important;
    }
  }
     
</style>

  <script>
    (function () {
      const feedbackBtn = document.querySelector('.feedbackToReviewSection');
      const reviewCard = document.querySelector('.review-container');
      const reviewSection = document.querySelector('.review-Section');

      if (!feedbackBtn || !reviewCard || !reviewSection) return;

      let inactivityTimer = null;
      let visibilityTimer = null;
      const inactivityDelay = 30000; // 30 seconds
      const visibilityDuration = 180000; // 3 minutes
      const scrollThreshold = 600; // 600px
      
      let scrollConditionMet = false;
      let inactivityConditionMet = false;

      function checkAndShow() {
        if (scrollConditionMet && inactivityConditionMet) {
          feedbackBtn.classList.add('is-visible');
          
          // Auto-hide after 3 minutes
          if (visibilityTimer) clearTimeout(visibilityTimer);
          visibilityTimer = setTimeout(() => {
            feedbackBtn.classList.remove('is-visible');
          }, visibilityDuration);
        }
      }

      function resetInactivityTimer() {
        // Clear existing timers
        if (inactivityTimer) clearTimeout(inactivityTimer);
        if (visibilityTimer) clearTimeout(visibilityTimer);
        
        // Hide feedback if visible
        feedbackBtn.classList.remove('is-visible');
        inactivityConditionMet = false;
        
        // Start new inactivity timer
        inactivityTimer = setTimeout(() => {
          inactivityConditionMet = true;
          checkAndShow();
        }, inactivityDelay);
      }

      function handleScroll() {
        const scrollY = window.scrollY || window.pageYOffset;
        
        if (scrollY >= scrollThreshold && !scrollConditionMet) {
          scrollConditionMet = true;
          checkAndShow();
        }
      }

      // Track user activity (excluding scroll)
      const activityEvents = ['mousedown', 'mousemove', 'keypress', 'touchstart'];
      activityEvents.forEach(event => {
        document.addEventListener(event, resetInactivityTimer, { passive: true });
      });

      // Track scroll separately for threshold check
      window.addEventListener('scroll', () => {
        handleScroll();
        resetInactivityTimer();
      }, { passive: true });

      // Initialize on page load
      handleScroll();
      resetInactivityTimer();

      // Handle feedback button click
      feedbackBtn.addEventListener('click', () => {
        reviewSection.scrollIntoView({ behavior: 'smooth', block: 'center' });

        reviewCard.classList.remove('review-pulse');
        void reviewCard.offsetWidth;
        reviewCard.classList.add('review-pulse');

        setTimeout(() => reviewCard.classList.remove('review-pulse'), 1800);
        
        // Hide and reset timers after click
        feedbackBtn.classList.remove('is-visible');
        inactivityConditionMet = false;
        if (inactivityTimer) clearTimeout(inactivityTimer);
        if (visibilityTimer) clearTimeout(visibilityTimer);
        
        // Restart inactivity detection
        setTimeout(() => resetInactivityTimer(), 2000);
      });
    })();
  </script>

  <script>
    (function () {
      const ratingContainer = document.getElementById('starRating');
      const stars = ratingContainer ? ratingContainer.querySelectorAll('.reviewStar') : [];
      const ratingInput = document.getElementById('rating');
      const reviewForm = document.getElementById('reviewForm');
      let selectedRating = 0;

      if (!ratingContainer || !ratingInput || !reviewForm || stars.length === 0) {
        return;
      }

      function highlightStars(value) {
        const ratingValue = Number(value) || 0;
        stars.forEach(star => {
          const starValue = Number(star.dataset.value) || 0;
          star.classList.toggle('active', starValue <= ratingValue);
        });
      }

      ratingContainer.addEventListener('mouseover', (event) => {
        const star = event.target.closest('.reviewStar');
        if (!star || !ratingContainer.contains(star)) return;
        highlightStars(star.dataset.value);
      });

      ratingContainer.addEventListener('mouseleave', () => {
        highlightStars(selectedRating);
      });

      ratingContainer.addEventListener('click', (event) => {
        const star = event.target.closest('.reviewStar');
        if (!star || !ratingContainer.contains(star)) return;
        selectedRating = Number(star.dataset.value) || 0;
        ratingInput.value = String(selectedRating);
        highlightStars(selectedRating);
      });

      // Form submission handler
      reviewForm.addEventListener('submit', async (e) => {
      e.preventDefault();

      if (!ratingInput.value) {
        alert('Please select a rating');
        return;
      }

      const submitBtn = e.target.querySelector('button[type="submit"]');
      const originalBtnText = submitBtn.innerHTML;
      submitBtn.disabled = true;
      submitBtn.innerHTML = 'Submitting...';

      const formData = {
        rating: ratingInput.value,
        review: document.getElementById('reviewText').value,
        name: document.getElementById('reviewName').value,
        email: document.getElementById('reviewEmail').value,
        privacy_agreed: document.getElementById('privacyAgree').checked
      };

      try {
        const response = await fetch('<?= $base_url ?>/_system/submit_review.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(formData)
        });

        const result = await response.json();

        if (result.success) {
          alert('✓ ' + result.message);
          e.target.reset();
          selectedRating = 0;
          ratingInput.value = '';
          highlightStars(0);
        } else {
          if (result.errors) {
            alert('Please fix the following errors:\n\n• ' + result.errors.join('\n• '));
          } else {
            alert('✗ ' + result.message);
          }
        }
      } catch (error) {
        alert('An error occurred. Please try again later.');
        console.error('Submission error:', error);
      } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
      }
    });
    })();

    // ========================================
    // DYNAMIC BACKGROUND IMAGE ROTATION (2-Day Interval)
    // ========================================
    (function() {
      // Configuration
      const useArray = false; // Set to true to enable image rotation
      const defaultImage = '<?= $base_url ?>/assets/images/hero/ReivewCard-Desktop-DisplayPictures.webp';
      
      // Array of background images (currently 7 duplicates - replace 6 later)
      const backgroundImages = [
        '<?= $base_url ?>/assets/images/hero/ReivewCard-Desktop-DisplayPictures.webp',
        '<?= $base_url ?>/assets/images/hero/ReivewCard-Desktop-DisplayPictures.webp',
        '<?= $base_url ?>/assets/images/hero/ReivewCard-Desktop-DisplayPictures.webp',
        '<?= $base_url ?>/assets/images/hero/ReivewCard-Desktop-DisplayPictures.webp',
        '<?= $base_url ?>/assets/images/hero/ReivewCard-Desktop-DisplayPictures.webp',
        '<?= $base_url ?>/assets/images/hero/ReivewCard-Desktop-DisplayPictures.webp',
        '<?= $base_url ?>/assets/images/hero/ReivewCard-Desktop-DisplayPictures.webp'
      ];

      const leftSection = document.querySelector('.review-container div.left');
      if (!leftSection) return;

      // If useArray is false, use default image and exit
      if (!useArray) {
        leftSection.style.background = `#e8f4e3 url(${defaultImage}) no-repeat center/cover`;
        return;
      }

      // Get stored data from localStorage
      const storageKey = 'reviewBgImage';
      const stored = localStorage.getItem(storageKey);
      let currentImage = null;
      let lastChanged = null;

      if (stored) {
        try {
          const data = JSON.parse(stored);
          currentImage = data.image;
          lastChanged = new Date(data.timestamp);
        } catch (e) {
          console.error('Error parsing stored image data:', e);
        }
      }

      // Check if 2 days have passed
      const now = new Date();
      const twoDaysInMs = 2 * 24 * 60 * 60 * 1000; // 2 days in milliseconds
      const shouldChange = !lastChanged || (now - lastChanged >= twoDaysInMs);

      // Select new image if needed
      if (shouldChange || !currentImage) {
        // Randomly select an image from the array
        const randomIndex = Math.floor(Math.random() * backgroundImages.length);
        currentImage = backgroundImages[randomIndex];

        // Store the new selection
        localStorage.setItem(storageKey, JSON.stringify({
          image: currentImage,
          timestamp: now.toISOString()
        }));
      }

      // Apply the background image
      leftSection.style.background = `#e8f4e3 url(${currentImage}) no-repeat center/cover`;
    })();
