# Geo-HRIS: Smart Payroll & Attendance System 💼

![CI4 Badge](https://img.shields.io/badge/Framework-CodeIgniter%204-fire) ![Status](https://img.shields.io/badge/Status-Production%20Ready-success)

> **Sistem manajemen SDM berbasis lokasi (Geo-Fencing) yang mengintegrasikan absensi anti-fraud dengan perhitungan payroll otomatis.**

## 🚧 The Problem
Perusahaan konvensional sering mengalami kebocoran anggaran akibat:
1.  **Fake Attendance:** Karyawan titip absen tanpa hadir di lokasi.
2.  **Payroll Errors:** Kesalahan hitung manual untuk lembur dan potongan denda.
3.  **Admin Overload:** Rekapitulasi bulanan yang memakan waktu lama.

## 💡 The Solution
Aplikasi ini hadir sebagai solusi **Anti-Fraud** menggunakan validasi lokasi GPS dan kalkulasi gaji *real-time*.

## 🔥 Key Features

### 📍 1. Geo-Fencing Attendance (Fitur Unggulan)
* **Location Validation:** Absen hanya bisa dilakukan jika karyawan berada dalam radius kantor (Validasi Latitude/Longitude).
* **Map Visualization:** Menampilkan lokasi check-in karyawan via Google Maps/Leaflet.
* **Anti-Spoofing:** Mencegah manipulasi lokasi standar.

### 💰 2. Dynamic Payroll Engine
* **Auto-Calculation:** Gaji Pokok + Tunjangan - (Terlambat x Denda) - PPh21.
* **Payslip Generator:** Slip gaji digital otomatis yang transparan dan siap cetak (PDF).

### 👥 3. HR Management
* **Employee Database:** Manajemen data lengkap (NIK, Jabatan, Kontrak).
* **Shift & Overtime:** Pengaturan jam kerja dan perhitungan lembur otomatis.

### 📊 4. Reporting
* Laporan kehadiran bulanan & tahunan.
* Rekap pengeluaran gaji perusahaan (Expense Report).

## 🧰 Tech Stack
* **Framework:** CodeIgniter 4 (MVC)
* **Language:** PHP 8.1+
* **Database:** MySQL / MariaDB
* **Geolocation:** HTML5 Geolocation API & Leaflet.js
* **Frontend:** Bootstrap 5 (Responsive Mobile/Web)

## 🚀 Installation Guide

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
    ```bash
    cp env .env
    ```
    Edit file `.env`:
    ```env
    database.default.hostname = localhost
    database.default.database = db_payroll
    database.default.username = root
    database.default.password = 
    CI_ENVIRONMENT = development
    ```

4.  **Database Setup**
    * Buat database baru bernama `db_payroll`.
    * Import file SQL yang ada di folder `/database` ke phpMyAdmin.

5.  **Run Server**
    ```bash
    php spark serve
    ```
    Akses: `http://localhost:8080`

## 👨‍💻 Maintainer
**Muhammad Dzaki** - Industrial Informatics Engineer
* [Portfolio Website](https://muhammad-dzaki.vercel.app/)
