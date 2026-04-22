<?php
session_start();
require_once __DIR__ . '/../../db.php';

// Login attempt limits
$max_attempts = 5;
$lockout_time = 15 * 60; // 15 minutes in seconds

$ip = $_SERVER['REMOTE_ADDR'];
$attempt_key = 'login_attempts_' . $ip;
$lockout_key = 'login_lockout_' . $ip;

// Check if locked out
if (isset($_SESSION[$lockout_key]) && time() < $_SESSION[$lockout_key]) {
    $remaining_time = ceil(($_SESSION[$lockout_key] - time()) / 60);
    $error = "Too many failed login attempts. Please try again in $remaining_time minutes.";
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';

    if (empty($email) || empty($pass)) {
        $error = "Please enter both email and password.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND status != 'blocked'");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($pass, $user['password'])) {
            // Success: reset attempts and log in
            unset($_SESSION[$attempt_key], $_SESSION[$lockout_key]);
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            header("Location: ../admin/index.php");
            exit;
        } else {
            // Failure: increment attempts
            $_SESSION[$attempt_key] = ($_SESSION[$attempt_key] ?? 0) + 1;
            if ($_SESSION[$attempt_key] >= $max_attempts) {
                $_SESSION[$lockout_key] = time() + $lockout_time;
                $error = "Too many failed login attempts. Please try again in 15 minutes.";
            } else {
                $remaining_attempts = $max_attempts - $_SESSION[$attempt_key];
                $error = "ERROR: Invalid username or password. $remaining_attempts attempts remaining.";
            }
        }
    }
}

// Display login form
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In ‹ Optimum Payment Solutions — WordPress</title>
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
        .login {
            background: #fff;
            border: 1px solid #c3c4c7;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            width: 320px;
            padding: 26px 24px 34px;
            margin: 0 auto;
        }
        .login h1 {
            text-align: center;
            margin: 0 0 24px 0;
            padding: 0;
            font-size: 1.25rem;
            font-weight: 400;
        }
        .login h1 a {
            background-image: url('../../assets/images/logo/optimum-navLogo.webp');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center top;
            display: block;
            width: 200px;
            height: 84px;
            margin: 0 auto 16px;
            text-indent: -9999px;
        }
        .login form {
            margin-top: 20px;
        }
        .login label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }
        .login .forgetmenot label {
            margin-bottom: 0;
        }
        .login input[type="text"], .login input[type="password"] {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 0.875rem;
        }
        .login .button-primary {
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
        .login .button-primary:hover {
            background: #005a87;
            border-color: #005a87;
        }
        .login #login_error {
            background: #fff5cd;
            border: 1px solid #f6dda6;
            border-radius: 4px;
            padding: 12px;
            margin-bottom: 16px;
            color: #8a6d3b;
        }
        .login .forgetmenot {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            gap: 8px;
            margin-top: 16px;
        }
        .login .forgetmenot a {
            color: #007cba;
            text-decoration: none;
        }
        .login .forgetmenot a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login">
        <h1><a href="#">Optimum Payment Solutions</a></h1>
        <?php if (isset($error)): ?>
            <div id="login_error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form name="loginform" id="loginform" action="" method="post">
            <p>
                <label for="user_login">Username or Email Address</label>
                <input type="text" name="email" id="user_login" class="input" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" size="20" autocapitalize="off" autocomplete="username">
            </p>
            <p>
                <label for="user_pass">Password</label>
                <input type="password" name="password" id="user_pass" class="input" value="" size="20" autocomplete="current-password">
            </p>
            <p class="forgetmenot">
                <input name="rememberme" type="checkbox" id="rememberme" value="forever">
                <label for="rememberme">Remember Me</label>
            </p>
            <p class="submit">
                <input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="Log In">
            </p>
        </form>
        <p class="forgetmenot">
            <a href="reset_password.php">Lost your password?</a>
        </p>
    </div>
</body>
</html>