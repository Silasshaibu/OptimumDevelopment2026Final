<?php
declare(strict_types=1);

if (!function_exists('avatar_cache_get_dir')) {
    function avatar_cache_get_dir(): string
    {
        $cacheDir = __DIR__ . '/../assets/images/review-avatars';
        if (!is_dir($cacheDir)) {
            @mkdir($cacheDir, 0775, true);
        }
        return $cacheDir;
    }
}

if (!function_exists('avatar_cache_is_allowed_url')) {
    function avatar_cache_is_allowed_url(string $url): bool
    {
        $parts = parse_url($url);
        if (!is_array($parts) || empty($parts['scheme']) || empty($parts['host'])) {
            return false;
        }

        $scheme = strtolower((string)$parts['scheme']);
        $host = strtolower((string)$parts['host']);
        if ($scheme !== 'https') {
            return false;
        }

        $allowedHosts = [
            'lh3.googleusercontent.com',
            'googleusercontent.com',
            'googleapis.com',
            'gstatic.com',
            'fbcdn.net',
            'fbsbx.com',
            'facebook.com',
            'static.xx.fbcdn.net'
        ];

        foreach ($allowedHosts as $allowedHost) {
            if ($host === $allowedHost || str_ends_with($host, '.' . $allowedHost)) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('avatar_cache_get_paths')) {
    function avatar_cache_get_paths(string $url): array
    {
        $cacheDir = avatar_cache_get_dir();
        $cacheKey = hash('sha256', $url);
        return [
            'file' => $cacheDir . '/' . $cacheKey . '.img',
            'meta' => $cacheDir . '/' . $cacheKey . '.json'
        ];
    }
}

if (!function_exists('avatar_cache_read_meta')) {
    function avatar_cache_read_meta(string $metaPath): array
    {
        if (!is_file($metaPath)) {
            return [];
        }
        $meta = json_decode((string)@file_get_contents($metaPath), true);
        return is_array($meta) ? $meta : [];
    }
}

if (!function_exists('avatar_cache_fetch_remote')) {
    function avatar_cache_fetch_remote(string $url, int $ttlSeconds = 86400, int $retryCooldownSeconds = 900): bool
    {
        if (!avatar_cache_is_allowed_url($url)) {
            return false;
        }

        $paths = avatar_cache_get_paths($url);
        $filePath = $paths['file'];
        $metaPath = $paths['meta'];

        $isFresh = is_file($filePath) && (time() - filemtime($filePath) < $ttlSeconds);
        if ($isFresh) {
            return true;
        }

        $meta = avatar_cache_read_meta($metaPath);
        $lastAttempt = isset($meta['last_attempt']) ? (int)$meta['last_attempt'] : 0;
        $canRetryNow = $lastAttempt === 0 || (time() - $lastAttempt) >= $retryCooldownSeconds;

        if (!$canRetryNow) {
            return is_file($filePath);
        }

        $content = null;
        $contentType = null;
        $statusCode = 0;

        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 5,
                CURLOPT_CONNECTTIMEOUT => 5,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_USERAGENT => 'OptimumPaymentsAvatarProxy/1.0',
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_HTTPHEADER => [
                    'Accept: image/*,*/*;q=0.8'
                ]
            ]);

            $content = curl_exec($ch);
            $statusCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $contentType = (string)curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
            curl_close($ch);
        } else {
            $context = stream_context_create([
                'http' => [
                    'method' => 'GET',
                    'timeout' => 10,
                    'header' => "Accept: image/*,*/*;q=0.8\r\n"
                ]
            ]);
            $content = @file_get_contents($url, false, $context);
            if (isset($http_response_header) && is_array($http_response_header)) {
                foreach ($http_response_header as $headerLine) {
                    if (preg_match('/^HTTP\/\S+\s+(\d{3})/i', $headerLine, $matches)) {
                        $statusCode = (int)$matches[1];
                    }
                    if (stripos($headerLine, 'Content-Type:') === 0) {
                        $contentType = trim(substr($headerLine, 13));
                    }
                }
            }
        }

        $isValidImage = is_string($content)
            && $content !== ''
            && $statusCode >= 200
            && $statusCode < 300
            && (stripos((string)$contentType, 'image/') === 0 || @getimagesizefromstring($content) !== false);

        if ($isValidImage) {
            @file_put_contents($filePath, $content);
            $meta = [
                'url' => $url,
                'content_type' => $contentType ?: 'image/jpeg',
                'fetched_at' => time(),
                'last_attempt' => time(),
                'last_status' => $statusCode
            ];
            @file_put_contents($metaPath, json_encode($meta));
            return true;
        }

        $meta['url'] = $url;
        $meta['last_attempt'] = time();
        $meta['last_status'] = $statusCode;
        @file_put_contents($metaPath, json_encode($meta));

        return is_file($filePath);
    }
}

if (!function_exists('avatar_cache_cleanup_old_files')) {
    function avatar_cache_cleanup_old_files(int $maxAgeSeconds = 2592000): int
    {
        $cacheDir = avatar_cache_get_dir();
        $deleted = 0;
        $now = time();

        $patterns = [$cacheDir . '/*.img', $cacheDir . '/*.json'];
        foreach ($patterns as $pattern) {
            $files = glob($pattern) ?: [];
            foreach ($files as $file) {
                $age = $now - (int)@filemtime($file);
                if ($age > $maxAgeSeconds) {
                    if (@unlink($file)) {
                        $deleted++;
                    }
                }
            }
        }

        return $deleted;
    }
}
