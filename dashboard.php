<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM notes WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$notes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard - Catatan Harian</title>
    <style>
       
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            margin: 0;
            background: #f4f6f8;
            color: #333;
            min-height: 100vh;
        }
        .container {
            max-width: 900px;
            margin: 2rem auto;
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        header h2 {
            margin: 0;
            color: #4a90e2;
        }
        .logout {
            text-decoration: none;
            background-color: #e74c3c;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            transition: background-color 0.3s;
        }
        .logout:hover {
            background-color: #c0392b;
        }

        main h3 {
            margin-top: 0;
            margin-bottom: 1rem;
            color: #333;
            border-bottom: 2px solid #4a90e2;
            padding-bottom: 0.5rem;
            font-weight: 600;
        }
        .add-note {
            display: inline-block;
            margin-bottom: 1.5rem;
            padding: 0.5rem 1rem;
            background-color: #4a90e2;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        .add-note:hover {
            background-color: #357ABD;
        }

        .notes-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            grid-template-columns: repeat(auto-fill,minmax(280px,1fr));
            gap: 1.5rem;
        }
        .notes-list li {
            background: #f9f9f9;
            border-radius: 10px;
            padding: 1rem 1.2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .notes-list li strong {
            font-size: 1.1rem;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        .notes-list li p {
            flex-grow: 1;
            color: #555;
            white-space: pre-wrap;
            margin-bottom: 0.75rem;
        }
        .notes-list li small {
            color: #999;
            font-size: 0.85rem;
            margin-bottom: 0.8rem;
        }
        .btn-edit, .btn-delete {
            text-decoration: none;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 600;
            transition: background-color 0.3s;
            margin-right: 0.5rem;
            display: inline-block;
            cursor: pointer;
            user-select: none;
        }
        .btn-edit {
            background-color: #27ae60;
            color: white;
        }
        .btn-edit:hover {
            background-color: #1e8449;
        }
        .btn-delete {
            background-color: #e74c3c;
            color: white;
        }
        .btn-delete:hover {
            background-color: #c0392b;
        }
        /* Responsive */
        @media (max-width: 600px) {
            .notes-list {
                grid-template-columns: 1fr;
            }
            header {
                flex-direction: column;
                gap: 1rem;
            }
            .logout {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h2>Halo, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
            <a href="actions/logout.php" class="logout">Logout</a>
        </header>

        <main>
            <h3>Daftar Catatan</h3>
            <a href="create_note.php" class="add-note">+ Tambah Catatan Baru</a>

            <?php if (count($notes) > 0): ?>
                <ul class="notes-list">
                    <?php foreach ($notes as $note): ?>
                        <li>
                            <strong><?= htmlspecialchars($note['title']) ?></strong>
                            <p><?= nl2br(htmlspecialchars($note['content'])) ?></p>
                            <small>Dibuat: <?= date('d M Y, H:i', strtotime($note['created_at'])) ?></small>
                            <div>
                                <a href="view_note.php?id=<?= $note['id'] ?>" class="btn-view">👁 Lihat</a>
<a href="edit_note.php?id=<?= $note['id'] ?>" class="btn-edit">✏ Edit</a>
<a href="actions/delete_note.php?id=<?= $note['id'] ?>" class="btn-delete" onclick="return confirm('Yakin hapus catatan ini?')">🗑 Hapus</a>


                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Catatan Masih Kosong.</p>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>