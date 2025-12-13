<?php
session_start();
include '../includes/db.php';

// Handle Login Logic
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify hashed password
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $row['id'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - IndustrialTech</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body { background: var(--gray-100); display: flex; align-items: center; justify-content: center; height: 100vh; }
        .login-card { background: white; padding: 3rem; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .login-header { text-align: center; margin-bottom: 2rem; }
        .login-header h2 { color: var(--primary-blue); font-weight: 700; }
        .error-msg { color: red; font-size: 0.9rem; margin-bottom: 1rem; text-align: center; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <h2>Admin Portal</h2>
            <p>Please sign in to continue</p>
        </div>
        
        <?php if($error): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required placeholder="Enter username">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="Enter password">
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Secure Login</button>
        </form>
        <div style="text-align: center; margin-top: 1rem;">
            <a href="../index.php" style="color: var(--gray-600); font-size: 0.9rem;">&larr; Back to Website</a>
        </div>
    </div>
</body>
</html>