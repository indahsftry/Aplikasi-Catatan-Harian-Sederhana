<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID catatan tidak ditemukan.");
}

$note_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';

    if (empty($title) || empty($content)) {
        $error = "Judul dan isi catatan tidak boleh kosong.";
    } else {
        $stmt = $pdo->prepare("UPDATE notes SET title = ?, content = ? WHERE id = ? AND user_id = ?");
        $stmt->execute([$title, $content, $note_id, $_SESSION['user_id']]);
        header('Location: dashboard.php');
        exit;
    }
}

$stmt = $pdo->prepare("SELECT * FROM notes WHERE id = ? AND user_id = ?");
$stmt->execute([$note_id, $_SESSION['user_id']]);
$note = $stmt->fetch();

if (!$note) {
    die("Catatan tidak ditemukan atau Anda tidak berhak mengaksesnya.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Catatan</title>
    <style>
        body {
            background: linear-gradient(to right, #74ebd5, #9face6);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .edit-container {
            background-color: #ffffffcc;
            padding: 2rem 2.5rem;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            margin-top: 1rem;
            font-weight: 600;
            color: #555;
        }
        input[type="text"],
        textarea {
            width: 100%;
            padding: 0.75rem;
            border-radius: 8px;
            border: 1px solid #ccc;
            margin-top: 0.5rem;
            resize: vertical;
            font-size: 15px;
        }
        button {
            margin-top: 1.5rem;
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 8px;
            background-color: #4a90e2;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #3b7dc4;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: #0066cc;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .error {
            color: #c0392b;
            background-color: #ffe0e0;
            padding: 0.75rem;
            border-radius: 6px;
            margin-top: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="edit-container">
        <h2>Edit Catatan</h2>

        <?php if (isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label>Judul:</label>
            <input type="text" name="title" value="<?= htmlspecialchars($note['title']) ?>" required>

            <label>Isi Catatan:</label>
            <textarea name="content" rows="8" required><?= htmlspecialchars($note['content']) ?></textarea>

            <button type="submit">💾 Simpan Perubahan</button>
        </form>

        <a href="dashboard.php" class="back-link">⬅ Kembali ke Dashboard</a>
    </div>
</body>
</html>
