<?php
// consent.php — GDPR consent log endpoint

$data = json_decode(file_get_contents('php://input'), true);

if ($data && isset($data['accepted'])) {
    $file = __DIR__ . '/data/consent-log.txt';
    if (!is_dir(dirname($file))) {
        mkdir(dirname($file), 0755, true);
    }

    $ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP) ?: 'UNKNOWN';
    $log = [
        'time'    => date('Y-m-d H:i:s'),
        'ip'      => $ip,
        'consent' => $data,
    ];

    file_put_contents($file, json_encode($log) . "\n", FILE_APPEND);
}
