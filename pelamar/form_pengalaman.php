<?php
// Pelamar: form_pengalaman.php
require '../includes/auth.php';

if (!isset($_SESSION['form']['pengalaman'])) {
    $_SESSION['form']['pengalaman'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pengalaman = [
        'nama_perusahaan' => $_POST['nama_perusahaan'],
        'posisi' => $_POST['posisi'],
        'tanggal_mulai' => $_POST['tanggal_mulai'],
        'tanggal_selesai' => $_POST['tanggal_selesai'],
        'deskripsi' => $_POST['deskripsi']
    ];
    $_SESSION['form']['pengalaman'][] = $pengalaman;
    if (isset($_POST['selesai'])) {
        header("Location: form_berkas.php");
    } else {
        header("Location: form_pengalaman.php");
    }
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Langkah 3: Pengalaman Kerja</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h4>Langkah 3 dari 5: Pengalaman Kerja</h4>
    <form method="POST">
        <div class="mb-3">
            <label>Nama Perusahaan</label>
            <input type="text" name="nama_perusahaan" required class="form-control">
        </div>
        <div class="mb-3">
            <label>Posisi</label>
            <input type="text" name="posisi" required class="form-control">
        </div>
        <div class="mb-3">
            <label>Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" required class="form-control">
        </div>
        <div class="mb-3">
            <label>Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" required class="form-control">
        </div>
        <div class="mb-3">
            <label>Deskripsi Tugas</label>
            <textarea name="deskripsi" class="form-control" required></textarea>
        </div>
        <button type="submit" name="tambah" class="btn btn-secondary">Tambah Lagi</button>
        <button type="submit" name="selesai" class="btn btn-primary">Lanjut ke Upload Berkas</button>
    </form>

    <?php if (!empty($_SESSION['form']['pengalaman'])): ?>
        <h5 class="mt-4">Riwayat yang Ditambahkan:</h5>
        <ul class="list-group">
            <?php foreach ($_SESSION['form']['pengalaman'] as $i => $exp): ?>
                <li class="list-group-item">
                    <?= $exp['nama_perusahaan'] ?> - <?= $exp['posisi'] ?> (<?= $exp['tanggal_mulai'] ?> s/d <?= $exp['tanggal_selesai'] ?>)
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
</body>
</html>