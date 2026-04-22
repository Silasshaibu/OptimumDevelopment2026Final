<?php
declare(strict_types=1);

require_once __DIR__ . '/avatar_cache_helper.php';

$url = isset($_GET['url']) ? trim((string)$_GET['url']) : '';

if ($url === '') {
    http_response_code(400);
    exit;
}

if (!avatar_cache_is_allowed_url($url)) {
    http_response_code(403);
    exit;
}


if (mt_rand(1, 100) === 1) {
    avatar_cache_cleanup_old_files(2592000);
}

avatar_cache_fetch_remote($url, 86400, 900);

$paths = avatar_cache_get_paths($url);
$filePath = $paths['file'];
$metaPath = $paths['meta'];
$meta = avatar_cache_read_meta($metaPath);
$isFresh = is_file($filePath) && (time() - filemtime($filePath) < 86400);

if (!is_file($filePath)) {
    $fallbackPath = __DIR__ . '/../assets/images/review-avatars/default-avatar.svg';
    if (is_file($fallbackPath)) {
        header('Content-Type: image/svg+xml');
        header('Cache-Control: public, max-age=3600');
        header('X-Avatar-Cache: FALLBACK');
        readfile($fallbackPath);
        exit;
    }

    http_response_code(404);
    exit;
}

$defaultType = 'image/jpeg';
$mimeType = $defaultType;
if (!empty($meta['content_type']) && is_string($meta['content_type'])) {
    $mimeType = $meta['content_type'];
}

header('Content-Type: ' . $mimeType);
header('Cache-Control: public, max-age=3600');
header('X-Avatar-Cache: ' . ($isFresh ? 'HIT' : 'MISS'));
readfile($filePath);
exit;
