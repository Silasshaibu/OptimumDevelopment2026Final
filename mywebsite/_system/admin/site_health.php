<?php
session_start();
require_once '../db_pdo.php';
require_once __DIR__ . '/../../db.php';

$page_title = 'Site Health';
include 'admin-layout.php';

// Start timing for page load measurement
$start_time = microtime(true);

// Handle sitemap generation
$sitemap_message = '';
$sitemap_error = '';

if (isset($_POST['generate_sitemap'])) {
    $result = generateSitemap();
    if ($result['success']) {
        $sitemap_message = $result['message'];
    } else {
        $sitemap_error = $result['message'];
    }
}

// Function to generate sitemap
function generateSitemap() {
    $base_url = 'https://optimumpayments.com';
    $sitemap_path = dirname(__DIR__, 2) . '/sitemap.xml';
    
    // Define static pages
    $static_pages = [
        ['url' => '/', 'priority' => '1.0', 'changefreq' => 'daily'],
        ['url' => '/about', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['url' => '/contact-us', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['url' => '/processing-solutions', 'priority' => '0.9', 'changefreq' => 'weekly'],
        ['url' => '/business-financing', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['url' => '/digital-services', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['url' => '/our-partners', 'priority' => '0.7', 'changefreq' => 'monthly'],
        ['url' => '/customer-reviews', 'priority' => '0.7', 'changefreq' => 'weekly'],
        ['url' => '/merchant-application', 'priority' => '0.9', 'changefreq' => 'monthly'],
        ['url' => '/shop', 'priority' => '0.8', 'changefreq' => 'weekly'],
        ['url' => '/privacy-policy', 'priority' => '0.3', 'changefreq' => 'yearly'],
        ['url' => '/terms-of-service', 'priority' => '0.3', 'changefreq' => 'yearly'],
        // Product pages
        ['url' => '/clover-flex', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['url' => '/clover-mini', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['url' => '/clover-go', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['url' => '/clover-station-duo', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['url' => '/clover-station-solo', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['url' => '/valor-vp550', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['url' => '/valor-vp800', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['url' => '/valor-vl100', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['url' => '/valor-vl110', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['url' => '/valor-vp100', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['url' => '/swipe-simple', 'priority' => '0.7', 'changefreq' => 'monthly'],
        ['url' => '/union', 'priority' => '0.7', 'changefreq' => 'monthly'],
        ['url' => '/nmi', 'priority' => '0.7', 'changefreq' => 'monthly'],
        ['url' => '/tabit', 'priority' => '0.7', 'changefreq' => 'monthly'],
        ['url' => '/hyfin', 'priority' => '0.7', 'changefreq' => 'monthly'],
        ['url' => '/rectangle', 'priority' => '0.7', 'changefreq' => 'monthly'],
        ['url' => '/octopos', 'priority' => '0.7', 'changefreq' => 'monthly'],
        // Industry pages
        ['url' => '/retail-businesses', 'priority' => '0.7', 'changefreq' => 'monthly'],
        ['url' => '/table-service-restaurants', 'priority' => '0.7', 'changefreq' => 'monthly'],
        ['url' => '/counter-service-restaurants', 'priority' => '0.7', 'changefreq' => 'monthly'],
        ['url' => '/service-business', 'priority' => '0.7', 'changefreq' => 'monthly'],
        ['url' => '/ecommerce-businesses', 'priority' => '0.7', 'changefreq' => 'monthly'],
    ];
    
    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    
    $date = date('Y-m-d');
    
    foreach ($static_pages as $page) {
        $xml .= "  <url>\n";
        $xml .= "    <loc>{$base_url}{$page['url']}</loc>\n";
        $xml .= "    <lastmod>{$date}</lastmod>\n";
        $xml .= "    <changefreq>{$page['changefreq']}</changefreq>\n";
        $xml .= "    <priority>{$page['priority']}</priority>\n";
        $xml .= "  </url>\n";
    }
    
    $xml .= '</urlset>';
    
    // Write sitemap
    if (file_put_contents($sitemap_path, $xml)) {
        return [
            'success' => true,
            'message' => 'Sitemap generated successfully! ' . count($static_pages) . ' URLs included. <a href="/sitemap.xml" target="_blank">View Sitemap</a>'
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Failed to write sitemap file. Check file permissions.'
        ];
    }
}

// Get system info
function getSystemInfo() {
    global $conn, $pdo;
    
    $info = [];
    
    // PHP Version
    $info['php_version'] = [
        'label' => 'PHP Version',
        'value' => phpversion(),
        'status' => version_compare(phpversion(), '7.4', '>=') ? 'good' : 'warning'
    ];
    
    // MySQL Version
    try {
        $mysql_version = $pdo->query('SELECT VERSION()')->fetchColumn();
        $info['mysql_version'] = [
            'label' => 'MySQL Version',
            'value' => $mysql_version,
            'status' => 'good'
        ];
    } catch (Exception $e) {
        $info['mysql_version'] = [
            'label' => 'MySQL Version',
            'value' => 'Unable to detect',
            'status' => 'error'
        ];
    }
    
    // Database Connection
    $info['db_connection'] = [
        'label' => 'Database Connection',
        'value' => $conn ? 'Connected (mysqli)' : 'Not connected',
        'status' => $conn ? 'good' : 'error'
    ];
    
    // PDO Connection
    $info['pdo_connection'] = [
        'label' => 'PDO Connection',
        'value' => $pdo ? 'Connected' : 'Not connected',
        'status' => $pdo ? 'good' : 'error'
    ];
    
    // Server Software
    $info['server_software'] = [
        'label' => 'Web Server',
        'value' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
        'status' => 'info'
    ];
    
    // Memory Limit
    $memory_limit = ini_get('memory_limit');
    $info['memory_limit'] = [
        'label' => 'PHP Memory Limit',
        'value' => $memory_limit,
        'status' => (intval($memory_limit) >= 128) ? 'good' : 'warning'
    ];
    
    // Max Execution Time
    $max_execution = ini_get('max_execution_time');
    $info['max_execution'] = [
        'label' => 'Max Execution Time',
        'value' => $max_execution . ' seconds',
        'status' => ($max_execution >= 30) ? 'good' : 'warning'
    ];
    
    // Upload Max Filesize
    $upload_max = ini_get('upload_max_filesize');
    $info['upload_max'] = [
        'label' => 'Upload Max Filesize',
        'value' => $upload_max,
        'status' => (intval($upload_max) >= 8) ? 'good' : 'warning'
    ];
    
    // Post Max Size
    $post_max = ini_get('post_max_size');
    $info['post_max'] = [
        'label' => 'Post Max Size',
        'value' => $post_max,
        'status' => 'info'
    ];
    
    // HTTPS
    $is_https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
    $info['https'] = [
        'label' => 'HTTPS Status',
        'value' => $is_https ? 'Enabled' : 'Not enabled (localhost)',
        'status' => $is_https ? 'good' : 'warning'
    ];
    
    return $info;
}

// Get file/folder checks
function getFileChecks() {
    $checks = [];
    $base_path = dirname(__DIR__, 2);
    
    $paths_to_check = [
        ['path' => '/sitemap.xml', 'writable' => true, 'type' => 'file'],
        ['path' => '/robots.txt', 'writable' => true, 'type' => 'file'],
        ['path' => '/assets/images/products', 'writable' => true, 'type' => 'dir'],
        ['path' => '/data', 'writable' => true, 'type' => 'dir'],
        ['path' => '/_system', 'writable' => false, 'type' => 'dir'],
        ['path' => '/config.php', 'writable' => false, 'type' => 'file'],
    ];
    
    foreach ($paths_to_check as $item) {
        $full_path = $base_path . $item['path'];
        $exists = file_exists($full_path);
        $writable = is_writable($full_path);
        
        if (!$exists) {
            $status = 'error';
            $message = 'Missing';
        } elseif ($item['writable'] && !$writable) {
            $status = 'warning';
            $message = 'Not writable';
        } elseif (!$item['writable'] && $writable && $item['type'] === 'file') {
            $status = 'warning';
            $message = 'Writable (should be read-only)';
        } else {
            $status = 'good';
            $message = $exists ? 'OK' : 'Missing';
        }
        
        $checks[] = [
            'path' => $item['path'],
            'exists' => $exists,
            'writable' => $writable,
            'status' => $status,
            'message' => $message
        ];
    }
    
    return $checks;
}

// Get database stats
function getDatabaseStats() {
    global $pdo;
    $stats = [];
    
    try {
        // Products count
        $stmt = $pdo->query("SELECT COUNT(*) FROM products");
        $stats['products'] = $stmt->fetchColumn();
        
        // Reviews count
        $stmt = $pdo->query("SELECT COUNT(*) FROM reviews WHERE status = 'approved'");
        $stats['reviews'] = $stmt->fetchColumn();
        
        // Contact messages count
        $stmt = $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE is_read = 0");
        $stats['unread_messages'] = $stmt->fetchColumn();
        
        // Merchant applications
        $stmt = $pdo->query("SELECT COUNT(*) FROM merchant_applications WHERE status = 'pending'");
        $stats['pending_applications'] = $stmt->fetchColumn();
        
    } catch (Exception $e) {
        // Tables might not exist
    }
    
    return $stats;
}

// Get sitemap info
function getSitemapInfo() {
    $sitemap_path = dirname(__DIR__, 2) . '/sitemap.xml';
    
    if (file_exists($sitemap_path)) {
        $modified = filemtime($sitemap_path);
        $size = filesize($sitemap_path);
        
        // Count URLs in sitemap
        $content = file_get_contents($sitemap_path);
        $url_count = substr_count($content, '<url>');
        
        return [
            'exists' => true,
            'modified' => date('M d, Y H:i:s', $modified),
            'size' => round($size / 1024, 2) . ' KB',
            'url_count' => $url_count
        ];
    }
    
    return ['exists' => false];
}

$system_info = getSystemInfo();
$file_checks = getFileChecks();
$db_stats = getDatabaseStats();
$sitemap_info = getSitemapInfo();
$page_load_time = round((microtime(true) - $start_time) * 1000, 2);
?>

<style>
.health-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.health-card {
    background: #fff;
    border: 1px solid #ccd0d4;
    border-radius: 4px;
    box-shadow: 0 1px 1px rgba(0,0,0,.04);
}

.health-card-header {
    background: #f6f7f7;
    padding: 12px 15px;
    border-bottom: 1px solid #ccd0d4;
    display: flex;
    align-items: center;
    gap: 10px;
}

.health-card-header h3 {
    margin: 0;
    font-size: 14px;
    font-weight: 600;
    color: #1d2327;
}

.health-card-body {
    padding: 15px;
}

.health-table {
    width: 100%;
    border-collapse: collapse;
}

.health-table td {
    padding: 8px 10px;
    border-bottom: 1px solid #f0f0f1;
    font-size: 13px;
}

.health-table tr:last-child td {
    border-bottom: none;
}

.health-table td:first-child {
    color: #50575e;
    width: 45%;
}

.health-table td:last-child {
    font-weight: 500;
}

.status-badge {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 3px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-good { background: #d4edda; color: #155724; }
.status-warning { background: #fff3cd; color: #856404; }
.status-error { background: #f8d7da; color: #721c24; }
.status-info { background: #d1ecf1; color: #0c5460; }

.sitemap-section {
    background: #fff;
    border: 1px solid #ccd0d4;
    border-radius: 4px;
    padding: 20px;
    margin-bottom: 20px;
}

.sitemap-section h3 {
    margin: 0 0 15px 0;
    font-size: 16px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.sitemap-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
    margin-bottom: 20px;
    padding: 15px;
    background: #f6f7f7;
    border-radius: 4px;
}

.sitemap-stat {
    text-align: center;
}

.sitemap-stat-value {
    font-size: 24px;
    font-weight: 600;
    color: #2271b1;
}

.sitemap-stat-label {
    font-size: 12px;
    color: #646970;
    margin-top: 5px;
}

.generate-btn {
    background: #2271b1;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.generate-btn:hover {
    background: #135e96;
}

.performance-bar {
    background: #e5e5e5;
    border-radius: 10px;
    height: 20px;
    overflow: hidden;
    margin-top: 10px;
}

.performance-fill {
    height: 100%;
    border-radius: 10px;
    transition: width 0.5s ease;
}

.performance-good { background: linear-gradient(90deg, #28a745, #5cb85c); }
.performance-warning { background: linear-gradient(90deg, #ffc107, #ffdb4d); }
.performance-error { background: linear-gradient(90deg, #dc3545, #ff6b6b); }

.load-time-display {
    font-size: 32px;
    font-weight: 600;
    color: #2271b1;
    text-align: center;
    margin: 20px 0;
}

.load-time-label {
    text-align: center;
    color: #646970;
    font-size: 13px;
}

.quick-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
    margin-bottom: 20px;
}

.quick-stat {
    background: #fff;
    border: 1px solid #ccd0d4;
    border-radius: 4px;
    padding: 20px;
    text-align: center;
}

.quick-stat-value {
    font-size: 28px;
    font-weight: 600;
    color: #1d2327;
}

.quick-stat-label {
    font-size: 12px;
    color: #646970;
    margin-top: 5px;
}

@media (max-width: 768px) {
    .health-grid {
        grid-template-columns: 1fr;
    }
    .quick-stats {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<?php if ($sitemap_message): ?>
    <div class="admin-notification success"><?php echo $sitemap_message; ?></div>
<?php endif; ?>

<?php if ($sitemap_error): ?>
    <div class="admin-notification error"><?php echo htmlspecialchars($sitemap_error); ?></div>
<?php endif; ?>

<!-- Quick Stats -->
<div class="quick-stats">
    <div class="quick-stat">
        <div class="quick-stat-value"><?php echo $db_stats['products'] ?? 0; ?></div>
        <div class="quick-stat-label">Products</div>
    </div>
    <div class="quick-stat">
        <div class="quick-stat-value"><?php echo $db_stats['reviews'] ?? 0; ?></div>
        <div class="quick-stat-label">Approved Reviews</div>
    </div>
    <div class="quick-stat">
        <div class="quick-stat-value"><?php echo $db_stats['unread_messages'] ?? 0; ?></div>
        <div class="quick-stat-label">Unread Messages</div>
    </div>
    <div class="quick-stat">
        <div class="quick-stat-value"><?php echo $db_stats['pending_applications'] ?? 0; ?></div>
        <div class="quick-stat-label">Pending Applications</div>
    </div>
</div>

<!-- Sitemap Generator Section -->
<div class="sitemap-section">
    <h3>🗺️ Sitemap Generator</h3>
    
    <?php if ($sitemap_info['exists']): ?>
    <div class="sitemap-info">
        <div class="sitemap-stat">
            <div class="sitemap-stat-value"><?php echo $sitemap_info['url_count']; ?></div>
            <div class="sitemap-stat-label">URLs in Sitemap</div>
        </div>
        <div class="sitemap-stat">
            <div class="sitemap-stat-value"><?php echo $sitemap_info['size']; ?></div>
            <div class="sitemap-stat-label">File Size</div>
        </div>
        <div class="sitemap-stat">
            <div class="sitemap-stat-value" style="font-size: 14px;"><?php echo $sitemap_info['modified']; ?></div>
            <div class="sitemap-stat-label">Last Generated</div>
        </div>
    </div>
    <?php else: ?>
    <div class="admin-notification warning" style="margin-bottom: 15px;">
        No sitemap found. Generate one to help search engines index your site.
    </div>
    <?php endif; ?>
    
    <form method="POST" style="display: inline-block;">
        <button type="submit" name="generate_sitemap" class="generate-btn">
            🔄 <?php echo $sitemap_info['exists'] ? 'Regenerate Sitemap' : 'Generate Sitemap'; ?>
        </button>
    </form>
    
    <?php if ($sitemap_info['exists']): ?>
    <a href="/sitemap.xml" target="_blank" class="generate-btn" style="background: #50575e; margin-left: 10px;">
        👁️ View Sitemap
    </a>
    <?php endif; ?>
</div>

<!-- Health Grid -->
<div class="health-grid">
    <!-- System Information -->
    <div class="health-card">
        <div class="health-card-header">
            <span>⚙️</span>
            <h3>System Information</h3>
        </div>
        <div class="health-card-body">
            <table class="health-table">
                <?php foreach ($system_info as $key => $item): ?>
                <tr>
                    <td><?php echo $item['label']; ?></td>
                    <td>
                        <?php echo htmlspecialchars($item['value']); ?>
                        <span class="status-badge status-<?php echo $item['status']; ?>"><?php echo $item['status']; ?></span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
    
    <!-- Page Load Performance -->
    <div class="health-card">
        <div class="health-card-header">
            <span>⚡</span>
            <h3>Page Load Performance</h3>
        </div>
        <div class="health-card-body">
            <div class="load-time-display"><?php echo $page_load_time; ?> ms</div>
            <div class="load-time-label">Admin Page Load Time</div>
            
            <?php
            $perf_class = 'good';
            $perf_width = min(100, ($page_load_time / 10));
            if ($page_load_time > 500) $perf_class = 'error';
            elseif ($page_load_time > 200) $perf_class = 'warning';
            ?>
            <div class="performance-bar">
                <div class="performance-fill performance-<?php echo $perf_class; ?>" style="width: <?php echo $perf_width; ?>%"></div>
            </div>
            
            <table class="health-table" style="margin-top: 15px;">
                <tr>
                    <td>Rating</td>
                    <td>
                        <?php if ($page_load_time < 100): ?>
                            <span class="status-badge status-good">Excellent</span>
                        <?php elseif ($page_load_time < 300): ?>
                            <span class="status-badge status-good">Good</span>
                        <?php elseif ($page_load_time < 500): ?>
                            <span class="status-badge status-warning">Moderate</span>
                        <?php else: ?>
                            <span class="status-badge status-error">Slow</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>Memory Used</td>
                    <td><?php echo round(memory_get_peak_usage(true) / 1024 / 1024, 2); ?> MB</td>
                </tr>
            </table>
        </div>
    </div>
    
    <!-- File & Directory Checks -->
    <div class="health-card">
        <div class="health-card-header">
            <span>📁</span>
            <h3>File & Directory Status</h3>
        </div>
        <div class="health-card-body">
            <table class="health-table">
                <?php foreach ($file_checks as $check): ?>
                <tr>
                    <td><code><?php echo $check['path']; ?></code></td>
                    <td>
                        <span class="status-badge status-<?php echo $check['status']; ?>"><?php echo $check['message']; ?></span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
    
    <!-- PHP Extensions -->
    <div class="health-card">
        <div class="health-card-header">
            <span>🧩</span>
            <h3>PHP Extensions</h3>
        </div>
        <div class="health-card-body">
            <table class="health-table">
                <?php
                $required_extensions = ['pdo', 'pdo_mysql', 'mysqli', 'json', 'mbstring', 'curl', 'gd', 'fileinfo'];
                foreach ($required_extensions as $ext):
                    $loaded = extension_loaded($ext);
                ?>
                <tr>
                    <td><?php echo $ext; ?></td>
                    <td>
                        <span class="status-badge status-<?php echo $loaded ? 'good' : 'error'; ?>">
                            <?php echo $loaded ? 'Enabled' : 'Missing'; ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>

<?php include 'admin-layout-footer.php'; ?>
