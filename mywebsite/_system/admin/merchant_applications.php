<?php
session_start();
require_once __DIR__ . '/../../db.php';

// Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}

$page_title = 'Merchant Applications';
$page_actions = '<a href="export_merchant_excel.php' . ($_GET ? '?' . http_build_query($_GET) : '') . '" class="btn btn-primary">📊 Export Excel</a>
<a href="export_merchant_pdf.php' . ($_GET ? '?' . http_build_query($_GET) : '') . '" class="btn btn-secondary">📄 Export PDF</a>';

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $appId = (int) ($_POST['app_id'] ?? 0);

    if ($action === 'update_status' && isset($_POST['status'])) {
        $status = $_POST['status'];
        $stmt = $conn->prepare("UPDATE merchant_applications SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $appId);
        $stmt->execute();
        $stmt->close();
    } elseif ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM merchant_applications WHERE id = ?");
        $stmt->bind_param("i", $appId);
        $stmt->execute();
        $stmt->close();
    }
    
    header("Location: merchant_applications.php" . ($_GET ? '?' . http_build_query($_GET) : ''));
    exit;
}

// Filters
$statusFilter = $_GET['status'] ?? 'all';
$confirmedFilter = $_GET['confirmed'] ?? 'all';
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

if ($confirmedFilter === 'confirmed') {
    $whereConditions[] = "confirmed = 1";
} elseif ($confirmedFilter === 'unconfirmed') {
    $whereConditions[] = "confirmed = 0";
}

if (!empty($searchQuery)) {
    $whereConditions[] = "(company LIKE ? OR CONCAT(first_name, ' ', surname) LIKE ? OR email LIKE ?)";
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
    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
    SUM(CASE WHEN status = 'processing' THEN 1 ELSE 0 END) as processing,
    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved,
    SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected,
    SUM(CASE WHEN confirmed = 1 THEN 1 ELSE 0 END) as confirmed
FROM merchant_applications";
$statsResult = $conn->query($statsQuery);
$stats = $statsResult->fetch_assoc();

$sql = "SELECT * FROM merchant_applications $whereClause ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$applications = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

include 'admin-layout.php';
?>

<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-card stat-info">
        <div class="stat-label">Total Applications</div>
        <div class="stat-value"><?php echo $stats['total']; ?></div>
    </div>
    <div class="stat-card stat-warning">
        <div class="stat-label">Pending</div>
        <div class="stat-value"><?php echo $stats['pending']; ?></div>
    </div>
    <div class="stat-card stat-info">
        <div class="stat-label">Processing</div>
        <div class="stat-value"><?php echo $stats['processing']; ?></div>
    </div>
    <div class="stat-card stat-success">
        <div class="stat-label">Approved</div>
        <div class="stat-value"><?php echo $stats['approved']; ?></div>
    </div>
    <div class="stat-card stat-danger">
        <div class="stat-label">Rejected</div>
        <div class="stat-value"><?php echo $stats['rejected']; ?></div>
    </div>
    <div class="stat-card stat-success">
        <div class="stat-label">Confirmed</div>
        <div class="stat-value"><?php echo $stats['confirmed']; ?></div>
    </div>
</div>

<!-- Filters -->
<div class="admin-panel">
    <div class="panel-body">
        <form method="get" id="filterForm" class="filters-row">
            <select name="status" id="statusFilter">
                <option value="all" <?php echo $statusFilter === 'all' ? 'selected' : ''; ?>>All Statuses</option>
                <option value="pending" <?php echo $statusFilter === 'pending' ? 'selected' : ''; ?>>Pending</option>
                <option value="processing" <?php echo $statusFilter === 'processing' ? 'selected' : ''; ?>>Processing</option>
                <option value="approved" <?php echo $statusFilter === 'approved' ? 'selected' : ''; ?>>Approved</option>
                <option value="rejected" <?php echo $statusFilter === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
            </select>
            
            <select name="confirmed" id="confirmedFilter">
                <option value="all" <?php echo $confirmedFilter === 'all' ? 'selected' : ''; ?>>All Confirmations</option>
                <option value="confirmed" <?php echo $confirmedFilter === 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                <option value="unconfirmed" <?php echo $confirmedFilter === 'unconfirmed' ? 'selected' : ''; ?>>Unconfirmed</option>
            </select>
            
            <input type="search" name="search" id="searchInput" placeholder="Search company, name, email..." 
                   value="<?php echo htmlspecialchars($searchQuery); ?>" autocomplete="off">
                   
            <?php if ($statusFilter !== 'all' || $confirmedFilter !== 'all' || !empty($searchQuery)): ?>
                <a href="merchant_applications.php" class="btn btn-secondary">Clear</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- Applications Table -->
<div class="admin-panel">
    <div class="panel-body">
        <?php if (empty($applications)): ?>
            <p style="color: #72777c; text-align: center; padding: 40px 0;">No applications found.</p>
        <?php else: ?>
            <div id="applicationsTableContainer">
                <div class="admin-table-wrapper">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Company</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Business Type</th>
                                <th>Monthly Volume</th>
                                <th>Status</th>
                                <th>Confirmed</th>
                                <th>Date</th>
                                <th>Export</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($applications as $app): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($app['company']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($app['first_name'] . ' ' . $app['surname']); ?></td>
                                    <td><a href="mailto:<?php echo htmlspecialchars($app['email']); ?>"><?php echo htmlspecialchars($app['email']); ?></a></td>
                                    <td><?php echo htmlspecialchars($app['phone']); ?></td>
                                    <td><?php echo htmlspecialchars($app['business_type'] ?: '-'); ?></td>
                                    <td>$<?php echo htmlspecialchars($app['monthly_volume']); ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo $app['status']; ?>">
                                            <?php echo ucfirst($app['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($app['confirmed']): ?>
                                            <span class="status-badge status-approved">✓ Yes</span>
                                        <?php else: ?>
                                            <span class="status-badge status-pending">✗ No</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo date('M j, Y', strtotime($app['created_at'])); ?></td>
                                    <td>
                                        <a href="export_single_merchant_excel.php?id=<?php echo $app['id']; ?>" 
                                           class="btn-export-excel" title="Export to Excel">📊</a>
                                        <a href="export_single_merchant_pdf.php?id=<?php echo $app['id']; ?>" 
                                           class="btn-export-pdf" title="Export to PDF">📄</a>
                                    </td>
                                    <td>
                                        <div style="display: flex; gap: 5px;">
                                            <a href="merchant_application_view.php?id=<?php echo $app['id']; ?>" class="btn btn-sm btn-primary">View</a>
                                            
                                            <form method="post" style="display: inline;">
                                                <input type="hidden" name="app_id" value="<?php echo $app['id']; ?>">
                                                <input type="hidden" name="action" value="delete">
                                                <button type="submit" class="btn btn-sm btn-danger" data-confirm-delete="Are you sure you want to delete this application?">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.btn-export-excel, .btn-export-pdf {
    text-decoration: none;
    font-size: 1.125rem;
    display: inline-block;
    transition: transform 0.2s;
    margin-right: 5px;
}

.btn-export-excel:hover, .btn-export-pdf:hover {
    transform: scale(1.2);
}
</style>

<script>
// AJAX Search functionality
let searchTimeout;
const searchInput = document.getElementById('searchInput');
const statusFilter = document.getElementById('statusFilter');
const confirmedFilter = document.getElementById('confirmedFilter');
const applicationsTableContainer = document.getElementById('applicationsTableContainer');

function performSearch() {
    const formData = new FormData(document.getElementById('filterForm'));
    const params = new URLSearchParams(formData);
    
    // Show loading state
    if (applicationsTableContainer) {
        applicationsTableContainer.style.opacity = '0.5';
    }
    
    fetch('merchant_applications.php?' + params.toString())
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTable = doc.getElementById('applicationsTableContainer');
            
            if (newTable && applicationsTableContainer) {
                applicationsTableContainer.innerHTML = newTable.innerHTML;
                applicationsTableContainer.style.opacity = '1';
            }
            
            // Update URL without reload
            window.history.pushState({}, '', 'merchant_applications.php?' + params.toString());
        })
        .catch(error => {
            console.error('Search error:', error);
            if (applicationsTableContainer) {
                applicationsTableContainer.style.opacity = '1';
            }
        });
}

if (searchInput) {
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(performSearch, 500);
    });
}

if (statusFilter) {
    statusFilter.addEventListener('change', performSearch);
}

if (confirmedFilter) {
    confirmedFilter.addEventListener('change', performSearch);
}
</script>

<?php include 'admin-layout-footer.php'; ?>
