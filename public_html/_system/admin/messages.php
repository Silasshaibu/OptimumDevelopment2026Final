<?php
session_start();
require_once __DIR__ . '/../../db.php';

// Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}

$page_title = 'Contact Messages';
$page_actions = '<a href="export_messages_excel.php' . ($_GET ? '?' . http_build_query($_GET) : '') . '" class="btn btn-primary">📊 Export Excel</a>
<a href="export_messages_pdf.php' . ($_GET ? '?' . http_build_query($_GET) : '') . '" class="btn btn-secondary">📄 Export PDF</a>';

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $messageId = (int) $_POST['message_id'];
    
    if ($_POST['action'] === 'update_status') {
        $newStatus = $_POST['status'];
        $stmt = $conn->prepare("UPDATE contact_messages SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $newStatus, $messageId);
        $stmt->execute();
        $stmt->close();
    } elseif ($_POST['action'] === 'delete') {
        $stmt = $conn->prepare("DELETE FROM contact_messages WHERE id = ?");
        $stmt->bind_param("i", $messageId);
        $stmt->execute();
        $stmt->close();
    }
    
    header("Location: messages.php" . ($_GET ? '?' . http_build_query($_GET) : ''));
    exit;
}

// Get filter parameters
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
    $whereConditions[] = "(CONCAT(first_name, ' ', last_name) LIKE ? OR email LIKE ? OR company LIKE ?)";
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
    SUM(CASE WHEN status = 'new' THEN 1 ELSE 0 END) as new_count,
    SUM(CASE WHEN status = 'read' THEN 1 ELSE 0 END) as read_count,
    SUM(CASE WHEN status = 'replied' THEN 1 ELSE 0 END) as replied_count,
    SUM(CASE WHEN status = 'closed' THEN 1 ELSE 0 END) as closed_count
FROM contact_messages";
$statsResult = $conn->query($statsQuery);
$stats = $statsResult->fetch_assoc();

// Get messages
$sql = "SELECT * FROM contact_messages $whereClause ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$messages = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

include 'admin-layout.php';
?>

<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-card stat-info">
        <div class="stat-label">Total Messages</div>
        <div class="stat-value"><?php echo $stats['total']; ?></div>
    </div>
    <div class="stat-card stat-success">
        <div class="stat-label">New</div>
        <div class="stat-value"><?php echo $stats['new_count']; ?></div>
    </div>
    <div class="stat-card stat-warning">
        <div class="stat-label">Read</div>
        <div class="stat-value"><?php echo $stats['read_count']; ?></div>
    </div>
    <div class="stat-card stat-info">
        <div class="stat-label">Replied</div>
        <div class="stat-value"><?php echo $stats['replied_count']; ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Closed</div>
        <div class="stat-value"><?php echo $stats['closed_count']; ?></div>
    </div>
</div>

<!-- Filters -->
<div class="admin-panel">
    <div class="panel-body">
        <form method="get" id="filterForm" class="filters-row">
            <select name="status" id="statusFilter">
                <option value="all" <?php echo $statusFilter === 'all' ? 'selected' : ''; ?>>All Statuses</option>
                <option value="new" <?php echo $statusFilter === 'new' ? 'selected' : ''; ?>>New</option>
                <option value="read" <?php echo $statusFilter === 'read' ? 'selected' : ''; ?>>Read</option>
                <option value="replied" <?php echo $statusFilter === 'replied' ? 'selected' : ''; ?>>Replied</option>
                <option value="closed" <?php echo $statusFilter === 'closed' ? 'selected' : ''; ?>>Closed</option>
            </select>
            
            <input type="search" name="search" id="searchInput" placeholder="Search name, email, company..." 
                   value="<?php echo htmlspecialchars($searchQuery); ?>" autocomplete="off">
                   
            <?php if ($statusFilter !== 'all' || !empty($searchQuery)): ?>
                <a href="messages.php" class="btn btn-secondary">Clear</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- Messages Table -->
<div class="admin-panel">
    <div class="panel-body">
        <?php if (empty($messages)): ?>
            <p style="color: #72777c; text-align: center; padding: 40px 0;">No messages found.</p>
        <?php else: ?>
            <div id="messagesTableContainer">
                <div class="admin-table-wrapper">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Company</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Export</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($messages as $message): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($message['first_name'] . ' ' . $message['last_name']); ?></td>
                                    <td><a href="mailto:<?php echo htmlspecialchars($message['email']); ?>"><?php echo htmlspecialchars($message['email']); ?></a></td>
                                    <td><?php echo htmlspecialchars($message['company'] ?: '-'); ?></td>
                                    <td style="max-width: 300px;">
                                        <?php echo htmlspecialchars(substr($message['message'], 0, 80)); ?>
                                        <?php if (strlen($message['message']) > 80) echo '...'; ?>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?php echo $message['status']; ?>">
                                            <?php echo ucfirst($message['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('M j, Y', strtotime($message['created_at'])); ?></td>
                                    <td>
                                        <a href="export_single_message_excel.php?id=<?php echo $message['id']; ?>" 
                                           class="btn-export-excel" title="Export to Excel">📊</a>
                                        <a href="export_single_message_pdf.php?id=<?php echo $message['id']; ?>" 
                                           class="btn-export-pdf" title="Export to PDF">📄</a>
                                    </td>
                                    <td>
                                        <div style="display: flex; gap: 5px;">
                                            <a href="message_view.php?id=<?php echo $message['id']; ?>" class="btn btn-sm btn-primary">View</a>
                                            
                                            <form method="post" style="display: inline;">
                                                <input type="hidden" name="message_id" value="<?php echo $message['id']; ?>">
                                                <input type="hidden" name="action" value="delete">
                                                <button type="submit" class="btn btn-sm btn-danger" data-confirm-delete="Are you sure you want to delete this message?">Delete</button>
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
const messagesTableContainer = document.getElementById('messagesTableContainer');

function performSearch() {
    const formData = new FormData(document.getElementById('filterForm'));
    const params = new URLSearchParams(formData);
    
    // Show loading state
    if (messagesTableContainer) {
        messagesTableContainer.style.opacity = '0.5';
    }
    
    fetch('messages.php?' + params.toString())
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTable = doc.getElementById('messagesTableContainer');
            
            if (newTable && messagesTableContainer) {
                messagesTableContainer.innerHTML = newTable.innerHTML;
                messagesTableContainer.style.opacity = '1';
            }
            
            // Update URL without reload
            window.history.pushState({}, '', 'messages.php?' + params.toString());
        })
        .catch(error => {
            console.error('Search error:', error);
            if (messagesTableContainer) {
                messagesTableContainer.style.opacity = '1';
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
</script>

<?php include 'admin-layout-footer.php'; ?>
