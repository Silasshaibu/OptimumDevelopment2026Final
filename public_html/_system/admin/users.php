<?php
session_start();
require_once __DIR__ . '/../../db.php';

// Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $userId = (int) $_POST['user_id'];

    if ($action === 'promote') {
        $stmt = $conn->prepare("UPDATE users SET role = 'admin' WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
    } elseif ($action === 'demote') {
        $stmt = $conn->prepare("UPDATE users SET role = 'user' WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
    } elseif ($action === 'block') {
        $stmt = $conn->prepare("UPDATE users SET status = 'blocked' WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
    } elseif ($action === 'unblock') {
        $stmt = $conn->prepare("UPDATE users SET status = 'active' WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
    } elseif ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
    }
}

// Fetch users
$stmt = $conn->prepare("SELECT id, email, role, status, created_at FROM users ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management - Admin</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f9; margin: 0; padding: 0; }
        header { background: #1f1f1f; color: white; padding: 20px; text-align: center; }
        main { padding: 20px; max-width: 1200px; margin: auto; }
        .user { background: white; padding: 15px; margin: 10px 0; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
        .user h3 { margin: 0; }
        .user p { margin: 5px 0; }
        .actions { margin-top: 10px; }
        .actions button { padding: 5px 10px; margin-right: 5px; border: none; border-radius: 4px; cursor: pointer; }
        .promote { background: #28a745; color: white; }
        .demote { background: #ffc107; color: black; }
        .block { background: #dc3545; color: white; }
        .unblock { background: #17a2b8; color: white; }
        .delete { background: #6c757d; color: white; }
        .back { margin-top: 20px; }
        .back a { color: #007BFF; text-decoration: none; }
    </style>
</head>
<body>
    <header>
        <h1>User Management</h1>
    </header>
    <main>
        <?php if (empty($users)): ?>
            <p>No users yet.</p>
        <?php else: ?>
            <?php foreach ($users as $user): ?>
                <div class="user">
                    <h3><?php echo htmlspecialchars($user['email']); ?></h3>
                    <p><strong>Role:</strong> <?php echo ucfirst($user['role']); ?> | <strong>Status:</strong> <?php echo ucfirst($user['status']); ?> | <strong>Joined:</strong> <?php echo $user['created_at']; ?></p>
                    <div class="actions">
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <?php if ($user['role'] === 'user'): ?>
                                <button type="submit" name="action" value="promote" class="promote">Promote to Admin</button>
                            <?php else: ?>
                                <button type="submit" name="action" value="demote" class="demote">Demote to User</button>
                            <?php endif; ?>
                            <?php if ($user['status'] === 'active'): ?>
                                <button type="submit" name="action" value="block" class="block">Block</button>
                            <?php else: ?>
                                <button type="submit" name="action" value="unblock" class="unblock">Unblock</button>
                            <?php endif; ?>
                            <button type="submit" name="action" value="delete" class="delete" onclick="return confirm('Delete this user?')">Delete</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="back">
            <a href="dashboard.php">← Back to Dashboard</a>
        </div>
    </main>
</body>
</html>