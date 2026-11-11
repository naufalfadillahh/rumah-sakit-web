-- Struktur database untuk menjalankan backend secara lokal (XAMPP / MySQL).
CREATE DATABASE IF NOT EXISTS hospital_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE hospital_db;

CREATE TABLE IF NOT EXISTS admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS appointments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  patient_name VARCHAR(100) NOT NULL,
  doctor_name VARCHAR(100) NOT NULL,
  department_name VARCHAR(100) NOT NULL,
  phone_number VARCHAR(20) NOT NULL,
  symptoms TEXT NOT NULL,
  appointment_date DATE NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS contacts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  phone_number VARCHAR(20) NOT NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS doctors (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  specialty VARCHAR(100) NOT NULL
);

-- Akun admin awal: username "admin", password "admin123" (ganti setelah login pertama).
INSERT IGNORE INTO admin (username, password) VALUES ('admin', MD5('admin123'));

INSERT INTO doctors (name, specialty) VALUES
  ('dr. Hana Prameswari', 'Spesialis Anak'),
  ('dr. Jessica Wibowo', 'Spesialis Mata'),
  ('dr. Marco Santoso', 'Spesialis Penyakit Dalam');
