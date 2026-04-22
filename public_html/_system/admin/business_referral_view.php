<?php
session_start();
require_once __DIR__ . '/../../db.php';

// Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}

$referralId = (int) ($_GET['id'] ?? 0);

if (!$referralId) {
    header("Location: business_referrals.php");
    exit;
}

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'update_status' && isset($_POST['status'])) {
        $status = $_POST['status'];
        $stmt = $conn->prepare("UPDATE business_referrals SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $referralId);
        $success = $stmt->execute();
        $stmt->close();
        
        if ($success) {
            header("Location: business_referral_view.php?id=" . $referralId);
            exit;
        }
    }
}

// Fetch referral data
$stmt = $conn->prepare("SELECT * FROM business_referrals WHERE id = ?");
$stmt->bind_param("i", $referralId);
$stmt->execute();
$result = $stmt->get_result();
$referral = $result->fetch_assoc();
$stmt->close();

if (!$referral) {
    header("Location: business_referrals.php");
    exit;
}

$page_title = 'Business Referral #' . $referral['id'] . ' - ' . htmlspecialchars($referral['business_name']);
$page_actions = '<a href="business_referrals.php" class="btn btn-secondary">← Back to List</a>
<a href="mailto:' . htmlspecialchars($referral['owner_email']) . '?subject=Business Referral - ' . htmlspecialchars($referral['business_name']) . '" class="btn btn-primary">📧 Email Business Owner</a>';

include 'admin-layout.php';
?>

<div class="referral-view-container">
    <!-- Status Update Card -->
    <div class="admin-card status-card">
        <h2>Referral Status</h2>
        <form method="POST" class="status-form">
            <input type="hidden" name="action" value="update_status">
            <div class="form-group">
                <label for="status">Current Status:</label>
                <select name="status" id="status" class="status-select status-<?php echo $referral['status']; ?>">
                    <option value="new" <?php echo $referral['status'] === 'new' ? 'selected' : ''; ?>>New</option>
                    <option value="contacted" <?php echo $referral['status'] === 'contacted' ? 'selected' : ''; ?>>Contacted</option>
                    <option value="qualified" <?php echo $referral['status'] === 'qualified' ? 'selected' : ''; ?>>Qualified</option>
                    <option value="disqualified" <?php echo $referral['status'] === 'disqualified' ? 'selected' : ''; ?>>Disqualified</option>
                    <option value="paid" <?php echo $referral['status'] === 'paid' ? 'selected' : ''; ?>>Paid $500</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Status</button>
        </form>
        <div class="status-info">
            <p><strong>Submitted:</strong> <?php echo date('F j, Y \a\t g:i A', strtotime($referral['created_at'])); ?></p>
        </div>
    </div>

    <!-- Referrer Information -->
    <div class="admin-card">
        <h2>👤 Referrer Information</h2>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Referrer Name</span>
                <span class="info-value"><?php echo htmlspecialchars($referral['referrer_name']); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Referrer Email</span>
                <span class="info-value">
                    <a href="mailto:<?php echo htmlspecialchars($referral['referrer_email']); ?>">
                        <?php echo htmlspecialchars($referral['referrer_email']); ?>
                    </a>
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Referrer Phone</span>
                <span class="info-value">
                    <?php if ($referral['referrer_phone']): ?>
                        <a href="tel:<?php echo htmlspecialchars($referral['referrer_phone']); ?>">
                            <?php echo htmlspecialchars($referral['referrer_phone']); ?>
                        </a>
                    <?php else: ?>
                        Not provided
                    <?php endif; ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Business Information -->
    <div class="admin-card">
        <h2>🏢 Referred Business Information</h2>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Business Name</span>
                <span class="info-value" style="font-size: 1.125rem; font-weight: 600;"><?php echo htmlspecialchars($referral['business_name']); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Business Owner Name</span>
                <span class="info-value"><?php echo htmlspecialchars($referral['owner_name']); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Owner Email</span>
                <span class="info-value">
                    <a href="mailto:<?php echo htmlspecialchars($referral['owner_email']); ?>">
                        <?php echo htmlspecialchars($referral['owner_email']); ?>
                    </a>
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Owner Phone</span>
                <span class="info-value">
                    <?php if ($referral['owner_phone']): ?>
                        <a href="tel:<?php echo htmlspecialchars($referral['owner_phone']); ?>">
                            <?php echo htmlspecialchars($referral['owner_phone']); ?>
                        </a>
                    <?php else: ?>
                        Not provided
                    <?php endif; ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="admin-card actions-card">
        <h2>Quick Actions</h2>
        <div class="quick-actions">
            <a href="mailto:<?php echo htmlspecialchars($referral['owner_email']); ?>?subject=Business Referral - <?php echo htmlspecialchars($referral['business_name']); ?>" class="btn btn-primary">
                📧 Email Business Owner
            </a>
            <?php if ($referral['owner_phone']): ?>
            <a href="tel:<?php echo htmlspecialchars($referral['owner_phone']); ?>" class="btn btn-secondary">
                📞 Call Business Owner
            </a>
            <?php endif; ?>
            <a href="mailto:<?php echo htmlspecialchars($referral['referrer_email']); ?>?subject=Thank you for your referral" class="btn btn-secondary">
                📧 Email Referrer
            </a>
            <?php if ($referral['referrer_phone']): ?>
            <a href="tel:<?php echo htmlspecialchars($referral['referrer_phone']); ?>" class="btn btn-secondary">
                📞 Call Referrer
            </a>
            <?php endif; ?>
            <form method="POST" action="business_referrals.php" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this referral?');">
                <input type="hidden" name="referral_id" value="<?php echo $referral['id']; ?>">
                <input type="hidden" name="action" value="delete">
                <button type="submit" class="btn btn-danger">🗑️ Delete Referral</button>
            </form>
        </div>
    </div>
</div>

<style>
.referral-view-container {
    max-width: 1200px;
}

.admin-card {
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.admin-card h2 {
    margin-top: 0;
    margin-bottom: 20px;
    font-size: 1.25rem;
    color: #333;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 10px;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 16px;
    margin-bottom: 16px;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.info-label {
    font-weight: 600;
    color: #666;
    font-size: 0.8125rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    font-size: 0.9375rem;
    color: #333;
}

.info-value a {
    color: #0066cc;
    text-decoration: none;
}

.info-value a:hover {
    text-decoration: underline;
}

.status-form {
    margin-bottom: 16px;
}

.status-form .form-group {
    margin-bottom: 12px;
}

.status-form label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    color: #555;
}

.status-select {
    width: 100%;
    max-width: 300px;
    padding: 8px 12px;
    border: 2px solid #ddd;
    border-radius: 6px;
    font-size: 0.9375rem;
}

.status-select.status-new { border-color: #ffc107; }
.status-select.status-contacted { border-color: #17a2b8; }
.status-select.status-in_progress { border-color: #fd7e14; }
.status-select.status-completed { border-color: #28a745; }
.status-select.status-closed { border-color: #6c757d; }

.status-info {
    padding-top: 16px;
    border-top: 1px solid #eee;
}

.status-info p {
    margin-bottom: 8px;
}

.quick-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}
</style>

<?php include 'admin-layout-footer.php'; ?>
