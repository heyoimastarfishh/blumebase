<?php
session_start();
require_once 'includes/db.php';

// If they are already logged in, redirect them to the shop
if (isset($_SESSION['user_name'])) {
    header("Location: shop.php");
    exit;
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Server-side validation
    if (empty($email) || empty($password)) {
        $error = "Please enter both email and password.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM base_users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify user exists and password matches
        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['user_email'] = $user['email'];
            header("Location: shop.php");
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    }
}
$use_solid_nav = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account | Blume</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="page-with-nav">
    <?php include 'includes/navbar.php'; ?>

    <main class="blume-container" style="max-width: 500px;">
        <h1 class="serif-font" style="text-align: center; font-size: 36px; margin-bottom: 24px;">Login</h1>
        
        <?php if (isset($_GET['registered']) && $_GET['registered'] == 'success'): ?>
            <div style="color: green; margin-bottom: 16px; text-align: center; font-size: 14px;">Account created successfully. Please log in.</div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div style="color: red; margin-bottom: 16px; text-align: center; font-size: 14px;"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form action="login.php" method="POST" class="space-y-4 mb-6">
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required style="width: 100%; border: 1px solid #ccc; padding: 12px; font-size: 14px; margin-bottom: 16px;">
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required style="width: 100%; border: 1px solid #ccc; padding: 12px; font-size: 14px; margin-bottom: 8px;">
            </div>
            
            <div style="text-align: left; margin-bottom: 24px;">
                <a href="#" style="font-size: 12px; color: #666; text-decoration: underline;">Forgot your password?</a>
            </div>
            
            <button type="submit" class="btn-primary">SIGN IN</button>
        </form>

        <p style="text-align: center; margin-top: 32px; font-size: 12px; color: #666;">
            Don't have an account? <a href="register.php" style="color: #000; text-decoration: underline;">Create one</a>
        </p>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>