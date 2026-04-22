<?php
session_start();
require_once __DIR__ . '/../../db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    if (empty($email)) {
        $message = "Please enter your email address.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // In a real app, generate token, store in DB, send email
            // For now, just show message
            $message = "If an account with that email exists, a password reset link has been sent.";
        } else {
            $message = "If an account with that email exists, a password reset link has been sent.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password ‹ Optimum Payment Solutions</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            background: #f1f1f1;
            color: #444;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .reset {
            background: #fff;
            border: 1px solid #c3c4c7;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            width: 320px;
            padding: 26px 24px 34px;
            margin: 0 auto;
        }
        .reset h1 {
            text-align: center;
            margin: 0 0 24px 0;
            padding: 0;
            font-size: 1.25rem;
            font-weight: 400;
        }
        .reset form {
            margin-top: 20px;
        }
        .reset label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }
        .reset input[type="text"] {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 0.875rem;
        }
        .reset .button-primary {
            background: #007cba;
            border: 1px solid #007cba;
            color: #fff;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 0.875rem;
            font-weight: 600;
            margin-top: 12px;
        }
        .reset .button-primary:hover {
            background: #005a87;
            border-color: #005a87;
        }
        .reset .message {
            background: #fff5cd;
            border: 1px solid #f6dda6;
            border-radius: 4px;
            padding: 12px;
            margin-bottom: 16px;
            color: #8a6d3b;
        }
        .reset .back {
            text-align: center;
            margin-top: 16px;
        }
        .reset .back a {
            color: #007cba;
            text-decoration: none;
        }
        .reset .back a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="reset">
        <h1>Reset Password</h1>
        <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <p>
                <label for="email">Email Address</label>
                <input type="text" name="email" id="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" size="20" autocapitalize="off" autocomplete="email">
            </p>
            <p>
                <input type="submit" name="submit" id="submit" class="button button-primary button-large" value="Get New Password">
            </p>
        </form>
        <p class="back">
            <a href="login.php">← Back to login</a>
        </p>
    </div>
</body>
</html>