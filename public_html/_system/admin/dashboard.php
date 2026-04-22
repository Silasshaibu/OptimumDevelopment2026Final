<?php
// Redirect old dashboard to new index.php
header("Location: index.php");
exit;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f9; margin:0; padding:0; }
        header { background: #1f1f1f; color: white; padding: 20px; text-align: center; }
        main { padding: 20px; max-width: 800px; margin: auto; }
        .card { background: white; padding: 20px; margin: 10px 0; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
        .card a { text-decoration: none; color: #1f1f1f; font-weight: bold; display: block; }
        .card a:hover { color: #007BFF; }
    </style>
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
        <p>Welcome, <?= htmlspecialchars($_SESSION['role']) ?>!</p>
    </header>
    <main>
        <div class="card">
            <a href="reviews.php">📝 Review Moderation</a>
            <p>Approve, reject, and manage all user and guest reviews.</p>
        </div>
        <div class="card">
            <a href="users.php">👤 User Management</a>
            <p>Promote users to admin or manage existing accounts.</p>
        </div>
        <div class="card">
            <a href="messages.php">📩 Messages</a>
            <p>View messages submitted via the contact form (optional).</p>
        </div>
        <div class="card">
            <a href="merchant_applications.php">💼 Merchant Applications</a>
            <p>View and manage merchant application submissions with export options.</p>
        </div>
        <div class="card">
            <a href="../logout.php">🚪 Logout</a>
            <p>Securely log out of the admin dashboard.</p>
        </div>
    </main>
</body>
</html>
