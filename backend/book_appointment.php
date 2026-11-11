<?php
require __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: ../index.html'); exit; }

$patient = field('patient_name', 100);
$doctor  = field('doctor_name', 100);
$dept    = field('department_name', 100);
$phone   = field('phone_number', 20);
$symptom = field('symptoms', 500);
$date    = field('appointment_date', 10);

if ($patient === '' || $doctor === '' || $dept === '' || $phone === '' || $symptom === '' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    result_page('Data belum lengkap', 'Mohon isi semua kolom dengan benar.', false);
}
if ($date < date('Y-m-d')) {
    result_page('Tanggal tidak valid', 'Tanggal kunjungan tidak boleh sebelum hari ini.', false);
}

$stmt = $conn->prepare('INSERT INTO appointments (patient_name, doctor_name, department_name, phone_number, symptoms, appointment_date) VALUES (?, ?, ?, ?, ?, ?)');
$stmt->bind_param('ssssss', $patient, $doctor, $dept, $phone, $symptom, $date);
if ($stmt->execute()) {
    result_page('Janji temu tercatat', "Terima kasih, $patient. Kami akan menghubungi $phone untuk konfirmasi jadwal.");
}
result_page('Gagal menyimpan', 'Terjadi kesalahan pada server. Silakan coba lagi.', false);
