<!-- Reviews Body Section Start -->
<section class="customer-review-section homepage-review-section">      
    
    <div class="section-header">
        <h1 class="customer-review-section title">What people say about us</h1>
    </div>

    <?php
        if (!function_exists('truncate_text')) {
            function truncate_text($text, $words = 30) {
                $words_array = preg_split('/\s+/', $text);
                if(count($words_array) > $words){
                    $short = implode(' ', array_slice($words_array, 0, $words)) . '...';
                    return [$short, $text];
                }
                return [$text, null];
            }
        }

        // Fetch all approved reviews from DB (imported and direct)
        $stmt = $conn->prepare("SELECT * FROM reviews WHERE status = 'approved' ORDER BY created_at DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        $reviews = $result->fetch_all(MYSQLI_ASSOC);

        // Calculate average rating
        $totalRating = 0;
        $reviewCount = count($reviews);
        foreach ($reviews as $rev) {
            $totalRating += floatval($rev['rating'] ?? 0);
        }
        $averageRating = $reviewCount > 0 ? round($totalRating / $reviewCount, 1) : 0;
        $fullStars = floor($averageRating);

        $googleReviewUrl = 'https://www.google.com/search?q=Optimum+Payment+Solutions+reviews';
        $facebookReviewUrl = 'https://web.facebook.com/p/Optimum-Payment-Solutions-100082955451105/?_rdc=1&_rdr#';
    ?>

    <div class="homepage-review-summary" aria-label="Review summary">
        <div class="homepage-review-summary-left">
            <div class="homepage-review-platforms" aria-hidden="true">
                <img src="<?= $base_url ?>/assets/images/icon/icon-google-small.webp" alt="Google reviews" width="20" height="20" loading="lazy">
                <span>+</span>
                <img src="<?= $base_url ?>/assets/images/icon/icon-facebook-small2.webp" alt="Facebook reviews" width="20" height="20" loading="lazy">
                <span>+</span>
                <img src="<?= $base_url ?>/assets/images/icon/icon-optimum-payments.webp" alt="Optimum Payments reviews" width="20" height="20" loading="lazy">
                <strong>All Reviews</strong>
            </div>

            <div class="homepage-review-rating-row">
                <strong class="homepage-review-rating-value"><?= number_format($averageRating, 1) ?></strong>
                <span class="homepage-review-stars" aria-label="Average rating <?= number_format($averageRating, 1) ?> out of 5">
                    <?php for ($i = 1; $i <= 5; $i++):
                        $fillPercent = min(max($averageRating - ($i - 1), 0), 1) * 100;
                    ?>
                        <span class="wpsr-star-container" aria-hidden="true">
                            <span class="wpsr-star-empty"></span>
                            <span class="wpsr-star-filled" style="--wpsr-review-star-fill: <?= $fillPercent ?>%;"></span>
                        </span>
                    <?php endfor; ?>
                </span>
                <span class="homepage-review-count">(<?= $reviewCount ?>)</span>
            </div>
        </div>

        <a href="#" class="homepage-review-summary-cta" role="button" aria-label="Write us a review" data-open-review-modal="true">Write us a review</a>
    </div>

    <div class="homepage-write-review-modal" id="homepageWriteReviewModal" aria-hidden="true">
        <div class="homepage-write-review-modal__overlay" data-close-review-modal="true"></div>
        <div class="homepage-write-review-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="homepageWriteReviewTitle">
            <button type="button" class="homepage-write-review-modal__close" data-close-review-modal="true" aria-label="Close review platform selector">x</button>

            <h2 id="homepageWriteReviewTitle" class="homepage-write-review-modal__title">Write us a review</h2>
            <p class="homepage-write-review-modal__subtitle">Choose a platform to leave your review</p>

            <div class="homepage-write-review-modal__options">
                <a class="homepage-write-review-modal__option" href="<?= htmlspecialchars($googleReviewUrl) ?>" target="_blank" rel="noopener noreferrer">
                    <span class="homepage-write-review-modal__option-left">
                        <img src="<?= $base_url ?>/assets/images/icon/icon-google-small.webp" alt="Google" width="28" height="28" loading="lazy">
                        <span>Review on Google</span>
                    </span>
                    <span class="homepage-write-review-modal__arrow" aria-hidden="true">></span>
                </a>

                <a class="homepage-write-review-modal__option" href="<?= htmlspecialchars($facebookReviewUrl) ?>" target="_blank" rel="noopener noreferrer">
                    <span class="homepage-write-review-modal__option-left">
                        <img src="<?= $base_url ?>/assets/images/icon/icon-facebook-small2.webp" alt="Facebook" width="28" height="28" loading="lazy">
                        <span>Review on Facebook</span>
                    </span>
                    <span class="homepage-write-review-modal__arrow" aria-hidden="true">></span>
                </a>

                <a class="homepage-write-review-modal__option" href="#reviewForm" data-review-onsite="true">
                    <span class="homepage-write-review-modal__option-left">
                        <img src="<?= $base_url ?>/assets/images/logo/logo-optimum-payment_optimized_sm.png" alt="Optimum Payments" width="90" height="24" loading="lazy">
                        <span>Review on our site</span>
                    </span>
                    <span class="homepage-write-review-modal__arrow" aria-hidden="true">v</span>
                </a>
            </div>
        </div>
    </div>

    <div class="socials-reviews-container" id="homepageReviewsGrid">
        <?php foreach($reviews as $index => $review): 
            
            $platform = $review['platform'];

            // ADD THIS BLOCK HERE
            if ($platform === 'facebook') {
                $platformIcon = $base_url . '/assets/images/icon/icon-facebook-small2.webp';
            } elseif ($platform === 'google') {
                $platformIcon = $base_url . '/assets/images/icon/icon-google-small.webp';
            } else {
                $platformIcon = $base_url . '/assets/images/icon/icon-optimum-payments.webp';
            }
    
            $name = htmlspecialchars($review['guest_email']);
            $text_full = htmlspecialchars($review['review']);
            $date = date('F j, Y', strtotime($review['created_at']));
            $avatar = $review['reviewer_img'];
            $link = $review['reviewer_url'] ?: '#';
            
            // Check if avatar exists and is valid (must be a full URL, not default or empty)
            $hasValidAvatar = !empty($avatar) 
                && $avatar !== 'default-avatar.png' 
                && !str_contains($avatar, 'default-avatar') 
                && filter_var($avatar, FILTER_VALIDATE_URL);

            $avatarSrc = $hasValidAvatar
                ? ($base_url . '/_system/avatar_proxy.php?url=' . rawurlencode($avatar))
                : '';
            
            // Get first letter for fallback - use guest_email or fallback to 'U' for User
            $nameForInitial = $review['guest_email'] ?? '';
            $initial = '';
            // Find the first alphabetic character
            for ($i = 0; $i < strlen($nameForInitial); $i++) {
                if (ctype_alpha($nameForInitial[$i])) {
                    $initial = strtoupper($nameForInitial[$i]);
                    break;
                }
            }
            // Fallback to 'U' if no letter found
            if (empty($initial)) {
                $initial = 'U';
            }

            list($text_short, $text_rest) = truncate_text($text_full, 40);
        ?>
        
        <div class="review-card<?= $index >= 6 ? ' is-hidden-review-card' : '' ?>">
            
            <div>
                <div class="review-card-top-level">   

                    <a href="<?= $link ?>" class="avatAnchor-block" target="_blank">
                        <?php if($hasValidAvatar): ?>
                            <img class="avatar" src="<?= htmlspecialchars($avatarSrc) ?>" alt="<?= $name ?>" width="48" height="48" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="avatar-initial" style="display:none;"><?= $initial ?></div>
                        <?php else: ?>
                            <div class="avatar-initial"><?= $initial ?></div>
                        <?php endif; ?>
                        <img class="wpsr-review-platform-icon social-badge avatar-neck-line" width="20" height="20" src="<?= $platformIcon ?>" alt="<?= $platform ?>">
                    </a>

                    <div>
                        <strong><?= $name ?></strong><br>
                        <?php if($platform === 'facebook'): ?>
                            <span class="badge">
                                <img src="https://static.xx.fbcdn.net/rsrc.php/v4/y6/r/2CYZBtJFeT2.png" alt="Recommended">
                                <?= $review['recommendation_type'] === 'positive' ? 'Recommended' : 'Not Recommended' ?>
                            </span>
                        <?php else: // google ?>
                            <span class="wpsr-rating">
                                <?php 
                                $rating = floatval($review['rating'] ?? 0);
                                for($i=1;$i<=5;$i++):
                                    $fillPercent = min(max($rating-($i-1),0),1)*100;
                                ?>
                                    <div class="wpsr-star-container">
                                        <div class="wpsr-star-empty"></div>
                                        <div class="wpsr-star-filled" style="--wpsr-review-star-fill: <?= $fillPercent ?>%;"></div>
                                    </div>
                                <?php endfor; ?>
                            </span>
                        <?php endif; ?>
                        <small><?= $date ?></small>
                    </div>                
                </div>
                

                <p>
                    <?php if($text_rest): ?>
                        <span class="short"><?= $text_short ?></span>
                        <span class="full" style="display:none;"><?= $text_full ?></span>
                        <span class="read-more" onclick="toggleReview(this)">Read More</span>
                    <?php else: ?>
                        <?= $text_full ?>
                    <?php endif; ?>
                </p>

                
            </div>
        </div>
        
        <?php endforeach; ?>
    </div>

    <?php if ($reviewCount > 6): ?>
    <div class="homepage-reviews-footer withRemote">
        <div class="remoteControl">
            <button class="homepage-reviews-toggle" id="homepageReviewsToggle" aria-expanded="false">
                <span>View all</span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M8.25 4.5L15.75 12L8.25 19.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </button>
        </div>
    </div>
    <?php endif; ?>

    <script>
        function toggleReview(el){
            const p = el.closest('p');
            const shortText = p.querySelector('.short');
            const fullText = p.querySelector('.full');
            if(fullText.style.display === 'none'){
                fullText.style.display='inline'; shortText.style.display='none'; el.textContent='Read Less';
            } else {
                fullText.style.display='none'; shortText.style.display='inline'; el.textContent='Read More';
            }
        }
    </script>

    <script>
        (function () {
            const grid = document.getElementById('homepageReviewsGrid');
            const toggleBtn = document.getElementById('homepageReviewsToggle');

            if (!grid || !toggleBtn) {
                return;
            }

            const hiddenCards = Array.from(grid.querySelectorAll('.is-hidden-review-card'));
            if (!hiddenCards.length) {
                return;
            }

            toggleBtn.addEventListener('click', function () {
                const isExpanded = toggleBtn.getAttribute('aria-expanded') === 'true';

                hiddenCards.forEach(function (card) {
                    card.classList.toggle('is-visible-review-card', !isExpanded);
                });

                toggleBtn.setAttribute('aria-expanded', String(!isExpanded));
                toggleBtn.querySelector('span').textContent = isExpanded ? 'View all' : 'View less';
            });
        })();
    </script>

    <script>
        (function () {
            const modal = document.getElementById('homepageWriteReviewModal');
            const openBtn = document.querySelector('[data-open-review-modal="true"]');
            const closeEls = modal ? modal.querySelectorAll('[data-close-review-modal="true"]') : [];
            const onsiteLink = modal ? modal.querySelector('[data-review-onsite="true"]') : null;
            const reviewContainer = document.querySelector('.review-container');
            const reviewForm = document.getElementById('reviewForm');

            if (!modal || !openBtn) {
                return;
            }

            function openModal(event) {
                if (event) {
                    event.preventDefault();
                }
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

            if (onsiteLink) {
                onsiteLink.addEventListener('click', function (event) {
                    event.preventDefault();
                    closeModal();
                    if (reviewContainer) {
                        reviewContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });

                        reviewContainer.classList.remove('review-pulse');
                        void reviewContainer.offsetWidth;
                        reviewContainer.classList.add('review-pulse');

                        setTimeout(function () {
                            reviewContainer.classList.remove('review-pulse');
                        }, 1800);
                    } else if (reviewForm) {
                        reviewForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                });
            }
        })();
    </script>
</section>

<link rel="stylesheet" href="<?= $base_url ?>/assets/css/wp_sn_reviews.css">

<style>
    .customer-review-section.homepage-review-section{
        width:83vw;
        margin:4rem auto;


    }

    .section-header h1.customer-review-section.title{
        text-align: center;
        /* background-color: grey; */
        padding:2rem 0rem;
    }

    .customer-review-section.homepage-review-section .homepage-review-summary{
        display:flex !important;
        align-items:center;
        justify-content:space-between;
        gap:1.25rem;
        width:100%;
        padding:1rem 1.25rem;
        border-radius:10px;
        background:linear-gradient(90deg, #f3f7fc 0%, #e9f1fb 100%);
        border:1px solid #dbe7f7;
        margin:0 auto 1.5rem;
    }

    .customer-review-section.homepage-review-section .homepage-review-summary-left{
        display:flex;
        flex-direction:column;
        gap:0.4rem;
        min-width:0;
    }

    .customer-review-section.homepage-review-section .homepage-review-rating-row{
        display:inline-flex;
        align-items:center;
        gap:0.5rem;
        flex-wrap:nowrap;
    }

    .customer-review-section.homepage-review-section .homepage-review-stars{
        display:inline-flex;
        align-items:center;
    }

    .customer-review-section.homepage-review-section .homepage-review-platforms{
        display:inline-flex;
        align-items:center;
        gap:0.375rem;
    }

    .customer-review-section.homepage-review-section .homepage-review-platforms strong{
        font-weight:500;
    }

    .customer-review-section.homepage-review-section .homepage-review-summary-cta{
        display:inline-flex !important;
        align-items:center;
        justify-content:center;
        min-height:44px;
        padding:0.875rem 1.75rem !important;
        border-radius:10px;
        background-color:#1f64a4 !important;
        color:#ffffff !important;
        text-decoration:none !important;
        font-weight:700;
        line-height:1.1;
        white-space:nowrap;
    }

    .customer-review-section.homepage-review-section .homepage-review-summary-cta:hover{
        background-color:#185487 !important;
        color:#ffffff !important;
    }

    .customer-review-section.homepage-review-section .is-hidden-review-card{
        display:none;
    }

    .customer-review-section.homepage-review-section .is-hidden-review-card.is-visible-review-card{
        display:flex;
    }

    .customer-review-section.homepage-review-section .homepage-reviews-footer{
        margin-top:1.2rem;
        display:flex;
        justify-content:flex-end;
    }

    .customer-review-section.homepage-review-section .homepage-reviews-toggle{
        display:inline-flex;
        align-items:center;
        gap:0.5rem;
        border:none;
        border-radius:0;
        background:transparent;
        color:#333;
        padding:0;
        cursor:pointer;
        font-weight:600;
    }

    .customer-review-section.homepage-review-section .homepage-reviews-toggle:hover{
        background:transparent;
    }

    .customer-review-section.homepage-review-section .homepage-reviews-toggle[aria-expanded="true"] svg{
        transform:rotate(90deg);
    }

    .customer-review-section.homepage-review-section .homepage-write-review-modal{
        position:fixed;
        inset:0;
        z-index:4000;
        display:none;
        align-items:center;
        justify-content:center;
        padding:1rem;
    }

    .customer-review-section.homepage-review-section .homepage-write-review-modal.is-active{
        display:flex;
    }

    .customer-review-section.homepage-review-section .homepage-write-review-modal__overlay{
        position:absolute;
        inset:0;
        background:rgba(0, 0, 0, 0.45);
    }

    .customer-review-section.homepage-review-section .homepage-write-review-modal__dialog{
        position:relative;
        width:min(92vw, 540px);
        margin:0;
        border-radius:18px;
        background:#ffffff;
        padding:1.5rem 1.6rem;
        box-shadow:0 20px 50px rgba(10, 29, 53, 0.2);
        max-height:calc(100vh - 2rem);
        overflow:auto;
    }

    .customer-review-section.homepage-review-section .homepage-write-review-modal__close{
        position:absolute;
        right:0.9rem;
        top:0.75rem;
        border:0;
        background:transparent;
        color:#5f6673;
        font-size:1.7rem;
        line-height:1;
        cursor:pointer;
    }

    .customer-review-section.homepage-review-section .homepage-write-review-modal__title{
        margin:0;
        text-align:center;
        font-size:2rem;
        line-height:1.15;
        color:#16253a;
    }

    .customer-review-section.homepage-review-section .homepage-write-review-modal__subtitle{
        margin:0.55rem 0 1.3rem;
        text-align:center;
        color:#4c5b70;
        font-size:1.06rem;
    }

    .customer-review-section.homepage-review-section .homepage-write-review-modal__options{
        display:flex;
        flex-direction:column;
        gap:0.82rem;
    }

    .customer-review-section.homepage-review-section .homepage-write-review-modal__option{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:0.75rem;
        border:1px solid #dce4ef;
        border-radius:12px;
        padding:0.95rem 1rem;
        color:#17243a !important;
        text-decoration:none !important;
        background:#ffffff;
    }

    .customer-review-section.homepage-review-section .homepage-write-review-modal__option:hover{
        border-color:#bdd0e7;
        background:#f8fbff;
    }

    .customer-review-section.homepage-review-section .homepage-write-review-modal__option-left{
        display:flex;
        align-items:center;
        gap:0.72rem;
        min-width:0;
    }

    .customer-review-section.homepage-review-section .homepage-write-review-modal__option-left span{
        font-size:1.08rem;
        color:#17243a;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
    }

    .customer-review-section.homepage-review-section .homepage-write-review-modal__arrow{
        color:#6a7383;
        font-size:1.3rem;
        line-height:1;
        flex:0 0 auto;
    }

    @media (max-width: 600px){
        .customer-review-section.homepage-review-section .homepage-review-summary{
            flex-direction:row !important;
            align-items:center;
            justify-content:space-between;
            gap:0.75rem;
        }

        .customer-review-section.homepage-review-section .homepage-review-summary-cta{
            padding:0.75rem 1rem !important;
            font-size:0.95rem;
        }

        .customer-review-section.homepage-review-section .homepage-write-review-modal__dialog{
            padding:1.2rem 1rem;
        }

        .customer-review-section.homepage-review-section .homepage-write-review-modal__title{
            font-size:1.65rem;
        }

        .customer-review-section.homepage-review-section .homepage-write-review-modal__option{
            padding:0.82rem 0.78rem;
        }

        .customer-review-section.homepage-review-section .homepage-write-review-modal__option-left span{
            font-size:0.98rem;
        }
    }
</style>