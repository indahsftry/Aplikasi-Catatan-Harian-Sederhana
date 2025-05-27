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
    <title>Lihat Catatan</title>
    <style>
        body {
            background: linear-gradient(to right, #ffd3a5,rgb(33, 99, 221));
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .note-box {
            background-color: #fff;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(109, 15, 15, 0.15);
            width: 90%;
            max-width: 600px;
        }
        h2 {
            color: #444;
            margin-bottom: 1rem;
        }
        .content {
            white-space: pre-wrap;
            color: #333;
            line-height: 1.6;
            margin-bottom: 1rem;
        }
        .created {
            color: #888;
            font-size: 0.9em;
            margin-top: 1rem;
        }
        .back {
            display: inline-block;
            margin-top: 1.5rem;
            text-decoration: none;
            color:rgb(26, 131, 192);
            font-weight: bold;
        }
        .back:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="note-box">
        <h2><?= htmlspecialchars($note['title']) ?></h2>
        <div class="content"><?= nl2br(htmlspecialchars($note['content'])) ?></div>
        <div class="created">Dibuat pada: <?= $note['created_at'] ?></div>
        <a href="dashboard.php" class="back">⬅ Kembali ke Dashboard</a>
    </div>
</body>
</html>
