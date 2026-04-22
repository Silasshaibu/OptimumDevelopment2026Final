<?php
session_start();
require_once __DIR__ . '/../../db.php';

// Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}

$page_title = 'Dashboard';

// Get statistics
$stats = [];

// Total Reviews
$result = $conn->query("SELECT COUNT(*) as total, 
    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved
    FROM reviews");
$stats['reviews'] = $result ? $result->fetch_assoc() : ['total' => 0, 'pending' => 0, 'approved' => 0];

// Total Contact Messages
$result = $conn->query("SELECT COUNT(*) as total,
    SUM(CASE WHEN status = 'new' THEN 1 ELSE 0 END) as new_messages,
    SUM(CASE WHEN status = 'read' THEN 1 ELSE 0 END) as read_messages
    FROM contact_messages");
$stats['messages'] = $result ? $result->fetch_assoc() : ['total' => 0, 'new_messages' => 0, 'read_messages' => 0];

// Total Merchant Applications
$result = $conn->query("SELECT COUNT(*) as total,
    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
    SUM(CASE WHEN confirmed = 1 THEN 1 ELSE 0 END) as confirmed
    FROM merchant_applications");
$stats['applications'] = $result ? $result->fetch_assoc() : ['total' => 0, 'pending' => 0, 'confirmed' => 0];

// Total Digital Briefs
$result = $conn->query("SELECT COUNT(*) as total,
    SUM(CASE WHEN status = 'new' THEN 1 ELSE 0 END) as new_briefs,
    SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) as in_progress
    FROM digital_briefs");
$stats['digital_briefs'] = $result ? $result->fetch_assoc() : ['total' => 0, 'new_briefs' => 0, 'in_progress' => 0];

// Total Business Referrals
$result = $conn->query("SELECT COUNT(*) as total,
    SUM(CASE WHEN status = 'new' THEN 1 ELSE 0 END) as new_referrals,
    SUM(CASE WHEN status = 'paid' THEN 1 ELSE 0 END) as paid
    FROM business_referrals");
$stats['referrals'] = $result ? $result->fetch_assoc() : ['total' => 0, 'new_referrals' => 0, 'paid' => 0];

// Total Business Owners
$result = $conn->query("SELECT COUNT(*) as total,
    SUM(CASE WHEN status = 'new' THEN 1 ELSE 0 END) as new_owners,
    SUM(CASE WHEN status = 'closed_won' THEN 1 ELSE 0 END) as closed_won
    FROM business_owners");
$stats['business_owners'] = $result ? $result->fetch_assoc() : ['total' => 0, 'new_owners' => 0, 'closed_won' => 0];

// Recent Activity (last 10 items)
$recentActivity = [];

// Recent reviews
$result = $conn->query("SELECT 'review' as type, id, name, created_at, status FROM reviews ORDER BY created_at DESC LIMIT 3");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $recentActivity[] = $row;
    }
}

// Recent messages
$result = $conn->query("SELECT 'message' as type, id, CONCAT(first_name, ' ', last_name) as name, created_at, status FROM contact_messages ORDER BY created_at DESC LIMIT 3");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $recentActivity[] = $row;
    }
}

// Recent merchant applications
$result = $conn->query("SELECT 'application' as type, id, company as name, created_at, status FROM merchant_applications ORDER BY created_at DESC LIMIT 2");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $recentActivity[] = $row;
    }
}

// Recent digital briefs
$result = $conn->query("SELECT 'brief' as type, id, name, created_at, status FROM digital_briefs ORDER BY created_at DESC LIMIT 2");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $recentActivity[] = $row;
    }
}

// Recent business referrals
$result = $conn->query("SELECT 'referral' as type, id, business_name as name, created_at, status FROM business_referrals ORDER BY created_at DESC LIMIT 2");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $recentActivity[] = $row;
    }
}

// Recent business owners
$result = $conn->query("SELECT 'owner' as type, id, owner_name as name, created_at, status FROM business_owners ORDER BY created_at DESC LIMIT 2");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $recentActivity[] = $row;
    }
}

// Sort by date
usort($recentActivity, function($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});
$recentActivity = array_slice($recentActivity, 0, 10);

include 'admin-layout.php';
?>

<!-- Dashboard Stats -->
<div class="stats-grid">
    <div class="stat-card stat-info">
        <div class="stat-label">Total Reviews</div>
        <div class="stat-value"><?php echo $stats['reviews']['total']; ?></div>
        <div class="stat-meta">
            <span style="color: #ffb900;"><?php echo $stats['reviews']['pending']; ?> pending</span>
        </div>
    </div>
    
    <div class="stat-card stat-success">
        <div class="stat-label">Contact Messages</div>
        <div class="stat-value"><?php echo $stats['messages']['total']; ?></div>
        <div class="stat-meta">
            <span style="color: #0073aa;"><?php echo $stats['messages']['new_messages']; ?> new</span>
        </div>
    </div>
    
    <div class="stat-card stat-warning">
        <div class="stat-label">Merchant Applications</div>
        <div class="stat-value"><?php echo $stats['applications']['total']; ?></div>
        <div class="stat-meta">
            <span style="color: #46b450;"><?php echo $stats['applications']['confirmed']; ?> confirmed</span>
        </div>
    </div>
    
    <div class="stat-card stat-info">
        <div class="stat-label">Digital Briefs</div>
        <div class="stat-value"><?php echo $stats['digital_briefs']['total']; ?></div>
        <div class="stat-meta">
            <span style="color: #ffb900;"><?php echo $stats['digital_briefs']['new_briefs']; ?> new</span>
        </div>
    </div>

    <div class="stat-card stat-success">
        <div class="stat-label">Business Referrals</div>
        <div class="stat-value"><?php echo $stats['referrals']['total']; ?></div>
        <div class="stat-meta">
            <span style="color: #46b450;"><?php echo $stats['referrals']['paid']; ?> paid</span>
        </div>
    </div>

    <div class="stat-card stat-warning">
        <div class="stat-label">Business Owners</div>
        <div class="stat-value"><?php echo $stats['business_owners']['total']; ?></div>
        <div class="stat-meta">
            <span style="color: #46b450;"><?php echo $stats['business_owners']['closed_won']; ?> won</span>
        </div>
    </div>
</div>

<!-- Dashboard Widgets -->
<div class="dashboard-widgets">
    
    <!-- Quick Actions -->
    <div class="widget">
        <div class="widget-header">
            <span>🚀</span>
            <span>Quick Actions</span>
        </div>
        <div class="widget-body">
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <a href="reviews.php?status=pending" class="btn btn-secondary" style="text-align: left;">
                    <strong>⭐ Review Pending Reviews</strong><br>
                    <small style="color: #72777c;"><?php echo $stats['reviews']['pending']; ?> waiting for approval</small>
                </a>
                <a href="messages.php?status=new" class="btn btn-secondary" style="text-align: left;">
                    <strong>📩 Check New Messages</strong><br>
                    <small style="color: #72777c;"><?php echo $stats['messages']['new_messages']; ?> unread messages</small>
                </a>
                <a href="merchant_applications.php?status=pending" class="btn btn-secondary" style="text-align: left;">
                    <strong>📋 Process Applications</strong><br>
                    <small style="color: #72777c;"><?php echo $stats['applications']['pending']; ?> pending applications</small>
                </a>
                <a href="digital_briefs.php?status=new" class="btn btn-secondary" style="text-align: left;">
                    <strong>✨ Review Digital Briefs</strong><br>
                    <small style="color: #72777c;"><?php echo $stats['digital_briefs']['new_briefs']; ?> new briefs</small>
                </a>
                <a href="business_referrals.php?status=new" class="btn btn-secondary" style="text-align: left;">
                    <strong>🤝 Check Referrals</strong><br>
                    <small style="color: #72777c;"><?php echo $stats['referrals']['new_referrals']; ?> new referrals</small>
                </a>
                <a href="business_owners.php?status=new" class="btn btn-secondary" style="text-align: left;">
                    <strong>💼 Review Owner Inquiries</strong><br>
                    <small style="color: #72777c;"><?php echo $stats['business_owners']['new_owners']; ?> new inquiries</small>
                </a>
            </div>
        </div>
    </div>
    
    <!-- At a Glance -->
    <div class="widget">
        <div class="widget-header">
            <span>📊</span>
            <span>At a Glance</span>
        </div>
        <div class="widget-body">
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="padding: 8px 0; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between;">
                    <span>Approved Reviews</span>
                    <strong style="color: #46b450;"><?php echo $stats['reviews']['approved']; ?></strong>
                </li>
                <li style="padding: 8px 0; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between;">
                    <span>Read Messages</span>
                    <strong style="color: #7b1fa2;"><?php echo $stats['messages']['read_messages']; ?></strong>
                </li>
                <li style="padding: 8px 0; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between;">
                    <span>Confirmed Applications</span>
                    <strong style="color: #46b450;"><?php echo $stats['applications']['confirmed']; ?></strong>
                </li>
                <li style="padding: 8px 0; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between;">
                    <span>Pending Applications</span>
                    <strong style="color: #ffb900;"><?php echo $stats['applications']['pending']; ?></strong>
                </li>
                <li style="padding: 8px 0; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between;">
                    <span>Briefs In Progress</span>
                    <strong style="color: #0073aa;"><?php echo $stats['digital_briefs']['in_progress']; ?></strong>
                </li>
                <li style="padding: 8px 0; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between;">
                    <span>Paid Referrals</span>
                    <strong style="color: #46b450;"><?php echo $stats['referrals']['paid']; ?></strong>
                </li>
                <li style="padding: 8px 0; display: flex; justify-content: space-between;">
                    <span>Deals Closed</span>
                    <strong style="color: #46b450;"><?php echo $stats['business_owners']['closed_won']; ?></strong>
                </li>
            </ul>
        </div>
    </div>
    
    <!-- Recent Activity -->
    <div class="widget" style="grid-column: span 2;">
        <div class="widget-header">
            <span>🕐</span>
            <span>Recent Activity</span>
        </div>
        <div class="widget-body">
            <?php if (empty($recentActivity)): ?>
                <p style="color: #72777c; margin: 0;">No recent activity</p>
            <?php else: ?>
                <div style="max-height: 400px; overflow-y: auto;">
                    <?php foreach ($recentActivity as $item): ?>
                        <div style="padding: 10px 0; border-bottom: 1px solid #f1f1f1; display: flex; align-items: center; gap: 10px;">
                            <span style="font-size: 1.25rem;">
                                <?php 
                                if ($item['type'] === 'review') echo '⭐';
                                elseif ($item['type'] === 'message') echo '📩';
                                elseif ($item['type'] === 'application') echo '📋';
                                elseif ($item['type'] === 'brief') echo '✨';
                                elseif ($item['type'] === 'referral') echo '🤝';
                                elseif ($item['type'] === 'owner') echo '💼';
                                ?>
                            </span>
                            <div style="flex: 1;">
                                <div style="font-weight: 600;">
                                    <?php echo htmlspecialchars($item['name']); ?>
                                </div>
                                <div style="font-size: 0.75rem; color: #72777c;">
                                    <?php 
                                    if ($item['type'] === 'review') echo 'Submitted a review';
                                    elseif ($item['type'] === 'message') echo 'Sent a contact message';
                                    elseif ($item['type'] === 'application') echo 'Submitted merchant application';
                                    elseif ($item['type'] === 'brief') echo 'Submitted digital brief';
                                    elseif ($item['type'] === 'referral') echo 'Submitted business referral';
                                    elseif ($item['type'] === 'owner') echo 'Submitted business inquiry';
                                    ?> • <?php echo date('M j, Y g:i A', strtotime($item['created_at'])); ?>
                                </div>
                            </div>
                            <span class="status-badge status-<?php echo $item['status']; ?>">
                                <?php echo ucfirst($item['status']); ?>
                            </span>
                            <a href="<?php 
                                if ($item['type'] === 'review') echo 'reviews.php';
                                elseif ($item['type'] === 'message') echo 'message_view.php?id=' . $item['id'];
                                elseif ($item['type'] === 'application') echo 'merchant_application_view.php?id=' . $item['id'];
                                elseif ($item['type'] === 'brief') echo 'digital_brief_view.php?id=' . $item['id'];
                                elseif ($item['type'] === 'referral') echo 'business_referral_view.php?id=' . $item['id'];
                                elseif ($item['type'] === 'owner') echo 'business_owner_view.php?id=' . $item['id'];
                            ?>" class="btn btn-sm btn-secondary">View</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
</div>

<?php include 'admin-layout-footer.php'; ?>
