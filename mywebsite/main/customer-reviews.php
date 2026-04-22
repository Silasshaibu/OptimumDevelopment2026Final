
  
  <!-- Review Header Section -->
  <header class="hero-section narrow">
    <h1 class="hero-title narrow">Customers Reviews</h1>
  </header>

  <?php
    $stmt = $conn->prepare("SELECT rating FROM reviews WHERE status = 'approved'");
    $stmt->execute();
    $result = $stmt->get_result();
    $reviews = $result->fetch_all(MYSQLI_ASSOC);

    $reviewCount = count($reviews);
    $totalRating = 0;
    foreach ($reviews as $review) {
      $totalRating += floatval($review['rating'] ?? 0);
    }
    $averageRating = $reviewCount > 0 ? round($totalRating / $reviewCount, 1) : 0;

    $googleReviewUrl = 'https://www.google.com/search?q=Optimum+Payment+Solutions+reviews';
    $facebookReviewUrl = 'https://web.facebook.com/p/Optimum-Payment-Solutions-100082955451105/?_rdc=1&_rdr#';
  ?>

  <div class="brandsection reviews-summary-bar" aria-label="Review summary">
    <div class="reviews-summary-bar-left">
      <div class="reviews-summary-platforms" aria-hidden="true">
        <img src="<?= $base_url ?>/assets/images/icon/icon-google-small.webp" alt="Google reviews" width="20" height="20" loading="lazy">
        <span>+</span>
        <img src="<?= $base_url ?>/assets/images/icon/icon-facebook-small2.webp" alt="Facebook reviews" width="20" height="20" loading="lazy">
        <span>+</span>
        <img src="<?= $base_url ?>/assets/images/icon/icon-optimum-payments.webp" alt="Optimum Payments reviews" width="20" height="20" loading="lazy">
        <strong>All Reviews</strong>
      </div>

      <div class="reviews-summary-rating-row">
        <strong class="reviews-summary-rating-value"><?= number_format($averageRating, 1) ?></strong>
        <span class="reviews-summary-stars" aria-label="Average rating <?= number_format($averageRating, 1) ?> out of 5">
          <?php for ($i = 1; $i <= 5; $i++):
            $fillPercent = min(max($averageRating - ($i - 1), 0), 1) * 100;
          ?>
            <span class="reviews-summary-star-container" aria-hidden="true">
              <span class="reviews-summary-star-empty"></span>
              <span class="reviews-summary-star-filled" style="--reviews-summary-star-fill: <?= $fillPercent ?>%;"></span>
            </span>
          <?php endfor; ?>
        </span>
        <span class="reviews-summary-count">(<?= $reviewCount ?>)</span>
      </div>
    </div>

    <a href="#" class="reviews-summary-cta" data-open-review-modal="true">Write us a review</a>
  </div>

  <div class="review-choice-modal" id="reviewChoiceModal" aria-hidden="true">
    <div class="review-choice-modal-overlay" data-close-review-modal="true"></div>
    <div class="review-choice-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="reviewChoiceTitle">
      <button type="button" class="review-choice-modal-close" data-close-review-modal="true" aria-label="Close">x</button>
      <h2 class="suggestedActions-title" id="reviewChoiceTitle">Write us a review</h2>
      <p class="suggestedActions-subtitle">Choose a platform to leave your review</p>

      <div class="suggestedActions-options">
        <a class="suggestedActions-option" href="<?= htmlspecialchars($googleReviewUrl) ?>" target="_blank" rel="noopener noreferrer">
          <span class="suggestedActions-option-left">
            <img src="<?= $base_url ?>/assets/images/icon/icon-google-small.webp" alt="Google" width="28" height="28" loading="lazy">
            <span>Review on Google</span>
          </span>
          <span class="suggestedActions-arrow" aria-hidden="true">></span>
        </a>

        <a class="suggestedActions-option" href="<?= htmlspecialchars($facebookReviewUrl) ?>" target="_blank" rel="noopener noreferrer">
          <span class="suggestedActions-option-left">
            <img src="<?= $base_url ?>/assets/images/icon/icon-facebook-small2.webp" alt="Facebook" width="28" height="28" loading="lazy">
            <span>Review on Facebook</span>
          </span>
          <span class="suggestedActions-arrow" aria-hidden="true">></span>
        </a>

        <a class="suggestedActions-option" href="<?= $base_url ?>/#reviewForm">
          <span class="suggestedActions-option-left">
            <img src="<?= $base_url ?>/assets/images/logo/logo-optimum-payment_optimized_sm.png" alt="Optimum Payments" width="90" height="24" loading="lazy">
            <span>Review on our site</span>
          </span>
          <span class="suggestedActions-arrow" aria-hidden="true">v</span>
        </a>
      </div>
    </div>
  </div>

  <!-- implement a masonry style for this review section -->
  <?php include __DIR__ . '/../partials/reviewsection-grid.php'; ?>

   <!-- let the rating hug one of the sides left or right so its still in view while scrolling the reviews -->
  <div class="brandsection overall-rating-summary aside-hug">
    rating on all platforms
  </div>
  
  

  <style>
    .brandsection{
      width: 83vw;
      margin:0 auto;
    }

    .brandsection.reviews-summary-bar {
      margin: 1.5rem auto 1rem;
      padding: 1rem 1.25rem;
      border-radius: 10px;
      background: linear-gradient(90deg, #f3f7fc 0%, #e9f1fb 100%);
      border: 1px solid #dbe7f7;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
      max-width: 1200px;
    }

    .reviews-summary-bar-left {
      display: flex;
      flex-direction: column;
      gap: 0.45rem;
    }

    .reviews-summary-platforms {
      display: inline-flex;
      align-items: center;
      gap: 0.375rem;
      color: #2d3848;
      font-size: 1.125rem;
    }

    .reviews-summary-platforms strong {
      font-weight: 500;
    }

    .reviews-summary-rating-row {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }

    .reviews-summary-rating-value {
      font-size: 2rem;
      line-height: 1;
      color: #17243a;
    }

    .reviews-summary-stars {
      display: inline-flex;
      align-items: center;
    }

    .reviews-summary-star-container {
      position: relative;
      width: 18px;
      height: 18px;
      display: inline-block;
      margin-right: 2px;
    }

    .reviews-summary-star-empty,
    .reviews-summary-star-filled {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      clip-path: polygon(49.14% 79.18%, 74.94% 93.78%, 71.04% 64.43%, 92.87% 44.26%, 63.88% 38.95%, 51.54% 11.97%, 37.51% 37.94%, 8.09% 41.34%, 28.44% 62.8%, 22.57% 91.98%);
    }

    .reviews-summary-star-empty {
      background-color: #d6dae4;
    }

    .reviews-summary-star-filled {
      width: var(--reviews-summary-star-fill);
      overflow: hidden;
      background-color: #ffb542;
    }

    .reviews-summary-count {
      color: #59657a;
      font-size: 1.0625rem;
    }

    .reviews-summary-cta {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 44px;
      padding: 0.875rem 1.75rem;
      border-radius: 10px;
      background-color: #1f64a4;
      color: #ffffff;
      text-decoration: none;
      font-weight: 700;
      white-space: nowrap;
    }

    .reviews-summary-cta:hover {
      background-color: #185487;
      color: #ffffff;
    }

    .review-choice-modal {
      position: fixed;
      inset: 0;
      z-index: 4000;
      display: none;
      align-items: center;
      justify-content: center;
      padding: 1rem;
    }

    .review-choice-modal.is-active {
      display: flex;
    }

    .review-choice-modal-overlay {
      position: absolute;
      inset: 0;
      background: rgba(0, 0, 0, 0.45);
    }

    .review-choice-modal-dialog {
      position: relative;
      width: min(92vw, 540px);
      border-radius: 18px;
      background: #ffffff;
      padding: 1.5rem 1.6rem;
      box-shadow: 0 20px 50px rgba(10, 29, 53, 0.2);
      max-height: calc(100vh - 2rem);
      overflow: auto;
    }

    .review-choice-modal-close {
      position: absolute;
      right: 0.9rem;
      top: 0.75rem;
      border: 0;
      background: transparent;
      color: #5f6673;
      font-size: 1.7rem;
      line-height: 1;
      cursor: pointer;
    }

    .suggestedActions-title{
      margin: 0;
      text-align: center;
      font-size: 2rem;
      line-height: 1.2;
      color: #16253a;
    }

    .suggestedActions-subtitle{
      margin: 0.55rem 0 1.15rem;
      text-align: center;
      color: #4c5b70;
      font-size: 1.06rem;
    }

    .suggestedActions-options{
      display: flex;
      flex-direction: column;
      gap: 0.82rem;
      max-width: 540px;
      margin: 0 auto;
    }

    .suggestedActions-option{
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 0.75rem;
      border: 1px solid #dce4ef;
      border-radius: 12px;
      padding: 0.95rem 1rem;
      color: #17243a;
      text-decoration: none;
      background: #ffffff;
      box-shadow: 0 3px 14px rgba(10, 29, 53, 0.06);
      transition: border-color 0.2s ease, transform 0.2s ease, background-color 0.2s ease;
    }

    .suggestedActions-option:hover{
      border-color: #bdd0e7;
      background: #f8fbff;
      transform: translateY(-1px);
    }

    .suggestedActions-option-left{
      display: flex;
      align-items: center;
      gap: 0.72rem;
      min-width: 0;
    }

    .suggestedActions-option-left span{
      font-size: 1.08rem;
      color: #17243a;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .suggestedActions-arrow{
      color: #6a7383;
      font-size: 1.3rem;
      line-height: 1;
      flex: 0 0 auto;
    }

    /* Mobile-first grid, then independent masonry columns for larger screens */
    .customer-review-section .socials-reviews-container.independent-masonry {
      display: grid;
      grid-template-columns: 1fr;
      gap: 1rem;
    }

    .customer-review-section .socials-reviews-container.independent-masonry .masonry-column {
      display: flex;
      flex-direction: column;
      gap: 1rem;
      min-width: 0;
    }

    .customer-review-section .socials-reviews-container.independent-masonry .review-card {
      margin: 0;
    }

    .customer-review-section .review-card p .full {
      display: inline-block;
      max-height: 0;
      opacity: 0;
      overflow: hidden;
      vertical-align: bottom;
      transition: max-height 0.35s ease, opacity 0.28s ease;
    }

    .customer-review-section .review-card p.is-expanded .full {
      max-height: 18rem;
      opacity: 1;
    }

    @media (min-width: 768px) {
      .customer-review-section .socials-reviews-container.independent-masonry {
        grid-template-columns: repeat(2, minmax(0, 1fr));
      }
    }

    @media (min-width: 1100px) {
      .customer-review-section .socials-reviews-container.independent-masonry {
        grid-template-columns: repeat(3, minmax(0, 1fr));
      }
    }

    @media (max-width: 900px){
      .brandsection.reviews-summary-bar {
        width: 94vw;
      }
    }

    @media (max-width: 768px){
      .brandsection.reviews-summary-bar{
        width: 94vw;
        flex-direction: column;
        align-items: stretch;
      }

      .reviews-summary-cta {
        text-align: center;
      }

      .suggestedActions-title{
        font-size: 1.7rem;
      }

      .suggestedActions-subtitle{
        font-size: 1rem;
      }

      .suggestedActions-option{
        padding: 0.82rem 0.78rem;
      }

      .suggestedActions-option-left span{
        font-size: 0.98rem;
      }

      .review-choice-modal-dialog {
        padding: 1.2rem 1rem;
      }
    }
  </style>

  <script>
    (function () {
      const modal = document.getElementById('reviewChoiceModal');
      const openBtn = document.querySelector('[data-open-review-modal="true"]');
      const closeEls = modal ? modal.querySelectorAll('[data-close-review-modal="true"]') : [];

      if (!modal || !openBtn) {
        return;
      }

      function openModal(event) {
        event.preventDefault();
        modal.classList.add('is-active');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
      }

      function closeModal() {
        modal.classList.remove('is-active');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
      }

      openBtn.addEventListener('click', openModal);

      closeEls.forEach(function (el) {
        el.addEventListener('click', closeModal);
      });

      document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && modal.classList.contains('is-active')) {
          closeModal();
        }
      });
    })();
  </script>


  <!-- Reviews Body Section Start -->
  <link rel="stylesheet" href="<?= $base_url ?>/assets/css/review-section.css">