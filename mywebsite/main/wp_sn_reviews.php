
<?php
function truncate_text($text, $words = 30) {
    $words_array = preg_split('/\s+/', $text);
    if(count($words_array) > $words){
        $short = implode(' ', array_slice($words_array, 0, $words)) . '...';
        return [$short, $text];
    }
    return [$text, null];
}

// Fetch imported reviews from DB
$stmt = $conn->prepare("SELECT * FROM reviews WHERE source = 'imported' AND status = 'approved' ORDER BY created_at DESC");
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
        $avatar = $review['reviewer_img'] ?: 'default-avatar.png';
        $avatarIsRemote = filter_var($avatar, FILTER_VALIDATE_URL);
        $avatarSrc = $avatarIsRemote
            ? ($base_url . '/_system/avatar_proxy.php?url=' . rawurlencode($avatar))
            : $avatar;
        $link = $review['reviewer_url'] ?: '#';

        list($text_short, $text_rest) = truncate_text($text_full, 40);
    ?>
    
    <div class="review-card">
        
        <div>
            <div class="review-card-top-level">   

                <a href="<?= $link ?>" class="avatAnchor-block" target="_blank"><img class="avatar" src="<?= htmlspecialchars($avatarSrc) ?>" alt="<?= $name ?>" width="48" height="48">
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



 <link rel="stylesheet" href="<?= $base_url ?>/assets/css/wp_sn_reviews.css">
