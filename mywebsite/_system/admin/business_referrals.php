<?php
session_start();
require_once __DIR__ . '/../../db.php';

// Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}

$page_title = 'Business Referrals';
$page_actions = '<a href="export_business_referrals_excel.php' . ($_GET ? '?' . http_build_query($_GET) : '') . '" class="btn btn-primary">📊 Export Excel</a>
<a href="export_business_referrals_pdf.php' . ($_GET ? '?' . http_build_query($_GET) : '') . '" class="btn btn-secondary">📄 Export PDF</a>';

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $referralId = (int) ($_POST['referral_id'] ?? 0);

    if ($action === 'update_status' && isset($_POST['status'])) {
        $status = $_POST['status'];
        $stmt = $conn->prepare("UPDATE business_referrals SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $referralId);
        $stmt->execute();
        $stmt->close();
    } elseif ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM business_referrals WHERE id = ?");
        $stmt->bind_param("i", $referralId);
        $stmt->execute();
        $stmt->close();
    }
    
    header("Location: business_referrals.php" . ($_GET ? '?' . http_build_query($_GET) : ''));
    exit;
}

// Filters
$statusFilter = $_GET['status'] ?? 'all';
$searchQuery = $_GET['search'] ?? '';

// Build query
$whereConditions = [];
$params = [];
$types = '';

if ($statusFilter !== 'all') {
    $whereConditions[] = "status = ?";
    $params[] = $statusFilter;
    $types .= 's';
}

if (!empty($searchQuery)) {
    $whereConditions[] = "(referrer_name LIKE ? OR referrer_email LIKE ? OR business_name LIKE ? OR owner_name LIKE ?)";
    $searchParam = '%' . $searchQuery . '%';
    $params[] = $searchParam;
    $params[] = $searchParam;
    $params[] = $searchParam;
    $params[] = $searchParam;
    $types .= 'ssss';
}

$whereClause = !empty($whereConditions) ? 'WHERE ' . implode(' AND ', $whereConditions) : '';

// Get statistics
$statsQuery = "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN status = 'new' THEN 1 ELSE 0 END) as new,
    SUM(CASE WHEN status = 'contacted' THEN 1 ELSE 0 END) as contacted,
    SUM(CASE WHEN status = 'qualified' THEN 1 ELSE 0 END) as qualified,
    SUM(CASE WHEN status = 'disqualified' THEN 1 ELSE 0 END) as disqualified,
    SUM(CASE WHEN status = 'paid' THEN 1 ELSE 0 END) as paid
FROM business_referrals";
$statsResult = $conn->query($statsQuery);
$stats = $statsResult->fetch_assoc();

$sql = "SELECT * FROM business_referrals $whereClause ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$referrals = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

include 'admin-layout.php';
?>

<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-card stat-info">
        <div class="stat-label">Total Referrals</div>
        <div class="stat-value"><?php echo $stats['total']; ?></div>
    </div>
    
    <div class="stat-card stat-warning">
        <div class="stat-label">New</div>
        <div class="stat-value"><?php echo $stats['new']; ?></div>
    </div>
    
    <div class="stat-card stat-primary">
        <div class="stat-label">Contacted</div>
        <div class="stat-value"><?php echo $stats['contacted']; ?></div>
    </div>
    
    <div class="stat-card stat-info">
        <div class="stat-label">Qualified</div>
        <div class="stat-value"><?php echo $stats['qualified']; ?></div>
    </div>
    
    <div class="stat-card stat-danger">
        <div class="stat-label">Disqualified</div>
        <div class="stat-value"><?php echo $stats['disqualified']; ?></div>
    </div>

    <div class="stat-card stat-success">
        <div class="stat-label">Paid ($500)</div>
        <div class="stat-value"><?php echo $stats['paid']; ?></div>
    </div>
</div>

<!-- Filters -->
<div class="admin-panel">
    <div class="panel-body">
        <form method="GET" class="filters-row">
            <select name="status" id="status">
                <option value="all" <?php echo $statusFilter === 'all' ? 'selected' : ''; ?>>All Statuses</option>
                <option value="new" <?php echo $statusFilter === 'new' ? 'selected' : ''; ?>>New</option>
                <option value="contacted" <?php echo $statusFilter === 'contacted' ? 'selected' : ''; ?>>Contacted</option>
                <option value="qualified" <?php echo $statusFilter === 'qualified' ? 'selected' : ''; ?>>Qualified</option>
                <option value="disqualified" <?php echo $statusFilter === 'disqualified' ? 'selected' : ''; ?>>Disqualified</option>
                <option value="paid" <?php echo $statusFilter === 'paid' ? 'selected' : ''; ?>>Paid</option>
            </select>

            <input type="search" name="search" id="search" placeholder="Referrer, business, or owner..." 
                   value="<?php echo htmlspecialchars($searchQuery); ?>" autocomplete="off">

            <?php if ($statusFilter !== 'all' || !empty($searchQuery)): ?>
                <a href="business_referrals.php" class="btn btn-secondary">Clear</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- Referrals Table -->
<div class="admin-panel">
    <div class="panel-body">
        <?php if (empty($referrals)): ?>
            <p style="color: #72777c; text-align: center; padding: 40px 0;">No business referrals found.</p>
        <?php else: ?>
        <div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Referrer</th>
                <th>Referrer Contact</th>
                <th>Business Name</th>
                <th>Owner Name</th>
                <th>Owner Contact</th>
                <th>Status</th>
                <th>Submitted</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($referrals as $referral): ?>
            <tr>
                <td><?php echo $referral['id']; ?></td>
                <td><strong><?php echo htmlspecialchars($referral['referrer_name']); ?></strong></td>
                <td>
                    <a href="mailto:<?php echo htmlspecialchars($referral['referrer_email']); ?>"><?php echo htmlspecialchars($referral['referrer_email']); ?></a><br>
                    <small><?php echo htmlspecialchars($referral['referrer_phone']); ?></small>
                </td>
                <td><strong><?php echo htmlspecialchars($referral['business_name']); ?></strong></td>
                <td><?php echo htmlspecialchars($referral['owner_name']); ?></td>
                <td>
                    <?php echo htmlspecialchars($referral['owner_phone']); ?><br>
                    <?php if ($referral['owner_email']): ?>
                        <small><a href="mailto:<?php echo htmlspecialchars($referral['owner_email']); ?>"><?php echo htmlspecialchars($referral['owner_email']); ?></a></small>
                    <?php endif; ?>
                </td>
                <td>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="referral_id" value="<?php echo $referral['id']; ?>">
                        <input type="hidden" name="action" value="update_status">
                        <select name="status" onchange="this.form.submit()" class="status-select status-<?php echo $referral['status']; ?>">
                            <option value="new" <?php echo $referral['status'] === 'new' ? 'selected' : ''; ?>>New</option>
                            <option value="contacted" <?php echo $referral['status'] === 'contacted' ? 'selected' : ''; ?>>Contacted</option>
                            <option value="qualified" <?php echo $referral['status'] === 'qualified' ? 'selected' : ''; ?>>Qualified</option>
                            <option value="disqualified" <?php echo $referral['status'] === 'disqualified' ? 'selected' : ''; ?>>Disqualified</option>
                            <option value="paid" <?php echo $referral['status'] === 'paid' ? 'selected' : ''; ?>>Paid $500</option>
                        </select>
                    </form>
                </td>
                <td><?php echo date('M j, Y g:i A', strtotime($referral['created_at'])); ?></td>
                <td>
                    <div style="display: flex; gap: 5px;">
                        <a href="business_referral_view.php?id=<?php echo $referral['id']; ?>" class="btn btn-sm btn-primary">View</a>
                        
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="referral_id" value="<?php echo $referral['id']; ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" class="btn btn-sm btn-danger" data-confirm-delete="Are you sure you want to delete this referral?">Delete</button>
                        </form>
                    </div>
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
