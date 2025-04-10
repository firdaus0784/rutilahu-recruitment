<?php
// Pelamar: form_pendidikan.php
require '../includes/auth.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['form']['pendidikan'] = [
        'program_studi' => $_POST['program_studi'],
        'ipk' => $_POST['ipk']
    ];
    header("Location: form_pengalaman.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Langkah 2: Pendidikan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h4>Langkah 2 dari 5: Pendidikan Terakhir</h4>
    <form method="POST">
        <div class="mb-3">
            <label>Program Studi</label>
            <input type="text" name="program_studi" required class="form-control" value="<?= $_SESSION['form']['pendidikan']['program_studi'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label>IPK</label>
            <input type="number" step="0.01" max="4" min="0" name="ipk" required class="form-control" value="<?= $_SESSION['form']['pendidikan']['ipk'] ?? '' ?>">
        </div>
        <button type="submit" class="btn btn-primary">Lanjut ke Pengalaman</button>
    </form>
</div>
</body>
</html>
