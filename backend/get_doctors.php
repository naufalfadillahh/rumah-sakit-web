<?php
require __DIR__ . '/config.php';
header('Content-Type: application/json; charset=utf-8');
$result = $conn->query('SELECT id, name, specialty FROM doctors ORDER BY name');
echo json_encode($result ? $result->fetch_all(MYSQLI_ASSOC) : []);
