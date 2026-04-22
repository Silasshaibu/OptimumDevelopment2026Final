<?php
    $apiUrl = "https://site.optimum-payments.com/wp-json/reviews/v1/facebook";
    $apiKey = "f8d3a1b9c2e74f6a91d0b7e2c4f5a8d3"; // Your API key

    // Fetch JSON from WordPress
    $ch = curl_init($apiUrl);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false, // Local dev only
        CURLOPT_HTTPHEADER => [
            "X-API-Key: $apiKey"
        ]
    ]);
    $json = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($json, true);

    if (!$data || empty($data['reviews'])) {
        echo "<p>No reviews available.</p>";
        exit;
    }

    // Truncate long text for "Read More" functionality
    function truncate_text($text, $words = 30) {
        $words_array = preg_split('/\s+/', $text);
        if(count($words_array) > $words){
            $short = implode(' ', array_slice($words_array, 0, $words)) . '...';
            return [$short, $text];
        }
        return [$text, null];
    }
?>

<?php
    $reviews = $data['reviews'];

    // Calculate average rating
    $totalRating = 0;
    $reviewCount = count($reviews);

    foreach ($reviews as $rev) {
        $totalRating += intval($rev['rating'] ?? 0);
    }

    $averageRating = $reviewCount > 0 ? round($totalRating / $reviewCount, 1) : 0;
    $fullStars = floor($averageRating);
?>

<div class="socials-reviews-container">
    <?php foreach ($data['reviews'] as $index => $review): ?>
        <?php
            $name = htmlspecialchars($review['name']);
            $text_full = htmlspecialchars($review['text']);
            $date = date('F j, Y', strtotime($review['date']));

            // Recommendation default
            $recommendation = $review['recommendation'] ?? 'positive';
            $isPositive = $recommendation === 'positive';

            // Avatar & FB link
            $avatar = $review['avatar'] ?: 'https://platform-lookaside.fbsbx.com/platform/profilepic/?height=120&width=120';
            $avatarSrc = filter_var($avatar, FILTER_VALIDATE_URL)
                ? ($base_url . '/_system/avatar_proxy.php?url=' . rawurlencode($avatar))
                : $avatar;
            $fbLink = $review['fb_link'] ?? '#';

            // Optional rating
            $rating = intval($review['rating'] ?? 0);

            // Truncate long text for Read More
            list($text_short, $text_rest) = truncate_text($text_full, 40);
        ?>

        <div class="wpsr-review-template" data-index="<?= $index+1 ?>">
            <div class="wpsr-reviewer-image">
                <a href="<?= $fbLink ?>" target="_blank" rel="noopener noreferrer nofollow">
                    <img src="<?= htmlspecialchars($avatarSrc) ?>" alt="<?= $name ?>">
                </a>
            </div>

            <div class="wpsr-review-platform">
                <img src="https://site.optimum-payments.com/wp-content/plugins/wp-social-reviews/assets/images/icon/icon-facebook-small.png" loading="lazy" alt="facebook">
            </div>

            <div class="wpsr-review-info">
                <a href="<?= $fbLink ?>" target="_blank" rel="noopener noreferrer nofollow">
                    <span class="wpsr-reviewer-name"><?= $name ?></span>
                </a>

                <div class="wpsr-rating-wrapper">
                    <span class="badge">
                        <img src="https://static.xx.fbcdn.net/rsrc.php/v4/y6/r/2CYZBtJFeT2.png?_nc_eui2=AeGeyJ2ivzVUMLo6crvLVUXa8gAuoGlcyc7yAC6gaVzJzgcA096PuKwIhQjMQra4tsgd7cv0aggV3Mg-i6g858A-" loading="lazy" alt="Recommended">
                        <?= $isPositive ? 'Recommended' : 'Not Recommended' ?>
                    </span>
                </div>

                <div class="wpsr-review-content">
                    <?php if($text_rest): ?>
                        <p>
                            <span class="wpsr-show-less"><?= $text_short ?></span>
                            <span class="wpsr-show-more" style="display:none;"><?= $text_full ?></span>
                            <span class="read-more" onclick="toggleReview(this)">Read More</span>
                        </p>
                    <?php else: ?>
                        <p><?= $text_full ?></p>
                    <?php endif; ?>
                </div>

                <span class="wpsr-review-date"><?= $date ?></span>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
    function toggleReview(el){
        const p = el.closest('p');
        const shortText = p.querySelector('.wpsr-show-less');
        const fullText = p.querySelector('.wpsr-show-more');

        if(fullText.style.display === 'none'){
            fullText.style.display = 'inline';
            shortText.style.display = 'none';
            el.textContent = 'Read Less';
        } else {
            fullText.style.display = 'none';
            shortText.style.display = 'inline';
            el.textContent = 'Read More';
        }
    }
</script>

<div class="wpsr-business-info-left">
    <div class="wpsr-business-info-logo">
        <img src="<?= $base_url ?>/assets/images/logo/icon-facebook.webp" loading="lazy" alt="facebook">
        <span> Rating</span>
    </div>
    <div class="wpsr-rating-and-count">
        <span class="wpsr-total-rating"><?= number_format($averageRating, 1) ?></span>
        <span class="wpsr-rating">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <div class="wpsr-star-container">
                    <div class="wpsr-star-empty"></div>
                    <?php if ($i <= $fullStars): ?>
                        <div class="wpsr-star-filled" style="--wpsr-review-star-fill: 100%;"></div>
                    <?php else: ?>
                        <div class="wpsr-star-filled" style="--wpsr-review-star-fill: 0%;"></div>
                    <?php endif; ?>
                </div>
            <?php endfor; ?>
        </span>
        <span class="wpsr-review-count">(<?= $reviewCount ?> Reviews)</span>
    </div>
</div>

 <link rel="stylesheet" href="<?= $base_url ?>/assets/css/wp_sn_reviews.css">


