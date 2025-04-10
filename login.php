<?php
session_start();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $pass  = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id, $hashed, $role);
    if ($stmt->fetch()) {
        if (password_verify($pass, $hashed)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['role'] = $role;
            if ($role == 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: pelamar/dashboard.php");
            }
            exit;
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Akun tidak ditemukan.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Rekrutmen RUTILAHU</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Login Sistem Rekrutmen</h3>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="POST">
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" required class="form-control">
        </div>
        <div class="mb-3">
            <label>Kata Sandi</label>
            <input type="password" name="password" required class="form-control">
        </div>
        <button class="btn btn-primary">Masuk</button>
        <a href="register.php" class="btn btn-link">Belum punya akun?</a>
    </form>
</div>
</body>
</html>
