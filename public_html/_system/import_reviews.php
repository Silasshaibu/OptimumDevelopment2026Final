<?php echo "We are on importing reviews to database first"; ?>

<?php
if (!extension_loaded('mysqli')) {
    die("MySQLi extension not loaded. Please enable it in php.ini and restart Apache.");
}

require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/avatar_cache_helper.php';

if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}

$apiUrl = "https://site.optimum-payments.com/wp-json/reviews/v1/all";
$apiKey = "f8d3a1b9c2e74f6a91d0b7e2c4f5a8d3";

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["x-api-key: $apiKey"]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$json = curl_exec($ch);
curl_close($ch);

$data = json_decode($json, true);
$reviews = $data['reviews'] ?? [];

$insertedCount = 0;
$prewarmedCount = 0;

foreach ($reviews as $review) {
    // Check if already exists (by name and text to avoid duplicates)
    $stmt = $conn->prepare("SELECT id FROM reviews WHERE guest_email = ? AND review = ? AND source = 'imported'");
    $stmt->bind_param("ss", $review['name'], $review['text']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) continue; // Skip if exists

    // Map fields
    $status = 'approved'; // Imported reviews are pre-approved
    $created_at = date('Y-m-d H:i:s', strtotime($review['date'] ?? 'now'));

    $name = $review['name'];
    $rating = $review['rating'] ?? 5;
    $text = $review['text'];
    $platform = $review['platform'];
    $avatar = $review['avatar'] ?? '';
    $link = $review['link'] ?? '';
    $recommendation = $review['recommendation'] ?? '';

    if (!empty($avatar) && filter_var($avatar, FILTER_VALIDATE_URL)) {
        if (avatar_cache_fetch_remote($avatar, 86400, 900)) {
            $prewarmedCount++;
        }
    }

    // Insert
    $stmt = $conn->prepare("INSERT INTO reviews (guest_email, rating, review, status, source, platform, reviewer_img, reviewer_url, recommendation_type, created_at) VALUES (?, ?, ?, ?, 'imported', ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisssssss", 
        $name, 
        $rating, 
        $text, 
        $status, 
        $platform, 
        $avatar, 
        $link, 
        $recommendation, 
        $created_at
    );
    $stmt->execute();
    $insertedCount++;
}

$deletedCacheFiles = avatar_cache_cleanup_old_files(2592000);

echo "Imported {$insertedCount} new reviews out of " . count($reviews)
    . ". Prewarmed {$prewarmedCount} avatar(s). Cleaned {$deletedCacheFiles} old cache file(s).";
?>