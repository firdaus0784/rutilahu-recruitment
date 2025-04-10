<?php
require '../includes/auth.php';
require '../includes/db.php';
session_start();

if ($_SESSION['role'] !== 'admin') die("Akses ditolak.");

$result = $conn->query("SELECT p.*, u.email FROM pendaftaran p JOIN users u ON p.user_id = u.id ORDER BY p.id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Dashboard Admin - Data Pendaftar</h3>
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Pendidikan</th>
                <th>Status Berkas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['nama_lengkap'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['pendidikan_terakhir'] ?></td>
                <td><?= $row['status_berkas'] ?></td>
                <td>
                    <a href="../pelamar/preview_lamaran.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">Lihat</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <a href="../logout.php" class="btn btn-link mt-3">Logout</a>
</div>
</body>
</html>
