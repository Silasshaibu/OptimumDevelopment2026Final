<?php
session_start();
require_once __DIR__ . '/../../db.php';

// Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}

$page_title = 'Reviews';

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $reviewId = (int) $_POST['review_id'];

    if ($action === 'approve') {
        $stmt = $conn->prepare("UPDATE reviews SET status = 'approved' WHERE id = ?");
        $stmt->bind_param("i", $reviewId);
        $stmt->execute();
    } elseif ($action === 'reject') {
        $stmt = $conn->prepare("UPDATE reviews SET status = 'rejected' WHERE id = ?");
        $stmt->bind_param("i", $reviewId);
        $stmt->execute();
    } elseif ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM reviews WHERE id = ?");
        $stmt->bind_param("i", $reviewId);
        $stmt->execute();
    }
    
    header("Location: reviews.php");
    exit;
}

// Get filter
$statusFilter = $_GET['status'] ?? 'all';

// Build query
$whereCondition = $statusFilter !== 'all' ? "WHERE status = ?" : "";
$sql = "SELECT * FROM reviews $whereCondition ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
if ($statusFilter !== 'all') {
    $stmt->bind_param("s", $statusFilter);
}
$stmt->execute();
$result = $stmt->get_result();
$reviews = $result->fetch_all(MYSQLI_ASSOC);

// Get statistics
$statsQuery = $conn->query("SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved,
    SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected
    FROM reviews");
$stats = $statsQuery->fetch_assoc();

include 'admin-layout.php';
?>

<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-card stat-info">
        <div class="stat-label">Total Reviews</div>
        <div class="stat-value"><?php echo $stats['total']; ?></div>
    </div>
    <div class="stat-card stat-warning">
        <div class="stat-label">Pending</div>
        <div class="stat-value"><?php echo $stats['pending']; ?></div>
    </div>
    <div class="stat-card stat-success">
        <div class="stat-label">Approved</div>
        <div class="stat-value"><?php echo $stats['approved']; ?></div>
    </div>
    <div class="stat-card stat-danger">
        <div class="stat-label">Rejected</div>
        <div class="stat-value"><?php echo $stats['rejected']; ?></div>
    </div>
</div>

<!-- Filters -->
<div class="admin-panel">
    <div class="panel-body">
        <form method="get" class="filters-row">
            <select name="status" id="statusFilter" onchange="this.form.submit()">
                <option value="all" <?php echo $statusFilter === 'all' ? 'selected' : ''; ?>>All Statuses</option>
                <option value="pending" <?php echo $statusFilter === 'pending' ? 'selected' : ''; ?>>Pending</option>
                <option value="approved" <?php echo $statusFilter === 'approved' ? 'selected' : ''; ?>>Approved</option>
                <option value="rejected" <?php echo $statusFilter === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
            </select>
        </form>
    </div>
</div>

<!-- Reviews Table -->
<div class="admin-panel">
    <div class="panel-body">
        <?php if (empty($reviews)): ?>
            <p style="color: #72777c; text-align: center; padding: 40px 0;">No reviews found.</p>
        <?php else: ?>
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Rating</th>
                            <th>Name/Email</th>
                            <th>Review</th>
                            <th>Status</th>
                            <th>Source</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reviews as $review): ?>
                            <tr>
                                <td>
                                    <strong style="font-size: 1rem; color: #ffb900;">
                                        <?php echo $review['rating']; ?>/5 ⭐
                                    </strong>
                                </td>
                                <td><?php echo htmlspecialchars($review['name'] ?? $review['guest_email'] ?? 'User ' . $review['user_id']); ?></td>
                                <td style="max-width: 400px;">
                                    <?php echo htmlspecialchars(substr($review['review'], 0, 100)); ?>
                                    <?php if (strlen($review['review']) > 100) echo '...'; ?>
                                </td>
                                <td>
                                    <span class="status-badge status-<?php echo $review['status'] ?? 'pending'; ?>">
                                        <?php echo ucfirst($review['status'] ?? 'pending'); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($review['source'] ?? 'direct'); ?></td>
                                <td><?php echo date('M j, Y', strtotime($review['created_at'])); ?></td>
                                <td>
                                    <?php if (($review['source'] ?? 'direct') === 'direct'): ?>
                                        <form method="post" style="display: inline-flex; gap: 5px;">
                                            <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                                            <?php if ($review['status'] !== 'approved'): ?>
                                                <button type="submit" name="action" value="approve" class="btn btn-sm btn-primary">Approve</button>
                                            <?php endif; ?>
                                            <?php if ($review['status'] !== 'rejected'): ?>
                                                <button type="submit" name="action" value="reject" class="btn btn-sm btn-secondary">Reject</button>
                                            <?php endif; ?>
                                            <button type="submit" name="action" value="delete" class="btn btn-sm btn-danger" data-confirm-delete="Are you sure you want to delete this review?">Delete</button>
                                        </form>
                                    <?php else: ?>
                                        <span style="color: #999; font-size: 0.6875rem;">Imported</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'admin-layout-footer.php'; ?>