# 🧾 Sistem Absensi dan Payroll Karyawan

## 📘 Deskripsi Proyek

Aplikasi **Absensi dan Payroll Karyawan** ini dibuat menggunakan **CodeIgniter 4**, bertujuan untuk membantu perusahaan dalam **mengelola data kehadiran (absensi)** dan **menghitung gaji karyawan (payroll)** secara otomatis, cepat, dan efisien.

Sistem ini cocok digunakan oleh perusahaan kecil hingga menengah yang ingin mempermudah proses administrasi karyawan tanpa perlu perhitungan manual.

## ⚙️ Fitur Utama

✅ **Manajemen Karyawan**  
- Tambah, ubah, dan hapus data karyawan.  
- Data lengkap mencakup NIK, jabatan, dan status kehadiran.

✅ **Absensi Karyawan**  
- Rekap kehadiran harian (masuk, izin, sakit, dan alfa).  
- Otomatis menyimpan data waktu masuk dan keluar.

✅ **Sistem Payroll (Penggajian)**  
- Hitung gaji otomatis berdasarkan data absensi dan komponen gaji.  
- Dukungan tunjangan, potongan, dan lembur.  
- Cetak slip gaji setiap karyawan.  

✅ **Laporan dan Dashboard Admin**  
- Laporan absensi dan penggajian dalam periode tertentu.  
- Statistik jumlah karyawan aktif dan total gaji bulanan.  

## 🧰 Teknologi yang Digunakan

| Komponen | Teknologi |
|-----------|------------|
| Framework | CodeIgniter 4 |
| Bahasa Pemrograman | PHP 8.1+ |
| Database | MySQL / MariaDB |
| Frontend | HTML, CSS, Bootstrap |
| Web Server | Apache / Nginx |
| Tools | Composer, Git |

## 🚀 Cara Menjalankan Proyek

1. **Clone repository ini:**
   git clone https://github.com/muhammaddz4ki/absensi-dan-payroll-karyawan.git
   
Masuk ke folder proyek:
cd absensi-dan-payroll-karyawan

Install dependensi:
composer install

Salin file .env:
cp env .env

Lalu sesuaikan konfigurasi database kamu di bagian:
database.default.hostname = localhost
database.default.database = nama_database
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
app.baseURL = 'http://localhost:8080/'

Jalankan server:
php spark serve

Akses di browser:
http://localhost:8080
👨‍💼 Tentang Pengembang
Dibuat oleh: Muhammad Dzaki
📍 Sistem ini dikembangkan untuk membantu perusahaan dalam digitalisasi proses absensi dan penggajian dengan antarmuka yang sederhana namun fungsional.
