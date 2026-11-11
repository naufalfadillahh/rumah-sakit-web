# Yamazaki Hospital (Website Rumah Sakit)

Website rumah sakit fiktif untuk proyek kuliah Pemrograman Web: beranda, layanan, dokter, testimoni, kontak, form janji temu, dan panel admin.

**Demo live (statis):** https://rumah-sakit-naufal.vercel.app

## Fitur

- Halaman Beranda, Tentang, Layanan, Dokter, Testimoni, dan Kontak yang responsif
- Form janji temu (pilih dokter dan poli, tanggal minimal hari ini) dan form kontak
- Panel admin: login, statistik, daftar janji temu dan pesan, hapus data
- Keamanan backend: prepared statement (anti SQL injection), escape output (anti XSS), token CSRF untuk aksi hapus, session yang diperbarui setelah login

Versi online di Vercel hanya menjalankan bagian statis. Form dan panel admin menampilkan penjelasan mode demo karena butuh PHP + MySQL.

## Menjalankan lengkap (XAMPP)

1. Salin folder ini ke `htdocs/`.
2. Import `database/schema.sql` lewat phpMyAdmin.
3. Buka `http://localhost/rumah-sakit-web/`. Panel admin ada di `admin/` (username `admin`, password `admin123`).

## Struktur

| Folder | Isi |
|---|---|
| `backend/` | Endpoint form publik (`book_appointment.php`, `submit_contact.php`, `get_doctors.php`) dan `config.php` |
| `admin/` | Panel admin (`index.php` login, `dashboard.php`, `delete.php`, `logout.php`) |
| `database/` | Struktur tabel dan data awal |

Template dasar dari html.design.
