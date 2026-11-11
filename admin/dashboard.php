<?php
require __DIR__ . '/auth.php';
require_admin();

$appointments = $conn->query('SELECT * FROM appointments ORDER BY created_at DESC')->fetch_all(MYSQLI_ASSOC);
$contacts = $conn->query('SELECT * FROM contacts ORDER BY created_at DESC')->fetch_all(MYSQLI_ASSOC);
$today = date('Y-m-d');
$upcoming = count(array_filter($appointments, fn($a) => $a['appointment_date'] >= $today));
$flash = $_SESSION['flash'] ?? ''; unset($_SESSION['flash']);
$token = csrf_token();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin | Yamazaki Hospital</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body class="admin">
<header class="admin-top">
    <a href="../index.html" class="brand"><img src="../images/logo.png" alt=""> Yamazaki Hospital · Admin</a>
    <div>
        <span class="who">Halo, <?= e($_SESSION['admin']) ?></span>
        <a href="logout.php" class="btn btn-outline-light btn-sm">Keluar</a>
    </div>
</header>
<main class="container py-4">
    <?php if ($flash): ?><div class="alert alert-success"><?= e($flash) ?></div><?php endif; ?>
    <div class="stats">
        <div class="stat"><b><?= count($appointments) ?></b><span>Total janji temu</span></div>
        <div class="stat"><b><?= $upcoming ?></b><span>Jadwal mendatang</span></div>
        <div class="stat"><b><?= count($contacts) ?></b><span>Pesan masuk</span></div>
    </div>

    <section class="panel" id="janji">
        <h2>Janji temu</h2>
        <?php if (!$appointments): ?><p class="empty">Belum ada janji temu.</p><?php else: ?>
        <div class="table-responsive"><table class="table">
            <thead><tr><th>Tanggal</th><th>Pasien</th><th>Dokter</th><th>Poli</th><th>Telepon</th><th>Keluhan</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($appointments as $a): ?>
                <tr class="<?= $a['appointment_date'] < $today ? 'past' : '' ?>">
                    <td><?= e(date('d M Y', strtotime($a['appointment_date']))) ?></td>
                    <td><?= e($a['patient_name']) ?></td>
                    <td><?= e($a['doctor_name']) ?></td>
                    <td><?= e($a['department_name']) ?></td>
                    <td><?= e($a['phone_number']) ?></td>
                    <td><?= e($a['symptoms']) ?></td>
                    <td><form method="POST" action="delete.php" onsubmit="return confirm('Hapus janji temu ini?')">
                        <input type="hidden" name="csrf" value="<?= e($token) ?>"><input type="hidden" name="type" value="appointment"><input type="hidden" name="id" value="<?= (int)$a['id'] ?>">
                        <button class="btn btn-sm btn-outline-danger">Hapus</button></form></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table></div>
        <?php endif; ?>
    </section>

    <section class="panel" id="pesan">
        <h2>Pesan masuk</h2>
        <?php if (!$contacts): ?><p class="empty">Belum ada pesan.</p><?php else: ?>
        <div class="table-responsive"><table class="table">
            <thead><tr><th>Waktu</th><th>Nama</th><th>Email</th><th>Telepon</th><th>Pesan</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($contacts as $c): ?>
                <tr>
                    <td><?= e(date('d M Y H:i', strtotime($c['created_at']))) ?></td>
                    <td><?= e($c['full_name']) ?></td>
                    <td><a href="mailto:<?= e($c['email']) ?>"><?= e($c['email']) ?></a></td>
                    <td><?= e($c['phone_number']) ?></td>
                    <td class="msg"><?= nl2br(e($c['message'])) ?></td>
                    <td><form method="POST" action="delete.php" onsubmit="return confirm('Hapus pesan ini?')">
                        <input type="hidden" name="csrf" value="<?= e($token) ?>"><input type="hidden" name="type" value="contact"><input type="hidden" name="id" value="<?= (int)$c['id'] ?>">
                        <button class="btn btn-sm btn-outline-danger">Hapus</button></form></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table></div>
        <?php endif; ?>
    </section>
</main>
</body>
</html>
