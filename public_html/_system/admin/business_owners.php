<?php
session_start();
require_once __DIR__ . '/../../db.php';

// Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}

$page_title = 'Business Owner Inquiries';
$page_actions = '<a href="export_business_owners_excel.php' . ($_GET ? '?' . http_build_query($_GET) : '') . '" class="btn btn-primary">📊 Export Excel</a>
<a href="export_business_owners_pdf.php' . ($_GET ? '?' . http_build_query($_GET) : '') . '" class="btn btn-secondary">📄 Export PDF</a>';

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $ownerId = (int) ($_POST['owner_id'] ?? 0);

    if ($action === 'update_status' && isset($_POST['status'])) {
        $status = $_POST['status'];
        $stmt = $conn->prepare("UPDATE business_owners SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $ownerId);
        $stmt->execute();
        $stmt->close();
    } elseif ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM business_owners WHERE id = ?");
        $stmt->bind_param("i", $ownerId);
        $stmt->execute();
        $stmt->close();
    }
    
    header("Location: business_owners.php" . ($_GET ? '?' . http_build_query($_GET) : ''));
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
    $whereConditions[] = "(owner_name LIKE ? OR business_name LIKE ? OR email LIKE ?)";
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
    SUM(CASE WHEN status = 'meeting_scheduled' THEN 1 ELSE 0 END) as meeting_scheduled,
    SUM(CASE WHEN status = 'proposal_sent' THEN 1 ELSE 0 END) as proposal_sent,
    SUM(CASE WHEN status = 'closed_won' THEN 1 ELSE 0 END) as closed_won,
    SUM(CASE WHEN status = 'closed_lost' THEN 1 ELSE 0 END) as closed_lost
FROM business_owners";
$statsResult = $conn->query($statsQuery);
$stats = $statsResult->fetch_assoc();

$sql = "SELECT * FROM business_owners $whereClause ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$owners = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

include 'admin-layout.php';
?>

<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-card stat-info">
        <div class="stat-label">Total Inquiries</div>
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
        <div class="stat-label">Meeting Scheduled</div>
        <div class="stat-value"><?php echo $stats['meeting_scheduled']; ?></div>
    </div>
    
    <div class="stat-card stat-warning">
        <div class="stat-label">Proposal Sent</div>
        <div class="stat-value"><?php echo $stats['proposal_sent']; ?></div>
    </div>

    <div class="stat-card stat-success">
        <div class="stat-label">Closed Won</div>
        <div class="stat-value"><?php echo $stats['closed_won']; ?></div>
    </div>

    <div class="stat-card stat-danger">
        <div class="stat-label">Closed Lost</div>
        <div class="stat-value"><?php echo $stats['closed_lost']; ?></div>
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
                <option value="meeting_scheduled" <?php echo $statusFilter === 'meeting_scheduled' ? 'selected' : ''; ?>>Meeting Scheduled</option>
                <option value="proposal_sent" <?php echo $statusFilter === 'proposal_sent' ? 'selected' : ''; ?>>Proposal Sent</option>
                <option value="closed_won" <?php echo $statusFilter === 'closed_won' ? 'selected' : ''; ?>>Closed Won</option>
                <option value="closed_lost" <?php echo $statusFilter === 'closed_lost' ? 'selected' : ''; ?>>Closed Lost</option>
            </select>

            <input type="search" name="search" id="search" placeholder="Owner, business, or email..." 
                   value="<?php echo htmlspecialchars($searchQuery); ?>" autocomplete="off">

            <?php if ($statusFilter !== 'all' || !empty($searchQuery)): ?>
                <a href="business_owners.php" class="btn btn-secondary">Clear</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- Inquiries Table -->
<div class="admin-panel">
    <div class="panel-body">
        <?php if (empty($owners)): ?>
            <p style="color: #72777c; text-align: center; padding: 40px 0;">No business owner inquiries found.</p>
        <?php else: ?>
        <div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Owner Name</th>
                <th>Business Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Submitted</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($owners as $owner): ?>
            <tr>
                <td><?php echo $owner['id']; ?></td>
                <td><strong><?php echo htmlspecialchars($owner['owner_name']); ?></strong></td>
                <td><?php echo htmlspecialchars($owner['business_name']); ?></td>
                <td><a href="mailto:<?php echo htmlspecialchars($owner['email']); ?>"><?php echo htmlspecialchars($owner['email']); ?></a></td>
                <td><?php echo htmlspecialchars($owner['phone']); ?></td>
                <td>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="owner_id" value="<?php echo $owner['id']; ?>">
                        <input type="hidden" name="action" value="update_status">
                        <select name="status" onchange="this.form.submit()" class="status-select status-<?php echo $owner['status']; ?>">
                            <option value="new" <?php echo $owner['status'] === 'new' ? 'selected' : ''; ?>>New</option>
                            <option value="contacted" <?php echo $owner['status'] === 'contacted' ? 'selected' : ''; ?>>Contacted</option>
                            <option value="meeting_scheduled" <?php echo $owner['status'] === 'meeting_scheduled' ? 'selected' : ''; ?>>Meeting Scheduled</option>
                            <option value="proposal_sent" <?php echo $owner['status'] === 'proposal_sent' ? 'selected' : ''; ?>>Proposal Sent</option>
                            <option value="closed_won" <?php echo $owner['status'] === 'closed_won' ? 'selected' : ''; ?>>Closed Won</option>
                            <option value="closed_lost" <?php echo $owner['status'] === 'closed_lost' ? 'selected' : ''; ?>>Closed Lost</option>
                        </select>
                    </form>
                </td>
                <td><?php echo date('M j, Y g:i A', strtotime($owner['created_at'])); ?></td>
                <td>
                    <div style="display: flex; gap: 5px;">
                        <a href="business_owner_view.php?id=<?php echo $owner['id']; ?>" class="btn btn-sm btn-primary">View</a>
                        
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="owner_id" value="<?php echo $owner['id']; ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" class="btn btn-sm btn-danger" data-confirm-delete="Are you sure you want to delete this inquiry?">Delete</button>
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
