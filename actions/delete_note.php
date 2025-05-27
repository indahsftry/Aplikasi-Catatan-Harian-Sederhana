<?php
session_start();
require '../config/db.php';  // Path ke db.php dari folder actions

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

// Cek apakah id catatan ada
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID catatan tidak ditemukan.");
}

$note_id = $_GET['id'];

// Hapus catatan hanya jika milik user yang login
$stmt = $pdo->prepare("DELETE FROM notes WHERE id = ? AND user_id = ?");
$stmt->execute([$note_id, $_SESSION['user_id']]);

// Redirect kembali ke dashboard
header('Location: ../dashboard.php');
exit;
?>
