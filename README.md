# Smart Payroll & HRIS System 💼

![CI4 Badge](https://img.shields.io/badge/Framework-CodeIgniter%204-fire) ![PHP Badge](https://img.shields.io/badge/Language-PHP%208.1-blue)

**Sistem Manajemen SDM Terintegrasi** yang dirancang untuk efisiensi. Aplikasi ini mengotomatiskan perhitungan gaji yang rumit (termasuk tunjangan, potongan, lembur) dan rekapitulasi kehadiran dalam satu dashboard terpusat.

## 🚀 Key Value
Sistem ini memecahkan masalah administrasi manual dengan fitur:
* **Zero-Error Calculation:** Menghilangkan kesalahan manusia dalam perhitungan gaji bulanan.
* **Automated Payslip:** Generate slip gaji digital siap cetak dalam hitungan detik.
* **Audit Trail:** Rekap data historis kehadiran dan penggajian yang transparan.

## ⚙️ Core Features

### 👥 Human Capital Management
* **Centralized Database:** Manajemen data karyawan (NIK, Jabatan, Status) yang terstruktur.
* **Role Management:** Hak akses berbeda untuk Admin dan User biasa.

### 📅 Smart Attendance
* Rekap kehadiran harian real-time (Hadir, Izin, Sakit, Alpha).
* Tracking jam masuk dan jam keluar untuk kalkulasi lembur.

### 💰 Payroll Engine (Penggajian)
Mesin hitung gaji otomatis yang mencakup:
* (+) Gaji Pokok & Tunjangan Jabatan
* (+) Uang Lembur (Overtime)
* (-) Potongan Kehadiran (Alpha/Telat)
* (=) **Take Home Pay Generator**

### 📊 Reporting
* **Cetak Slip Gaji (PDF/Print View).**
* Laporan rekapitulasi pengeluaran gaji bulanan untuk owner/manajer.

## 🧰 Tech Stack
* **Framework:** CodeIgniter 4 (MVC Architecture)
* **Language:** PHP 8.1+
* **Database:** MySQL / MariaDB
* **Frontend:** Bootstrap 5 (Responsive UI)
* **Server:** Apache / Nginx

## 💻 Installation Guide

**Prerequisites:**
* PHP 8.1 or higher
* Composer

1.  **Clone Repository**
    ```bash
    git clone [https://github.com/muhammaddz4ki/absensi-dan-payroll-karyawan.git](https://github.com/muhammaddz4ki/absensi-dan-payroll-karyawan.git)
    cd absensi-dan-payroll-karyawan
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    ```

3.  **Setup Environment**
    Salin file env dan konfigurasi database:
    ```bash
    cp env .env
    ```
    Buka file `.env` dan edit:
    ```env
    database.default.hostname = localhost
    database.default.database = nama_database_kamu
    database.default.username = root
    database.default.password = 
    CI_ENVIRONMENT = development
    ```

4.  **Database Migration**
    Import file SQL yang tersedia di folder `/database` ke phpMyAdmin.

5.  **Run Server**
    ```bash
    php spark serve
    ```
    Akses aplikasi di: `http://localhost:8080`

## 👨‍💻 Maintainer
**Muhammad Dzaki** - Industrial Informatics Engineer
* [Portfolio Website](https://muhammad-dzaki.vercel.app/)
