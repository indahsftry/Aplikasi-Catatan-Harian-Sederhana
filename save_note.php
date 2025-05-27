<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../pages/index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $id = $_POST['id'] ?? null;

    if ($title && $content) {
        if ($id) {
            // Update catatan
            $stmt = $pdo->prepare("UPDATE notes SET title = ?, content = ?, updated_at = NOW() WHERE id = ? AND user_id = ?");
            $stmt->execute([$title, $content, $id, $_SESSION['user_id']]);
        } else {
            // Tambah catatan baru
            $stmt = $pdo->prepare("INSERT INTO notes (user_id, title, content) VALUES (?, ?, ?)");
            $stmt->execute([$_SESSION['user_id'], $title, $content]);
        }

        header('Location: ../pages/dashboard.php');
        exit;
    } else {
        echo "Judul dan isi catatan wajib diisi.";
    }
} else {
    header('Location: ../pages/dashboard.php');
    exit;
}
