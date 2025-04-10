<?php
require '../includes/auth.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['form']['berkas'] = $_FILES;
    header("Location: form_pernyataan.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Langkah 4: Upload Berkas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h4>Langkah 4 dari 5: Unggah Berkas</h4>
    <form method="POST" enctype="multipart/form-data">
        <?php
        $berkas_wajib = ['ktp' => 'KTP', 'cv' => 'CV', 'ijazah' => 'Ijazah', 'transkrip' => 'Transkrip Nilai', 'foto' => 'Pas Foto'];
        foreach ($berkas_wajib as $name => $label):
        ?>
        <div class="mb-3">
            <label><?= $label ?> (PDF)</label>
            <input type="file" name="<?= $name ?>" accept=".pdf" required class="form-control">
        </div>
        <?php endforeach; ?>
        <button type="submit" class="btn btn-primary">Lanjut ke Pernyataan</button>
    </form>
</div>
</body>
</html>
