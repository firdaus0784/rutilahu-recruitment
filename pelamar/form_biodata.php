<?php
require '../includes/auth.php';
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['form']['nama_lengkap'] = $_POST['nama_lengkap'];
    $_SESSION['form']['tempat_lahir'] = $_POST['tempat_lahir'];
    $_SESSION['form']['tanggal_lahir'] = $_POST['tanggal_lahir'];
    $_SESSION['form']['jenis_kelamin'] = $_POST['jenis_kelamin'];
    $_SESSION['form']['alamat'] = $_POST['alamat'];
    header("Location: form_pendidikan.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Biodata Pelamar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h4>Langkah 1 dari 5: Biodata Diri</h4>
    <form method="POST">
        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" required class="form-control" value="<?= $_SESSION['form']['nama_lengkap'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir" required class="form-control" value="<?= $_SESSION['form']['tempat_lahir'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" required class="form-control" value="<?= $_SESSION['form']['tanggal_lahir'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" required>
                <option value="">-- Pilih --</option>
                <option value="L" <?= ($_SESSION['form']['jenis_kelamin'] ?? '') == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                <option value="P" <?= ($_SESSION['form']['jenis_kelamin'] ?? '') == 'P' ? 'selected' : '' ?>>Perempuan</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Alamat Domisili</label>
            <textarea name="alamat" class="form-control" required><?= $_SESSION['form']['alamat'] ?? '' ?></textarea>
        </div>
        <button class="btn btn-primary">Lanjut ke Pendidikan</button>
    </form>
</div>
</body>
</html>
