<?php
require '../includes/auth.php';
require '../includes/db.php';

$id = $_GET['id'] ?? 0;

// Ambil data utama
$q = $conn->prepare("SELECT * FROM pendaftaran WHERE id = ?");
$q->bind_param("i", $id);
$q->execute();
$pendaftaran = $q->get_result()->fetch_assoc();

if (!$pendaftaran) die("Data tidak ditemukan.");

// Pengalaman kerja
$exp = $conn->query("SELECT * FROM pengalaman_kerja WHERE pendaftaran_id = $id");

// Berkas
$berkas = $conn->query("SELECT * FROM berkas WHERE pendaftaran_id = $id");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Preview Lamaran</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { padding: 30px; }
        .section { margin-bottom: 30px; }
    </style>
</head>
<body>
    <h3>Preview Lamaran</h3>
    <div class="section">
        <h5>Biodata</h5>
        <p><strong>Nama:</strong> <?= $pendaftaran['nama_lengkap'] ?></p>
        <p><strong>Tempat, Tanggal Lahir:</strong> <?= $pendaftaran['tempat_lahir'] ?>, <?= $pendaftaran['tgl_lahir'] ?></p>
        <p><strong>Jenis Kelamin:</strong> <?= $pendaftaran['jenis_kelamin'] ?></p>
        <p><strong>Alamat:</strong> <?= $pendaftaran['alamat'] ?></p>
    </div>

    <div class="section">
        <h5>Pendidikan</h5>
        <p><strong>Pendidikan Terakhir:</strong> <?= $pendaftaran['pendidikan_terakhir'] ?></p>
        <p><strong>IPK:</strong> <?= $pendaftaran['ipk'] ?></p>
    </div>

    <div class="section">
        <h5>Pengalaman Kerja</h5>
        <ul>
            <?php while ($p = $exp->fetch_assoc()): ?>
            <li>
                <?= $p['nama_perusahaan'] ?> - <?= $p['jabatan'] ?> (<?= $p['tahun_mulai'] ?> s/d <?= $p['tahun_selesai'] ?>)<br>
                <small><?= $p['keterangan'] ?></small>
            </li>
            <?php endwhile; ?>
        </ul>
    </div>

    <div class="section">
        <h5>Berkas Terunggah</h5>
        <ul>
            <?php while ($b = $berkas->fetch_assoc()): ?>
            <li><a href="../<?= $b['file_path'] ?>" target="_blank"><?= $b['jenis_berkas'] ?></a></li>
            <?php endwhile; ?>
        </ul>
    </div>

    <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
</body>
</html>
