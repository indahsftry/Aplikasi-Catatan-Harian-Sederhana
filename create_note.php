<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';

    if ($title && $content) {
        $stmt = $pdo->prepare("INSERT INTO notes (user_id, title, content, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$_SESSION['user_id'], $title, $content]);
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Judul dan isi catatan harus diisi.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Tambah Catatan Baru</title>
    <style>
        body {
            background:rgb(82, 108, 160);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0; padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background: white;
            padding: 2rem 2.5rem;
            border-radius: 12px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.12);
            width: 100%;
            max-width: 450px;
        }
        h2 {
            margin-bottom: 1.5rem;
            color: #4a90e2;
            text-align: center;
            font-weight: 700;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #333;
        }
        input[type="text"],
        textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
            resize: vertical;
        }
        input[type="text"]:focus,
        textarea:focus {
            border-color: #4a90e2;
            outline: none;
            box-shadow: 0 0 8px rgba(74,144,226,0.3);
        }
        button {
            background-color: #4a90e2;
            color: white;
            border: none;
            padding: 0.85rem 0;
            width: 100%;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 1.5rem;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #357ABD;
        }
        .error-message {
            color: #e74c3c;
            background-color:rgb(179, 159, 157);
            padding: 0.6rem 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            text-align: center;
            font-weight: 600;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color:rgb(55, 97, 160);
            text-decoration: none;
            font-weight: 600;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Tambah Catatan Baru</h2>

        <?php if (isset($error)): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="title">Judul:</label>
            <input type="text" id="title" name="title" required autofocus>

            <label for="content">Cuplikan Diary :</label>
            <textarea id="content" name="content" rows="6" required></textarea>

            <button type="submit">Submit</button>
        </form>

        <a href="dashboard.php" class="back-link">&larr; Back To Dashboard</a>
    </div>
</body>
</html>
