<?php
session_start();
session_destroy();

session_start();
$_SESSION['message'] = 'Logout Successful.';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Logout - Catatan Harian</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .message-box {
            background: #d4edda;
            color:rgb(46, 119, 153);
            padding: 1.5rem 1rem;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
            font-size: 1.1rem;
        }
    </style>
    <script>
       
        setTimeout(() => {
            window.location.href = '../index.php';
        }, 1000);
    </script>
</head>
<body>
    <div class="message-box">
        Anda telah berhasil logout.<br/>
        Mengarahkan ke halaman login...
    </div>
</body>
</html>
