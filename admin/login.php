<?php
// -------------------- 1. HOSTINGER CONFIGURATION --------------------

// [A] YOUR ADMIN EMAIL (Where you receive the OTP)
define('ADMIN_EMAIL', 'patilpouras145@gmail.com'); 

// [B] HOSTINGER SENDER EMAIL
define('SENDER_EMAIL', 'info@techasiamechatronics.com'); 

// [C] GOOGLE RECAPTCHA KEYS
define('RECAPTCHA_SITE_KEY', 'paste here site key'); 
define('RECAPTCHA_SECRET_KEY', 'paste here secret key');

// -------------------- 2. SECURITY SETUP --------------------
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_samesite', 'Strict');
session_start();

// Database Connection
if(file_exists('../includes/db.php')) { require_once '../includes/db.php'; } 
else { die("System Error: DB config missing."); }

// Initialize CSRF
if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

$error = '';
$step = isset($_SESSION['auth_step']) ? $_SESSION['auth_step'] : 1; 

// -------------------- 3. EMAIL FUNCTION --------------------

function send_otp_email($otp) {
    $to = ADMIN_EMAIL;
    $subject = "Security Code: " . $otp . " - AsiaTech Admin";
    
    $message = "
    <html>
    <head><title>Admin Login</title></head>
    <body style='font-family:-apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, Helvetica, Arial, sans-serif; color:#333; line-height:1.6;'>
      <div style='border:1px solid #eee; padding:30px; border-radius:12px; max-width:500px; margin:20px auto; background:#fff; box-shadow:0 4px 10px rgba(0,0,0,0.05);'>
        <h2 style='color:#111; margin-top:0; font-size:24px; text-align:center;'>Verify Your Login</h2>
        <p style='color:#666; text-align:center;'>A login attempt requires verification. Please enter the following code:</p>
        <div style='background:#f8f9fa; padding:20px; text-align:center; font-size:32px; font-weight:700; letter-spacing:8px; border-radius:8px; margin:30px 0; color:#ff3333; border:1px dashed #ddd;'>
            $otp
        </div>
        <p style='font-size:13px; color:#999; text-align:center;'>This code expires in 5 minutes. If you did not attempt to log in, please ignore this email.</p>
      </div>
    </body>
    </html>
    ";

    $headers  = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
    $headers .= "From: AsiaTech Security <" . SENDER_EMAIL . ">" . "\r\n";
    $headers .= "Reply-To: " . SENDER_EMAIL . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    if(mail($to, $subject, $message, $headers, "-f".SENDER_EMAIL)) {
        return true;
    } else {
        error_log("Hostinger Mail Failed for: " . ADMIN_EMAIL);
        return false;
    }
}

// -------------------- 4. LOGIC HANDLER --------------------
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Check CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Session Expired. Refresh page.");
    }

    // === ACTION: VERIFY CREDENTIALS (STEP 1) ===
    if (isset($_POST['action']) && $_POST['action'] === 'verify_credentials') {
        
        $recaptcha_response = $_POST['g-recaptcha-response'];
        $verify = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.RECAPTCHA_SECRET_KEY.'&response='.$recaptcha_response);
        $captcha_data = json_decode($verify);

        if (!$captcha_data->success) {
            $error = "Please complete the CAPTCHA check.";
        } else {
            $username = trim($_POST['username']);
            $password = $_POST['password'];

            $stmt = $conn->prepare("SELECT id, password FROM admins WHERE username = ?");
            if ($stmt) {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $stmt->store_result();
                
                if ($stmt->num_rows === 1) {
                    $stmt->bind_result($uid, $hash);
                    $stmt->fetch();
                    
                    if (password_verify($password, $hash)) {
                        $otp = rand(100000, 999999);
                        $expiry = date("Y-m-d H:i:s", strtotime("+5 minutes"));
                        
                        $upd = $conn->prepare("UPDATE admins SET otp_code = ?, otp_expiry = ? WHERE id = ?");
                        $upd->bind_param("ssi", $otp, $expiry, $uid);
                        
                        if ($upd->execute()) {
                            if(send_otp_email($otp)) {
                                $_SESSION['auth_step'] = 2;
                                $_SESSION['temp_uid'] = $uid;
                                $step = 2;
                            } else {
                                $error = "Error sending email. Check logs.";
                            }
                        } else {
                            $error = "Database Error: Could not generate OTP.";
                        }
                    } else { 
                        $error = "Invalid credentials."; 
                        usleep(500000); 
                    }
                } else { 
                    $error = "Invalid credentials."; 
                    usleep(500000); 
                }
            }
        }
    }

    // === ACTION: VERIFY OTP (STEP 2) ===
    if (isset($_POST['action']) && $_POST['action'] === 'verify_otp') {
        $entered_otp = trim($_POST['otp_code']);
        $uid = $_SESSION['temp_uid'];
        
        $stmt = $conn->prepare("SELECT otp_code, otp_expiry FROM admins WHERE id = ?");
        $stmt->bind_param("i", $uid);
        $stmt->execute();
        $res = $stmt->get_result();
        
        if ($row = $res->fetch_assoc()) {
            if ($row['otp_code'] == $entered_otp) {
                if (strtotime($row['otp_expiry']) > time()) {
                    session_regenerate_id(true);
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_id'] = $uid;
                    
                    unset($_SESSION['auth_step']);
                    unset($_SESSION['temp_uid']);
                    $conn->query("UPDATE admins SET otp_code = NULL WHERE id = $uid");
                    
                    header("Location: dashboard.php");
                    exit;
                } else {
                    $error = "Code has expired. Please login again.";
                }
            } else {
                $error = "Invalid code. Please try again.";
            }
        }
    }
}

// Reset Logic
if (isset($_GET['reset'])) {
    unset($_SESSION['auth_step']);
    unset($_SESSION['temp_uid']);
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | AsiaTech</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #ff3333;
            --bg-dark: #0a0a0a;
            --card-bg: #111111;
            --border-color: #222;
            --text-light: #ffffff;
            --text-muted: #888;
            --border-radius: 12px;
            --font-sans: 'Inter', sans-serif;
        }

        body { 
            background: var(--bg-dark);
            color: var(--text-light); 
            font-family: var(--font-sans); 
            display: flex; 
            flex-direction: column;
            min-height: 100vh; 
            align-items: center; 
            justify-content: center; 
            margin: 0;
            /* Subtle background texture instead of sci-fi grid */
            background-image: radial-gradient(circle at top center, #1a1a1a 0%, #0a0a0a 70%);
        }

        .login-card { 
            background: var(--card-bg); 
            padding: 45px 40px; 
            width: 100%; 
            max-width: 400px; 
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        }
        
        /* Header */
        .card-header { text-align: center; margin-bottom: 35px; }
        .card-title { 
            margin: 0; font-size: 1.8rem; font-weight: 700; color: white; letter-spacing: -0.5px;
        }
        .card-subtitle { color: var(--text-muted); font-size: 0.9rem; margin-top: 10px; }

        /* Forms */
        .form-group { margin-bottom: 25px; }
        
        label { 
            display: block; color: var(--text-muted); font-size: 0.85rem; 
            font-weight: 600; margin-bottom: 10px;
        }
        
        input { 
            width: 100%; padding: 14px 16px; background: #050505; border: 1px solid var(--border-color); 
            color: var(--text-light); border-radius: 8px; box-sizing: border-box; 
            font-family: var(--font-sans); font-size: 1rem; transition: 0.3s;
        }
        input:focus { border-color: var(--primary); outline: none; background: #080808; }
        
        /* OTP Specific Input Style */
        .otp-input { 
            font-size: 1.5rem; letter-spacing: 8px; text-align: center; font-weight: 700;
        }

        .btn-submit { 
            width: 100%; padding: 14px; background: var(--primary); color: white; border: none; 
            border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 1rem;
            transition: 0.2s;
        }
        .btn-submit:hover { background: #e60000; }
        
        .error-box { 
            background: rgba(255,51,51,0.1); color: var(--primary); padding: 14px; 
            text-align: center; margin-bottom: 25px; font-size: 0.9rem; border-radius: 8px; font-weight: 500;
        }
        
        .captcha-container { display: flex; justify-content: center; margin-bottom: 25px; }
        .g-recaptcha { transform: scale(0.9); transform-origin: 0 0; }

        /* Return Link */
        .return-link {
            margin-top: 30px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: 0.3s;
            display: flex; align-items: center; gap: 8px;
        }
        .return-link:hover { color: var(--primary); }
        .return-link::before { content: '←'; }

    </style>
</head>
<body>

    <div class="login-card">
        
        <?php if($step == 1): ?>
            <div class="card-header">
                <h2 class="card-title">Admin Login</h2>
                <p class="card-subtitle">Enter your credentials to continue.</p>
            </div>

            <?php if($error): ?><div class="error-box"><?= $error ?></div><?php endif; ?>

            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="hidden" name="action" value="verify_credentials">

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" required autocomplete="username" placeholder="Enter your username">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                </div>

                <div class="captcha-container">
                    <div class="g-recaptcha" data-theme="dark" data-sitekey="<?= RECAPTCHA_SITE_KEY ?>"></div>
                </div>

                <button type="submit" class="btn-submit">Log In</button>
            </form>

        <?php else: ?>
            <div class="card-header">
                <h2 class="card-title">Two-Factor Authentication</h2>
                <p class="card-subtitle">
                    We sent a 6-digit code to your email: <br>
                    <span style="color:white; font-weight:600;"><?= htmlspecialchars(substr(ADMIN_EMAIL, 0, 3) . '***@' . explode('@', ADMIN_EMAIL)[1]) ?></span>
                </p>
            </div>

            <?php if($error): ?><div class="error-box"><?= $error ?></div><?php endif; ?>

            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="hidden" name="action" value="verify_otp">

                <div class="form-group">
                    <input type="text" name="otp_code" class="otp-input" maxlength="6" placeholder="000000" autofocus autocomplete="one-time-code">
                </div>

                <button type="submit" class="btn-submit">Verify Code</button>
                
                <div style="text-align: center; margin-top: 20px;">
                    <a href="?reset=1" style="color: var(--text-muted); font-size: 0.9rem; text-decoration: none;">I didn't receive the code</a>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <a href="../index.php" class="return-link">Back to Website</a>

</body>
</html>
