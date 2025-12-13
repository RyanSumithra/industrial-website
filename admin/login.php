<?php
session_start();
// Adjust path if necessary, but this matches your structure
if(file_exists('../includes/db.php')) {
    include '../includes/db.php';
} else {
    die("Error: Database configuration missing.");
}

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
            $error = "Invalid credentials.";
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
    <title>Secure Login - IndustrialTech</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-red: #ff3333;
            --dark-bg: #050505;
            --card-bg: #111111;
            --border: #333;
        }

        body {
            background-color: var(--dark-bg);
            background-image: 
                linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8)),
                repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(255, 51, 51, 0.03) 10px, rgba(255, 51, 51, 0.03) 11px);
            font-family: 'Inter', sans-serif;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .login-card {
            background: var(--card-bg);
            padding: 3rem;
            border-radius: 12px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
            width: 100%;
            max-width: 400px;
            border: 1px solid #222;
            position: relative;
            overflow: hidden;
            animation: fadeUp 0.6s ease-out;
        }

        /* Top Red Line */
        .login-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-red), #990000);
        }

        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .login-header h2 {
            color: white;
            font-weight: 800;
            font-size: 1.8rem;
            margin: 0 0 10px 0;
            letter-spacing: -0.5px;
        }

        .login-header p {
            color: #666;
            margin: 0;
            font-size: 0.9rem;
        }

        .error-msg {
            background: rgba(255, 51, 51, 0.1);
            color: var(--primary-red);
            padding: 12px;
            border-radius: 6px;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            text-align: center;
            border: 1px solid rgba(255, 51, 51, 0.2);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.85rem;
            color: #aaa;
            font-weight: 600;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            background: #0a0a0a;
            border: 1px solid var(--border);
            border-radius: 6px;
            color: white;
            font-family: inherit;
            box-sizing: border-box; /* Fix width issues */
            transition: 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-red);
            box-shadow: 0 0 15px rgba(255, 51, 51, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: var(--primary-red);
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-login:hover {
            background: #cc0000;
            box-shadow: 0 0 20px rgba(255, 51, 51, 0.3);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: #666;
            text-decoration: none;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .back-link:hover {
            color: white;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <h2>System Access</h2>
            <p>Enter credentials to access dashboard</p>
        </div>
        
        <?php if($error): ?>
            <div class="error-msg">⚠️ <?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label>Admin ID</label>
                <input type="text" name="username" required placeholder="admin" autocomplete="off">
            </div>
            <div class="form-group">
                <label>Secure Key</label>
                <input type="password" name="password" required placeholder="••••••••">
            </div>
            <button type="submit" class="btn-login">Authenticate ➜</button>
        </form>

        <a href="../index.php" class="back-link">
            &larr; Return to Main Site
        </a>
    </div>

</body>
</html>