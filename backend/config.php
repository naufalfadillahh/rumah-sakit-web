<?php
// Koneksi database bersama. Ubah sesuai pengaturan XAMPP kamu.
$DB_HOST = getenv('DB_HOST') ?: 'localhost';
$DB_USER = getenv('DB_USER') ?: 'root';
$DB_PASS = getenv('DB_PASS') ?: '';
$DB_NAME = getenv('DB_NAME') ?: 'hospital_db';

mysqli_report(MYSQLI_REPORT_OFF);
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_error) {
    http_response_code(500);
    exit('Database tidak dapat dihubungi. Pastikan MySQL berjalan dan database hospital_db sudah dibuat (lihat database/schema.sql).');
}
$conn->set_charset('utf8mb4');

function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

function field($name, $max = 255) {
    $v = trim((string)($_POST[$name] ?? ''));
    return mb_substr($v, 0, $max);
}

// Halaman hasil sederhana agar pengunjung tidak melihat teks polos.
function result_page($title, $message, $ok = true) {
    $color = $ok ? '#00c6a9' : '#dc3545';
    echo '<!DOCTYPE html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">'
       . '<title>' . e($title) . ' | Yamazaki Hospital</title><link rel="stylesheet" href="../css/bootstrap.css"></head>'
       . '<body style="min-height:100vh;display:grid;place-items:center;background:#f4f7fa;font-family:Roboto,Arial,sans-serif">'
       . '<div style="max-width:440px;background:#fff;padding:32px;border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,.08);text-align:center">'
       . '<h2 style="color:' . $color . '">' . e($title) . '</h2><p>' . e($message) . '</p>'
       . '<a class="btn" style="background:#00c6a9;color:#fff" href="../index.html">Kembali ke beranda</a></div></body></html>';
    exit;
}
