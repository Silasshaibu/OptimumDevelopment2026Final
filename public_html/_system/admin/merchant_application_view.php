<?php
session_start();
require_once __DIR__ . '/../../db.php';

// Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}

$appId = (int) ($_GET['id'] ?? 0);

if ($appId === 0) {
    header("Location: merchant_applications.php");
    exit;
}

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'update_status' && isset($_POST['status'])) {
        $status = $_POST['status'];
        $stmt = $conn->prepare("UPDATE merchant_applications SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $appId);
        $stmt->execute();
        $stmt->close();
        header("Location: merchant_application_view.php?id=" . $appId);
        exit;
    }
}

// Fetch application
$stmt = $conn->prepare("SELECT * FROM merchant_applications WHERE id = ?");
$stmt->bind_param("i", $appId);
$stmt->execute();
$result = $stmt->get_result();
$app = $result->fetch_assoc();
$stmt->close();

if (!$app) {
    header("Location: merchant_applications.php");
    exit;
}

$page_title = 'Merchant Application #' . $app['id'] . ' - ' . htmlspecialchars($app['company']);
$page_actions = '<a href="merchant_applications.php" class="btn btn-secondary">← Back to List</a>
<a href="mailto:' . htmlspecialchars($app['email']) . '?subject=Regarding Your Merchant Application" class="btn btn-primary">✉ Email Applicant</a>';

include 'admin-layout.php';
?>
<div class="merchant-view-container">
    <!-- Status Update Card -->
    <div class="admin-card status-card">
        <h2>Application Status</h2>
        <form method="POST" class="status-form">
            <input type="hidden" name="action" value="update_status">
            <div class="form-group">
                <label for="status">Current Status:</label>
                <select name="status" id="status" class="status-select status-<?php echo $app['status']; ?>">
                    <option value="pending" <?php echo $app['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="processing" <?php echo $app['status'] === 'processing' ? 'selected' : ''; ?>>Processing</option>
                    <option value="approved" <?php echo $app['status'] === 'approved' ? 'selected' : ''; ?>>Approved</option>
                    <option value="rejected" <?php echo $app['status'] === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Status</button>
        </form>
        <div class="status-info">
            <p><strong>Submitted:</strong> <?php echo date('F j, Y \a\t g:i A', strtotime($app['created_at'])); ?></p>
            <p><strong>Email Confirmed:</strong> 
                <span class="confirmed-badge confirmed-<?php echo $app['confirmed'] ? 'yes' : 'no'; ?>">
                    <?php echo $app['confirmed'] ? 'Yes' : 'No'; ?>
                </span>
            </p>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="admin-card">
        <h2>📞 Contact Information</h2>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Full Name</span>
                <span class="info-value"><?php echo htmlspecialchars($app['first_name'] . ' ' . $app['surname']); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Title</span>
                <span class="info-value"><?php echo htmlspecialchars($app['title'] ?: 'N/A'); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Email</span>
                <span class="info-value">
                    <a href="mailto:<?php echo htmlspecialchars($app['email']); ?>">
                        <?php echo htmlspecialchars($app['email']); ?>
                    </a>
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Phone</span>
                <span class="info-value">
                    <a href="tel:<?php echo htmlspecialchars($app['phone']); ?>">
                        <?php echo htmlspecialchars($app['phone']); ?>
                    </a>
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Fax</span>
                <span class="info-value"><?php echo htmlspecialchars($app['fax'] ?: 'N/A'); ?></span>
            </div>
        </div>
    </div>

    <!-- Company Information -->
    <div class="admin-card">
        <h2>🏢 Company Information</h2>
        <div class="info-item">
            <span class="info-label">Company Name</span>
            <span class="info-value" style="font-size: 1.125rem; font-weight: 600;"><?php echo htmlspecialchars($app['company']); ?></span>
        </div>
    </div>
    
    <!-- Address -->
    <div class="admin-card">
        <h2>📍 Address</h2>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Address Line 1</span>
                <span class="info-value"><?php echo htmlspecialchars($app['address1'] ?: 'N/A'); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Address Line 2</span>
                <span class="info-value"><?php echo htmlspecialchars($app['address2'] ?: 'N/A'); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">City</span>
                <span class="info-value"><?php echo htmlspecialchars($app['city'] ?: 'N/A'); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">State</span>
                <span class="info-value"><?php echo htmlspecialchars($app['state'] ?: 'N/A'); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Zip Code</span>
                <span class="info-value"><?php echo htmlspecialchars($app['zip'] ?: 'N/A'); ?></span>
            </div>
        </div>
    </div>
    
    <!-- Business Information -->
    <div class="admin-card">
        <h2>💼 Business Information</h2>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Business Type</span>
                <span class="info-value"><?php echo htmlspecialchars($app['business_type'] ?: 'Not specified'); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Currently Accepts Credit Cards</span>
                <span class="info-value"><?php echo strtoupper($app['accept_credit_cards']); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Previously Taken Credit Cards</span>
                <span class="info-value"><?php echo strtoupper($app['previous_credit_cards']); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Estimated Monthly Volume</span>
                <span class="info-value" style="font-weight: 600; color: #28a745; font-size: 1.125rem;">
                    <?php echo htmlspecialchars($app['monthly_volume']); ?>
                </span>
            </div>
        </div>
    </div>
    
    <!-- Additional Comments -->
    <?php if (!empty($app['comments'])): ?>
    <div class="admin-card">
        <h2>💬 Additional Comments</h2>
        <div class="comments-box">
            <?php echo nl2br(htmlspecialchars($app['comments'])); ?>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Quick Actions -->
    <div class="admin-card actions-card">
        <h2>Quick Actions</h2>
        <div class="quick-actions">
            <a href="mailto:<?php echo htmlspecialchars($app['email']); ?>?subject=Regarding Your Merchant Application" class="btn btn-primary">
                📧 Send Email
            </a>
            <a href="tel:<?php echo htmlspecialchars($app['phone']); ?>" class="btn btn-secondary">
                📞 Call Applicant
            </a>
            <form method="POST" action="merchant_applications.php" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this application?');">
                <input type="hidden" name="app_id" value="<?php echo $app['id']; ?>">
                <input type="hidden" name="action" value="delete">
                <button type="submit" class="btn btn-danger">🗑️ Delete Application</button>
            </form>
        </div>
    </div>
</div>

<style>
.merchant-view-container {
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

.comments-box {
    background: #f8f9fa;
    padding: 16px;
    border-radius: 6px;
    border-left: 4px solid #007bff;
    line-height: 1.6;
    margin-top: 12px;
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
.status-select.status-approved { border-color: #28a745; }
.status-select.status-rejected { border-color: #dc3545; }
.status-select.status-closed { border-color: #6c757d; }

.status-info {
    padding-top: 16px;
    border-top: 1px solid #eee;
}

.status-info p {
    margin-bottom: 8px;
}

.confirmed-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
}

.confirmed-yes { background: #d4edda; color: #155724; }
.confirmed-no { background: #f8d7da; color: #721c24; }

.quick-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}
</style>

<?php include 'admin-layout-footer.php'; ?>
