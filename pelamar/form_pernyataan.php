<?php
require '../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['form']['pernyataan'] = [
        'setuju' => isset($_POST['setuju']),
        'nama_ttd' => $_POST['nama_ttd']
    ];
    header("Location: simpan_pendaftaran.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Langkah 5: Pernyataan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h4>Langkah 5 dari 5: Pernyataan & Finalisasi</h4>
    <form method="POST">
        <div class="alert alert-warning">
            Dengan ini saya menyatakan bahwa seluruh data dan dokumen yang saya isi adalah benar. Saya bersedia mengikuti seluruh proses rekrutmen dan tugas jika dinyatakan lulus.
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="setuju" required>
            <label class="form-check-label">Saya menyetujui pernyataan di atas</label>
        </div>
        <div class="mb-3">
            <label>Tanda Tangan (ketik nama lengkap)</label>
            <input type="text" name="nama_ttd" class="form-control" required>
        </div>
        <button class="btn btn-success" type="submit">Kirim dan Selesaikan</button>
    </form>
</div>
</body>
</html>
