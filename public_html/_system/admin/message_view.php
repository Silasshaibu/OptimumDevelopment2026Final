<?php
session_start();
require_once __DIR__ . '/../../db.php';

// Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}

$messageId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($messageId === 0) {
    header("Location: messages.php");
    exit;
}

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'update_status' && isset($_POST['status'])) {
        $status = $_POST['status'];
        $stmt = $conn->prepare("UPDATE contact_messages SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $messageId);
        $stmt->execute();
        $stmt->close();
        header("Location: message_view.php?id=" . $messageId);
        exit;
    }
}

// Get message details
$stmt = $conn->prepare("SELECT * FROM contact_messages WHERE id = ?");
$stmt->bind_param("i", $messageId);
$stmt->execute();
$result = $stmt->get_result();
$msg = $result->fetch_assoc();
$stmt->close();

if (!$msg) {
    header("Location: messages.php");
    exit;
}

// Mark as read if it's new
if ($msg['status'] === 'new') {
    $updateStmt = $conn->prepare("UPDATE contact_messages SET status = 'read' WHERE id = ?");
    $updateStmt->bind_param("i", $messageId);
    $updateStmt->execute();
    $updateStmt->close();
    $msg['status'] = 'read';
}

$page_title = 'Contact Message #' . $msg['id'] . ' - ' . htmlspecialchars($msg['first_name'] . ' ' . $msg['last_name']);
$page_actions = '<a href="messages.php" class="btn btn-secondary">← Back to Messages</a>
<a href="mailto:' . htmlspecialchars($msg['email']) . '?subject=Re: Your Message to Optimum Payments" class="btn btn-primary">📧 Email ' . htmlspecialchars($msg['first_name']) . '</a>';

include 'admin-layout.php';
?>
<div class="message-view-container">
    <!-- Status Update Card -->
    <div class="admin-card status-card">
        <h2>Message Status</h2>
        <form method="POST" class="status-form">
            <input type="hidden" name="action" value="update_status">
            <div class="form-group">
                <label for="status">Current Status:</label>
                <select name="status" id="status" class="status-select status-<?php echo $msg['status']; ?>">
                    <option value="new" <?php echo $msg['status'] === 'new' ? 'selected' : ''; ?>>New</option>
                    <option value="read" <?php echo $msg['status'] === 'read' ? 'selected' : ''; ?>>Read</option>
                    <option value="replied" <?php echo $msg['status'] === 'replied' ? 'selected' : ''; ?>>Replied</option>
                    <option value="closed" <?php echo $msg['status'] === 'closed' ? 'selected' : ''; ?>>Closed</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Status</button>
        </form>
        <div class="status-info">
            <p><strong>Received:</strong> <?php echo date('F j, Y \a\t g:i A', strtotime($msg['created_at'])); ?></p>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="admin-card">
        <h2>Contact Information</h2>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Full Name</span>
                <span class="info-value"><?php echo htmlspecialchars($msg['first_name'] . ' ' . $msg['last_name']); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Email Address</span>
                <span class="info-value">
                    <a href="mailto:<?php echo htmlspecialchars($msg['email']); ?>">
                        <?php echo htmlspecialchars($msg['email']); ?>
                    </a>
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Phone Number</span>
                <span class="info-value">
                    <?php if ($msg['phone']): ?>
                        <a href="tel:<?php echo htmlspecialchars($msg['phone']); ?>">
                            <?php echo htmlspecialchars($msg['phone']); ?>
                        </a>
                    <?php else: ?>
                        Not provided
                    <?php endif; ?>
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Company</span>
                <span class="info-value">
                    <?php echo $msg['company'] ? htmlspecialchars($msg['company']) : 'Not provided'; ?>
                </span>
            </div>
        </div>
    </div>
    
    <!-- Additional Details -->
    <div class="admin-card">
        <h2>Additional Details</h2>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">How They Heard About Us</span>
                <span class="info-value"><?php echo htmlspecialchars(ucfirst($msg['source'])); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">IP Address</span>
                <span class="info-value"><?php echo htmlspecialchars($msg['ip_address']); ?></span>
            </div>
        </div>
    </div>
    
    <!-- Message -->
    <div class="admin-card">
        <h2>Message</h2>
        <div class="message-content">
            <?php echo nl2br(htmlspecialchars($msg['message'])); ?>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="admin-card actions-card">
        <h2>Quick Actions</h2>
        <div class="quick-actions">
            <a href="mailto:<?php echo htmlspecialchars($msg['email']); ?>?subject=Re: Your Message to Optimum Payments" class="btn btn-primary">
                📧 Send Email
            </a>
            <?php if ($msg['phone']): ?>
            <a href="tel:<?php echo htmlspecialchars($msg['phone']); ?>" class="btn btn-secondary">
                📞 Call <?php echo htmlspecialchars($msg['first_name']); ?>
            </a>
            <?php endif; ?>
            <form method="POST" action="messages.php" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this message?');">
                <input type="hidden" name="message_id" value="<?php echo $msg['id']; ?>">
                <input type="hidden" name="action" value="delete">
                <button type="submit" class="btn btn-danger">🗑️ Delete Message</button>
            </form>
        </div>
    </div>
</div>

<style>
.message-view-container {
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

.message-content {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    border-left: 4px solid #007bff;
    line-height: 1.6;
    white-space: pre-wrap;
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
.status-select.status-read { border-color: #17a2b8; }
.status-select.status-replied { border-color: #28a745; }
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
