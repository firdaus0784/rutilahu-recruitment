<?php
session_start();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama   = trim($_POST['nama']);
    $email  = trim($_POST['email']);
    $pass   = $_POST['password'];
    $hash   = password_hash($pass, PASSWORD_DEFAULT);

    $cek = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $cek->bind_param("s", $email);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        $error = "Email sudah digunakan.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, 'pelamar')");
        $stmt->bind_param("sss", $nama, $email, $hash);
        if ($stmt->execute()) {
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['role'] = 'pelamar';
            header("Location: pelamar/dashboard.php");
            exit;
        } else {
            $error = "Gagal menyimpan akun.";
        }
    }
}
?>
<!-- HTML -->
<!DOCTYPE html>
<html>
<head>
    <title>Registrasi Akun</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Registrasi Akun Pelamar</h3>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="POST">
        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" required class="form-control">
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" required class="form-control">
        </div>
        <div class="mb-3">
            <label>Kata Sandi</label>
            <input type="password" name="password" required class="form-control">
        </div>
        <button class="btn btn-success">Daftar</button>
        <a href="login.php" class="btn btn-link">Sudah punya akun?</a>
    </form>
</div>
</body>
</html>
