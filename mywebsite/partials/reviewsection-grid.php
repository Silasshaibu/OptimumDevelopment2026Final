    <!-- Reviews Body Section Start -->
<section class="customer-review-section">         
    <?php
    if (!function_exists('truncate_text')) {
        function truncate_text($text, $words = 30) {
            $words_array = preg_split('/\s+/', $text);
            if(count($words_array) > $words){
                $short = implode(' ', array_slice($words_array, 0, $words)) . '...';
                $rest = ' ' . implode(' ', array_slice($words_array, $words));
                return [$short, $rest];
            }
            return [$text, ''];
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
    ?>

    <div class="socials-reviews-container">
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
            
            // Get first letter for fallback - use name or fallback to 'U' for User
            $nameForInitial = $name ?? '';
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
        
        <div class="review-card">
            
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
                        <span class="full"><?= $text_rest ?></span>
                        <span class="read-more" onclick="toggleReview(this)">Read More</span>
                    <?php else: ?>
                        <?= $text_short ?>
                    <?php endif; ?>
                </p>

                
            </div>
        </div>
        
        <?php endforeach; ?>
    </div>


    <script>
        function toggleReview(el){
            const p = el.closest('p');
            if (!p) return;

            p.classList.toggle('is-expanded');
            el.textContent = p.classList.contains('is-expanded') ? 'Read Less' : 'Read More';
        }
    </script>

    <script>
        (function () {
            const container = document.querySelector('.customer-review-section .socials-reviews-container');
            if (!container) return;

            let currentColumnCount = 0;

            function getColumnCount() {
                if (window.innerWidth >= 1100) return 3;
                if (window.innerWidth >= 768) return 2;
                return 1;
            }

            function flattenColumns() {
                const columns = Array.from(container.querySelectorAll(':scope > .masonry-column'));
                if (!columns.length) {
                    return Array.from(container.querySelectorAll(':scope > .review-card'));
                }

                const cards = [];
                columns.forEach(function (column) {
                    cards.push(...Array.from(column.querySelectorAll('.review-card')));
                });

                columns.forEach(function (column) {
                    column.remove();
                });

                cards.forEach(function (card) {
                    container.appendChild(card);
                });

                return cards;
            }

            function applyIndependentMasonry() {
                const targetCount = getColumnCount();
                if (targetCount === currentColumnCount && container.classList.contains('independent-masonry')) {
                    return;
                }

                const cards = flattenColumns();
                const columns = Array.from({ length: targetCount }, function () {
                    const col = document.createElement('div');
                    col.className = 'masonry-column';
                    return col;
                });

                cards.forEach(function (card, index) {
                    columns[index % targetCount].appendChild(card);
                });

                container.classList.add('independent-masonry');
                columns.forEach(function (column) {
                    container.appendChild(column);
                });

                currentColumnCount = targetCount;
            }

            let resizeTimer = null;
            window.addEventListener('resize', function () {
                if (resizeTimer) clearTimeout(resizeTimer);
                resizeTimer = setTimeout(applyIndependentMasonry, 120);
            });

            applyIndependentMasonry();
        })();
    </script>

    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/wp_sn_reviews.css">

</section>
