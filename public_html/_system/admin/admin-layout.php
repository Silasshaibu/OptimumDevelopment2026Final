<?php
/**
 * WordPress-Style Admin Layout Template
 * Include this file at the start of each admin page
 */

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}

// Get current page for active menu highlighting
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Admin Dashboard'; ?> - Optimum Payments</title>
    <link rel="stylesheet" href="admin-style.css">
</head>
<body class="admin-body">
    
    <!-- Top Admin Bar -->
    <div id="admin-bar">
        <div class="admin-bar-left">
            <button id="sidebar-toggle" class="sidebar-toggle-btn">
                <span class="dashicons">☰</span>
            </button>
            <a href="index.php" class="site-name">
                <strong>Optimum Payments</strong>
            </a>
        </div>
        <div class="admin-bar-right">
            <span class="admin-welcome">Howdy, <strong><?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?></strong></span>
            <div class="admin-user-menu">
                <button class="user-dropdown-toggle">
                    <span class="dashicons">👤</span>
                    <span class="dashicons-arrow">▼</span>
                </button>
                <ul class="user-dropdown-menu">
                    <li><a href="/">Visit Site</a></li>
                    <li><a href="../logout.php">Log Out</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Admin Sidebar Navigation -->
    <div id="admin-sidebar" class="admin-sidebar">
        <ul class="admin-menu">
            <li class="menu-item <?php echo $current_page === 'index' || $current_page === 'dashboard' ? 'active' : ''; ?>">
                <a href="index.php">
                    <span class="dashicons">🏠</span>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
            
            <li class="menu-item has-submenu <?php echo in_array($current_page, ['shop', 'top_selling_products', 'handheld_devices', 'supplies']) ? 'active' : ''; ?>">
                <a href="#" class="submenu-toggle">
                    <span class="dashicons">🛒</span>
                    <span class="menu-text">Ecommerce</span>
                    <span class="submenu-arrow">▼</span>
                </a>
                <ul class="submenu">
                    <li class="submenu-item <?php echo $current_page === 'shop' ? 'active' : ''; ?>">
                        <a href="shop.php">
                            <span class="menu-text">Shop(Affiliate)</span>
                        </a>
                    </li>
                    <li class="submenu-item <?php echo $current_page === 'top_selling_products' ? 'active' : ''; ?>">
                        <a href="top_selling_products.php">
                            <span class="menu-text">Top Selling Products</span>
                        </a>
                    </li>
                    <li class="submenu-item <?php echo $current_page === 'handheld_devices' ? 'active' : ''; ?>">
                        <a href="handheld_devices.php">
                            <span class="menu-text">Handheld Devices</span>
                        </a>
                    </li>
                    <li class="submenu-item <?php echo $current_page === 'supplies' ? 'active' : ''; ?>">
                        <a href="supplies.php">
                            <span class="menu-text">Supplies</span>
                        </a>
                    </li>
                </ul>
            </li>
            
            <li class="menu-item <?php echo $current_page === 'reviews' || $current_page === 'review_view' ? 'active' : ''; ?>">
                <a href="reviews.php">
                    <span class="dashicons">⭐</span>
                    <span class="menu-text">Reviews</span>
                </a>
            </li>
            
            <li class="menu-item <?php echo $current_page === 'messages' || $current_page === 'message_view' ? 'active' : ''; ?>">
                <a href="messages.php">
                    <span class="dashicons">📩</span>
                    <span class="menu-text">Contact Messages</span>
                </a>
            </li>
            
            <li class="menu-item <?php echo $current_page === 'merchant_applications' || $current_page === 'merchant_application_view' ? 'active' : ''; ?>">
                <a href="merchant_applications.php">
                    <span class="dashicons">📋</span>
                    <span class="menu-text">Merchant Applications</span>
                </a>
            </li>
            
            <li class="menu-item <?php echo $current_page === 'digital_briefs' || $current_page === 'digital_brief_view' ? 'active' : ''; ?>">
                <a href="digital_briefs.php">
                    <span class="dashicons">💼</span>
                    <span class="menu-text">Digital Briefs</span>
                </a>
            </li>

            <li class="menu-item <?php echo $current_page === 'business_referrals' || $current_page === 'business_referral_view' ? 'active' : ''; ?>">
                <a href="business_referrals.php">
                    <span class="dashicons">🤝</span>
                    <span class="menu-text">Business Referrals</span>
                </a>
            </li>

            <li class="menu-item <?php echo $current_page === 'business_owners' || $current_page === 'business_owner_view' ? 'active' : ''; ?>">
                <a href="business_owners.php">
                    <span class="dashicons">💰</span>
                    <span class="menu-text">Business Owners</span>
                </a>
            </li>

            <li class="menu-separator"></li>
            
            <li class="menu-item <?php echo $current_page === 'site_health' ? 'active' : ''; ?>">
                <a href="site_health.php">
                    <span class="dashicons">🩺</span>
                    <span class="menu-text">Site Health</span>
                </a>
            </li>

            <li class="menu-separator"></li>

            <li class="menu-item">
                <a href="../logout.php">
                    <span class="dashicons">🚪</span>
                    <span class="menu-text">Logout</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content Wrapper -->
    <div id="admin-content" class="admin-content">
        <div class="admin-content-inner">
            <?php if (isset($page_title)): ?>
            <div class="admin-page-header">
                <h1 class="admin-page-title"><?php echo $page_title; ?></h1>
                <?php if (isset($page_actions)): ?>
                <div class="admin-page-actions">
                    <?php echo $page_actions; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            
            <!-- Page content will be inserted here -->
