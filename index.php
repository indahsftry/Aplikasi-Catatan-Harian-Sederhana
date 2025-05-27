<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'config/db.php';

// Flash message dari logout
if (isset($_SESSION['message'])) {
    $flash_message = $_SESSION['message'];
    unset($_SESSION['message']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && md5($password) === $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Oooou Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Login - Catatan Harian</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
        /* Reset dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        html, body {
            height: 100%;
            scroll-behavior: smooth;
        }

        body.login-page {
            background: linear-gradient(to right, #74ebd5, #9face6);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-wrapper {
            background-color: #ffffffcc;
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .flash-message {
            background-color: #d4edda;
            color: #155724;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            text-align: center;
            font-weight: 600;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .login-title {
            font-size: 24px;
            margin-bottom: 0.5rem;
            color: #333;
            text-align: center;
        }

        .login-subtitle {
            font-size: 14px;
            color: #666;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .input-group {
            position: relative;
        }

        .input-group input {
            width: 100%;
            padding: 0.75rem 2.5rem 0.75rem 2.5rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
            transition: 0.3s;
        }

        .input-group input:focus {
            border-color: #5e9ff2;
            box-shadow: 0 0 0 2px rgba(94, 159, 242, 0.3);
        }

        .input-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            user-select: none;
        }

        .login-button {
            padding: 0.75rem;
            background-color: #4a90e2;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .login-button:hover {
            background-color: #3b7dc4;
        }

        .error {
            background-color: #ffe0e0;
            color: #c0392b;
            padding: 0.5rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            text-align: center;
        }

        .footer-note {
            font-size: 13px;
            text-align: center;
            margin-top: 1.5rem;
            color: #555;
        }

        .footer-note a {
            color:rgb(27, 149, 201);
            text-decoration: none;
        }
        .footer-note a:hover {
            text-decoration: underline;
        }

        @media (max-width: 400px) {
            .login-wrapper {
                padding: 1.5rem;
                margin: 1rem;
            }
            .login-title {
                font-size: 20px;
            }
        }
    </style>
</head>
<body class="login-page">
    <div class="login-wrapper">

        <?php if (isset($flash_message)): ?>
            <div class="flash-message"><?= htmlspecialchars($flash_message) ?></div>
        <?php endif; ?>

        <div class="login-card">
            <h2 class="login-title">Welcome To Diary</h2>
            <p class="login-subtitle">Silakan login untuk melanjutkan</p>

            <?php if (isset($error)): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="input-group">
                    <span class="input-icon">👤</span>
                    <input type="text" name="username" placeholder="Username" required autofocus>
                </div>

                <div class="input-group">
                    <span class="input-icon">🔒</span>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <span class="toggle-password" onclick="togglePassword()">👁</span>
                </div>

                <button type="submit" class="login-button">Login</button>
            </form>

            <p class="footer-note">
                Belum punya akun? <a href="https://wa.me/6282288142243" target="_blank">Hubungi via WhatsApp</a>.
            </p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const toggle = document.querySelector('.toggle-password');
            if (input.type === 'password') {
                input.type = 'text';
                toggle.textContent = '🔓';
            } else {
                input.type = 'password';
                toggle.textContent = '👁';
            }
        }
    </script>
</body>
</html>