<?php
session_start();
require_once __DIR__ . '/../../db.php';

// Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}

$ownerId = (int) ($_GET['id'] ?? 0);

if (!$ownerId) {
    header("Location: business_owners.php");
    exit;
}

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'update_status' && isset($_POST['status'])) {
        $status = $_POST['status'];
        $stmt = $conn->prepare("UPDATE business_owners SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $ownerId);
        $success = $stmt->execute();
        $stmt->close();
        
        if ($success) {
            header("Location: business_owner_view.php?id=" . $ownerId);
            exit;
        }
    }
}

// Fetch business owner data
$stmt = $conn->prepare("SELECT * FROM business_owners WHERE id = ?");
$stmt->bind_param("i", $ownerId);
$stmt->execute();
$result = $stmt->get_result();
$owner = $result->fetch_assoc();
$stmt->close();

if (!$owner) {
    header("Location: business_owners.php");
    exit;
}

$page_title = 'Business Owner #' . $owner['id'] . ' - ' . htmlspecialchars($owner['owner_name']);
$page_actions = '<a href="business_owners.php" class="btn btn-secondary">← Back to List</a>
<a href="mailto:' . htmlspecialchars($owner['email']) . '?subject=Business Owner Inquiry - ' . htmlspecialchars($owner['business_name']) . '" class="btn btn-primary">📧 Email Owner</a>';

include 'admin-layout.php';
?>

<div class="owner-view-container">
    <!-- Status Update Card -->
    <div class="admin-card status-card">
        <h2>Business Owner Status</h2>
        <form method="POST" class="status-form">
            <input type="hidden" name="action" value="update_status">
            <div class="form-group">
                <label for="status">Current Status:</label>
                <select name="status" id="status" class="status-select status-<?php echo $owner['status']; ?>">
                    <option value="new" <?php echo $owner['status'] === 'new' ? 'selected' : ''; ?>>New</option>
                    <option value="contacted" <?php echo $owner['status'] === 'contacted' ? 'selected' : ''; ?>>Contacted</option>
                    <option value="meeting_scheduled" <?php echo $owner['status'] === 'meeting_scheduled' ? 'selected' : ''; ?>>Meeting Scheduled</option>
                    <option value="proposal_sent" <?php echo $owner['status'] === 'proposal_sent' ? 'selected' : ''; ?>>Proposal Sent</option>
                    <option value="closed_won" <?php echo $owner['status'] === 'closed_won' ? 'selected' : ''; ?>>Closed Won</option>
                    <option value="closed_lost" <?php echo $owner['status'] === 'closed_lost' ? 'selected' : ''; ?>>Closed Lost</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Status</button>
        </form>
        <div class="status-info">
            <p><strong>Submitted:</strong> <?php echo date('F j, Y \a\t g:i A', strtotime($owner['created_at'])); ?></p>
        </div>
    </div>

    <!-- Owner Information -->
    <div class="admin-card">
        <h2>👤 Owner Information</h2>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Owner Name</span>
                <span class="info-value" style="font-size: 1.125rem; font-weight: 600;"><?php echo htmlspecialchars($owner['owner_name']); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Email Address</span>
                <span class="info-value">
                    <a href="mailto:<?php echo htmlspecialchars($owner['email']); ?>">
                        <?php echo htmlspecialchars($owner['email']); ?>
                    </a>
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Phone Number</span>
                <span class="info-value">
                    <?php if ($owner['phone']): ?>
                        <a href="tel:<?php echo htmlspecialchars($owner['phone']); ?>">
                            <?php echo htmlspecialchars($owner['phone']); ?>
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
        <h2>🏢 Business Information</h2>
        <div class="info-item">
            <span class="info-label">Business Name</span>
            <span class="info-value" style="font-size: 1.125rem; font-weight: 600; color: #007bff;">
                <?php echo htmlspecialchars($owner['business_name']); ?>
            </span>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="admin-card actions-card">
        <h2>Quick Actions</h2>
        <div class="quick-actions">
            <a href="mailto:<?php echo htmlspecialchars($owner['email']); ?>?subject=Business Owner Inquiry - <?php echo htmlspecialchars($owner['business_name']); ?>" class="btn btn-primary">
                📧 Send Email
            </a>
            <?php if ($owner['phone']): ?>
            <a href="tel:<?php echo htmlspecialchars($owner['phone']); ?>" class="btn btn-secondary">
                📞 Call Owner
            </a>
            <?php endif; ?>
            <form method="POST" action="business_owners.php" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this business owner record?');">
                <input type="hidden" name="owner_id" value="<?php echo $owner['id']; ?>">
                <input type="hidden" name="action" value="delete">
                <button type="submit" class="btn btn-danger">🗑️ Delete Record</button>
            </form>
        </div>
    </div>
</div>

<style>
.owner-view-container {
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
    margin-bottom: 16px;
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
