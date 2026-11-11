<?php
require __DIR__ . '/auth.php';
require_admin();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: dashboard.php'); exit; }
check_csrf();

$tables = ['appointment' => 'appointments', 'contact' => 'contacts'];
$type = $_POST['type'] ?? '';
$id = (int)($_POST['id'] ?? 0);
if (isset($tables[$type]) && $id > 0) {
    $stmt = $conn->prepare('DELETE FROM ' . $tables[$type] . ' WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $_SESSION['flash'] = $type === 'appointment' ? 'Janji temu dihapus.' : 'Pesan dihapus.';
}
header('Location: dashboard.php');
