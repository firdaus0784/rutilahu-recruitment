<?php
require '../includes/auth.php';
require '../includes/db.php';

$user_id = $_SESSION['user_id'];

// Cek status pendaftaran
$cek = $conn->prepare("SELECT status FROM pengaturan WHERE status = 'dibuka' LIMIT 1");
$cek->execute();
$res = $cek->get_result();
$pendaftaran_terbuka = $res->num_rows > 0;

// Ambil data pendaftaran pelamar
$stmt = $conn->prepare("SELECT * FROM pendaftaran WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

// Jika belum pernah mendaftar, redirect ke form
if (!$data) {
    header("Location: form_biodata.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Pelamar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3>Halo, <?= htmlspecialchars($data['nama_lengkap']) ?></h3>

    <div class="card mt-4">
        <div class="card-header bg-success text-white">Status Lamaran</div>
        <div class="card-body">
            <p><strong>Status Berkas:</strong> <?= $data['status_berkas'] ?></p>
            <p><strong>Pendidikan Terakhir:</strong> <?= $data['pendidikan_terakhir'] ?></p>
            <a href="preview_lamaran.php?id=<?= $data['id'] ?>" class="btn btn-outline-primary btn-sm">Lihat Lamaran</a>
            <?php if ($pendaftaran_terbuka): ?>
                <a href="form_biodata.php?edit=1" class="btn btn-warning btn-sm">Perbaiki Lamaran</a>
            <?php endif; ?>
        </div>
    </div>

    <a href="../logout.php" class="btn btn-link mt-4">Logout</a>
</div>
</body>
</html>
