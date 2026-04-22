<?php
session_start();
require_once __DIR__ . '/../../db.php';

// Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}

$briefId = (int) ($_GET['id'] ?? 0);

if (!$briefId) {
    header("Location: digital_briefs.php");
    exit;
}

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'update_status' && isset($_POST['status'])) {
        $status = $_POST['status'];
        $stmt = $conn->prepare("UPDATE digital_briefs SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $briefId);
        $stmt->execute();
        $stmt->close();
        header("Location: digital_brief_view.php?id=" . $briefId);
        exit;
    }
}

// Fetch brief data
$stmt = $conn->prepare("SELECT * FROM digital_briefs WHERE id = ?");
$stmt->bind_param("i", $briefId);
$stmt->execute();
$result = $stmt->get_result();
$brief = $result->fetch_assoc();
$stmt->close();

if (!$brief) {
    header("Location: digital_briefs.php");
    exit;
}

$services = json_decode($brief['services'], true);

$page_title = 'Digital Services Brief #' . $brief['id'];
$page_actions = '<a href="digital_briefs.php" class="btn btn-secondary">← Back to List</a>
<a href="export_single_digital_brief_excel.php?id=' . $briefId . '" class="btn btn-primary">📊 Export Excel</a>
<a href="export_single_digital_brief_pdf.php?id=' . $briefId . '" class="btn btn-secondary">📄 Export PDF</a>';

include 'admin-layout.php';

// Service names mapping
$serviceNames = [
    'website_design_development' => 'Website Design + Development',
    'app_design_development' => 'App Design + Development',
    'copywriting' => 'Copywriting',
    'packaging_design' => 'Packaging Design',
    'branding' => 'Branding'
];
?>

<div class="brief-view-container">
    <!-- Status Update Card -->
    <div class="admin-card status-card">
        <h2>Brief Status</h2>
        <form method="POST" class="status-form">
            <input type="hidden" name="action" value="update_status">
            <div class="form-group">
                <label for="status">Current Status:</label>
                <select name="status" id="status" class="status-select status-<?php echo $brief['status']; ?>">
                    <option value="new" <?php echo $brief['status'] === 'new' ? 'selected' : ''; ?>>New</option>
                    <option value="contacted" <?php echo $brief['status'] === 'contacted' ? 'selected' : ''; ?>>Contacted</option>
                    <option value="in_progress" <?php echo $brief['status'] === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                    <option value="completed" <?php echo $brief['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                    <option value="cancelled" <?php echo $brief['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Status</button>
        </form>
        <div class="status-info">
            <p><strong>Submitted:</strong> <?php echo date('F j, Y \a\t g:i A', strtotime($brief['created_at'])); ?></p>
        </div>
    </div>

    <!-- Client Information -->
    <div class="admin-card">
        <h2>Client Information</h2>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Name:</span>
                <span class="info-value"><?php echo htmlspecialchars($brief['name']); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Email:</span>
                <span class="info-value"><a href="mailto:<?php echo htmlspecialchars($brief['email']); ?>"><?php echo htmlspecialchars($brief['email']); ?></a></span>
            </div>
            <div class="info-item">
                <span class="info-label">Phone:</span>
                <span class="info-value">
                    <?php if ($brief['phone']): ?>
                        <a href="tel:<?php echo htmlspecialchars($brief['phone']); ?>"><?php echo htmlspecialchars($brief['phone']); ?></a>
                    <?php else: ?>
                        Not provided
                    <?php endif; ?>
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Website:</span>
                <span class="info-value">
                    <?php if ($brief['website']): ?>
                        <a href="<?php echo htmlspecialchars($brief['website']); ?>" target="_blank" rel="noopener"><?php echo htmlspecialchars($brief['website']); ?> ↗</a>
                    <?php else: ?>
                        Not provided
                    <?php endif; ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Project Details -->
    <div class="admin-card">
        <h2>Project Details</h2>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Budget Range:</span>
                <span class="info-value budget-range">
                    $<?php echo number_format($brief['budget_min']); ?> - $<?php echo number_format($brief['budget_max']); ?>
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">How They Heard About Us:</span>
                <span class="info-value"><?php echo htmlspecialchars(ucfirst($brief['referral_source'])); ?></span>
            </div>
        </div>

        <div class="info-section">
            <h3>Services Requested</h3>
            <div class="services-list">
                <?php if (is_array($services) && count($services) > 0): ?>
                    <?php foreach ($services as $service): ?>
                        <span class="service-badge"><?php echo htmlspecialchars($serviceNames[$service] ?? $service); ?></span>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No services selected</p>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($brief['comments'])): ?>
        <div class="info-section">
            <h3>Additional Comments</h3>
            <div class="comments-box">
                <?php echo nl2br(htmlspecialchars($brief['comments'])); ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Quick Actions -->
    <div class="admin-card actions-card">
        <h2>Quick Actions</h2>
        <div class="quick-actions">
            <a href="mailto:<?php echo htmlspecialchars($brief['email']); ?>?subject=Re: Your Digital Services Inquiry" class="btn btn-primary">
                📧 Send Email
            </a>
            <?php if ($brief['phone']): ?>
            <a href="tel:<?php echo htmlspecialchars($brief['phone']); ?>" class="btn btn-secondary">
                📞 Call Client
            </a>
            <?php endif; ?>
            <form method="POST" action="digital_briefs.php" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this brief?');">
                <input type="hidden" name="brief_id" value="<?php echo $brief['id']; ?>">
                <input type="hidden" name="action" value="delete">
                <button type="submit" class="btn btn-danger">🗑️ Delete Brief</button>
            </form>
        </div>
    </div>
</div>

<style>
.brief-view-container {
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

.admin-card h3 {
    margin-top: 20px;
    margin-bottom: 12px;
    font-size: 1rem;
    color: #555;
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

.budget-range {
    font-size: 1.125rem;
    font-weight: 600;
    color: #28a745;
}

.services-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 12px;
}

.service-badge {
    display: inline-block;
    padding: 8px 16px;
    background: #007bff;
    color: white;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
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

.status-info {
    padding-top: 16px;
    border-top: 1px solid #eee;
}

.quick-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.info-section {
    margin-top: 24px;
}
</style>

<?php include 'admin-layout-footer.php'; ?>
