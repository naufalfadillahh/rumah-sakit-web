<?php
session_start();
require __DIR__ . '/../backend/config.php';

function require_admin() {
    if (empty($_SESSION['admin'])) { header('Location: index.php'); exit; }
}
function csrf_token() {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(16));
    return $_SESSION['csrf'];
}
function check_csrf() {
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) { http_response_code(400); exit('Permintaan tidak valid.'); }
}
