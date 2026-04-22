<?php
session_start();
require_once __DIR__ . '/../../db.php';

// Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}

$page_title = 'Digital Services Briefs';
$page_actions = '<a href="export_digital_briefs_excel.php' . ($_GET ? '?' . http_build_query($_GET) : '') . '" class="btn btn-primary">📊 Export Excel</a>
<a href="export_digital_briefs_pdf.php' . ($_GET ? '?' . http_build_query($_GET) : '') . '" class="btn btn-secondary">📄 Export PDF</a>';

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $briefId = (int) ($_POST['brief_id'] ?? 0);

    if ($action === 'update_status' && isset($_POST['status'])) {
        $status = $_POST['status'];
        $stmt = $conn->prepare("UPDATE digital_briefs SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $briefId);
        $stmt->execute();
        $stmt->close();
    } elseif ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM digital_briefs WHERE id = ?");
        $stmt->bind_param("i", $briefId);
        $stmt->execute();
        $stmt->close();
    }
    
    header("Location: digital_briefs.php" . ($_GET ? '?' . http_build_query($_GET) : ''));
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
    $whereConditions[] = "(name LIKE ? OR email LIKE ? OR website LIKE ?)";
    $searchParam = '%' . $searchQuery . '%';
    $params[] = $searchParam;
    $params[] = $searchParam;
    $params[] = $searchParam;
    $types .= 'sss';
}

$whereClause = !empty($whereConditions) ? 'WHERE ' . implode(' AND ', $whereConditions) : '';

// Get statistics
$statsQuery = "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN status = 'new' THEN 1 ELSE 0 END) as new,
    SUM(CASE WHEN status = 'contacted' THEN 1 ELSE 0 END) as contacted,
    SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) as in_progress,
    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
    SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled
FROM digital_briefs";
$statsResult = $conn->query($statsQuery);
$stats = $statsResult->fetch_assoc();

$sql = "SELECT * FROM digital_briefs $whereClause ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$briefs = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

include 'admin-layout.php';
?>

<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-card stat-info">
        <div class="stat-label">Total Briefs</div>
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
        <div class="stat-label">In Progress</div>
        <div class="stat-value"><?php echo $stats['in_progress']; ?></div>
    </div>
    
    <div class="stat-card stat-success">
        <div class="stat-label">Completed</div>
        <div class="stat-value"><?php echo $stats['completed']; ?></div>
    </div>

    <div class="stat-card stat-danger">
        <div class="stat-label">Cancelled</div>
        <div class="stat-value"><?php echo $stats['cancelled']; ?></div>
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
                <option value="in_progress" <?php echo $statusFilter === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                <option value="completed" <?php echo $statusFilter === 'completed' ? 'selected' : ''; ?>>Completed</option>
                <option value="cancelled" <?php echo $statusFilter === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
            </select>

            <input type="search" name="search" id="search" placeholder="Name, email, or website..." 
                   value="<?php echo htmlspecialchars($searchQuery); ?>" autocomplete="off">

            <?php if ($statusFilter !== 'all' || !empty($searchQuery)): ?>
                <a href="digital_briefs.php" class="btn btn-secondary">Clear</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- Applications Table -->
<div class="admin-panel">
    <div class="panel-body">
        <?php if (empty($briefs)): ?>
            <p style="color: #72777c; text-align: center; padding: 40px 0;">No digital service briefs found.</p>
        <?php else: ?>
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Budget Range</th>
                        <th>Services</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($briefs as $brief): 
                        $services = json_decode($brief['services'], true);
                        $serviceCount = is_array($services) ? count($services) : 0;
                    ?>
                    <tr>
                        <td><?php echo $brief['id']; ?></td>
                        <td><strong><?php echo htmlspecialchars($brief['name']); ?></strong></td>
                        <td><a href="mailto:<?php echo htmlspecialchars($brief['email']); ?>"><?php echo htmlspecialchars($brief['email']); ?></a></td>
                        <td><?php echo $brief['phone'] ? htmlspecialchars($brief['phone']) : '—'; ?></td>
                        <td>$<?php echo number_format($brief['budget_min']); ?> - $<?php echo number_format($brief['budget_max']); ?></td>
                        <td><span class="badge badge-info"><?php echo $serviceCount; ?> service<?php echo $serviceCount !== 1 ? 's' : ''; ?></span></td>
                        <td>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="brief_id" value="<?php echo $brief['id']; ?>">
                                <input type="hidden" name="action" value="update_status">
                                <select name="status" onchange="this.form.submit()" class="status-select status-<?php echo $brief['status']; ?>">
                                    <option value="new" <?php echo $brief['status'] === 'new' ? 'selected' : ''; ?>>New</option>
                                    <option value="contacted" <?php echo $brief['status'] === 'contacted' ? 'selected' : ''; ?>>Contacted</option>
                                    <option value="in_progress" <?php echo $brief['status'] === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                                    <option value="completed" <?php echo $brief['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                    <option value="cancelled" <?php echo $brief['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                </select>
                            </form>
                        </td>
                        <td><?php echo date('M j, Y g:i A', strtotime($brief['created_at'])); ?></td>
                        <td>
                            <div style="display: flex; gap: 5px;">
                                <a href="digital_brief_view.php?id=<?php echo $brief['id']; ?>" class="btn btn-sm btn-primary">View</a>
                                
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="brief_id" value="<?php echo $brief['id']; ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <button type="submit" class="btn btn-sm btn-danger" data-confirm-delete="Are you sure you want to delete this brief?">Delete</button>
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
