<?php
require __DIR__ . '/auth.php';
if (!empty($_SESSION['admin'])) { header('Location: dashboard.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $user = trim($_POST['username'] ?? '');
    $pass = (string)($_POST['password'] ?? '');
    $stmt = $conn->prepare('SELECT username, password FROM admin WHERE username = ? LIMIT 1');
    $stmt->bind_param('s', $user);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    // Mendukung hash baru (password_hash) dan hash lama (md5) dari versi sebelumnya.
    $ok = $row && (password_verify($pass, $row['password']) || hash_equals($row['password'], md5($pass)));
    if ($ok) {
        session_regenerate_id(true);
        $_SESSION['admin'] = $row['username'];
        header('Location: dashboard.php');
        exit;
    }
    $error = 'Username atau password salah.';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk Admin | Yamazaki Hospital</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body class="admin-login">
    <main class="login-card">
        <a href="../index.html"><img src="../images/logo.png" alt="Yamazaki Hospital" class="login-logo"></a>
        <h1>Masuk Admin</h1>
        <p class="text-muted">Kelola janji temu dan pesan dari pasien.</p>
        <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
        <form method="POST" autocomplete="off">
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <div class="form-group">
                <label for="username">Username</label>
                <input id="username" type="text" name="username" class="form-control" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-brand btn-block">Masuk</button>
        </form>
        <a class="back" href="../index.html">← Kembali ke situs</a>
    </main>
</body>
</html>
