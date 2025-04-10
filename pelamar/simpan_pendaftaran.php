<?php
require '../includes/auth.php';
require '../includes/db.php';

$form = $_SESSION['form'] ?? null;
$user_id = $_SESSION['user_id'];

if (!$form || !$user_id) {
    die("Data tidak lengkap.");
}

// 1. Simpan ke tabel pendaftaran
$stmt = $conn->prepare("INSERT INTO pendaftaran 
(user_id, nama_lengkap, tempat_lahir, tgl_lahir, jenis_kelamin, alamat, pendidikan_terakhir, ipk, tgl_daftar)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("issssssd",
    $user_id,
    $_SESSION['form']['nama_lengkap'],
    $_SESSION['form']['tempat_lahir'],
    $_SESSION['form']['tanggal_lahir'],
    $_SESSION['form']['jenis_kelamin'],
    $_SESSION['form']['alamat'],
    $form['pendidikan']['program_studi'],
    $form['pendidikan']['ipk']
);
$stmt->execute();
$pendaftaran_id = $stmt->insert_id;

// 2. Simpan pengalaman kerja
foreach ($form['pengalaman'] as $p) {
    $stmt = $conn->prepare("INSERT INTO pengalaman_kerja (pendaftaran_id, nama_perusahaan, jabatan, tahun_mulai, tahun_selesai, keterangan) 
    VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss",
        $pendaftaran_id,
        $p['nama_perusahaan'],
        $p['posisi'],
        $p['tanggal_mulai'],
        $p['tanggal_selesai'],
        $p['deskripsi']
    );
    $stmt->execute();
}

// 3. Simpan file berkas
$upload_dir = "../uploads/pendaftaran_" . $pendaftaran_id;
if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

$berkas_wajib = ['ktp', 'cv', 'ijazah', 'transkrip', 'foto'];
foreach ($berkas_wajib as $berkas) {
    $file = $_FILES[$berkas];
    if ($file['error'] === 0) {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $new_name = $berkas . '.' . $ext;
        $target = "$upload_dir/$new_name";
        move_uploaded_file($file['tmp_name'], $target);

        $stmt = $conn->prepare("INSERT INTO berkas (pendaftaran_id, jenis_berkas, file_path) VALUES (?, ?, ?)");
        $jenis = strtoupper($berkas);
        $path = "uploads/pendaftaran_$pendaftaran_id/$new_name";
        $stmt->bind_param("iss", $pendaftaran_id, $jenis, $path);
        $stmt->execute();
    }
}

// 4. Simpan pernyataan
$ttd = $form['pernyataan']['nama_ttd'];
$stmt = $conn->prepare("INSERT INTO pernyataan (pendaftaran_id, signed_name, tgl_persetujuan) VALUES (?, ?, NOW())");
$stmt->bind_param("is", $pendaftaran_id, $ttd);
$stmt->execute();

// Bersihkan session wizard
unset($_SESSION['form']);

echo "<script>alert('Pendaftaran berhasil disimpan.'); window.location.href='dashboard.php';</script>";
