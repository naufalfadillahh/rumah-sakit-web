<?php
require __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: ../contact.html'); exit; }

$name    = field('full_name', 100);
$email   = field('email', 100);
$phone   = field('phone_number', 20);
$message = field('message', 1000);

if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $phone === '' || $message === '') {
    result_page('Data belum lengkap', 'Mohon isi nama, email yang valid, nomor telepon, dan pesan.', false);
}

$stmt = $conn->prepare('INSERT INTO contacts (full_name, email, phone_number, message) VALUES (?, ?, ?, ?)');
$stmt->bind_param('ssss', $name, $email, $phone, $message);
if ($stmt->execute()) {
    result_page('Pesan terkirim', 'Terima kasih sudah menghubungi kami. Tim kami akan membalas melalui email.');
}
result_page('Gagal mengirim', 'Terjadi kesalahan pada server. Silakan coba lagi.', false);
