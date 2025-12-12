# Geo-HRIS: Smart Payroll & Attendance System 💼

![Dashboard Banner](link_screenshot_dashboard_utama)
> **Sistem manajemen SDM modern dengan validasi absensi berbasis lokasi (Geo-tagging) dan kalkulasi gaji dinamis otomatis.**

## 🚧 The Challenge
Manajemen SDM manual seringkali:
1.  **Rawan Fraud:** Titip absen (Buddy punching).
2.  **Human Error:** Kesalahan hitung lembur dan potongan gaji yang fatal.
3.  **Inefisiensi:** Rekapitulasi bulanan yang memakan waktu berhari-hari.

## 💡 The Solution
Aplikasi ini mengotomatiskan siklus HR dari kehadiran hingga penggajian (Payroll) dalam satu alur kerja yang terintegrasi.

## 🔥 Key Features

### 1. Geo-Tagging Attendance 📍
* Absensi hanya bisa dilakukan jika karyawan berada dalam radius lokasi kantor (Geofencing/GPS Validation).
* Mencegah kecurangan "titip absen".

### 2. Dynamic Payroll Engine 💰
* **Kalkulasi Otomatis:** Gaji Pokok + Tunjangan (Transport/Makan) - Potongan (Telat/Alpha/BPJS).
* **Flexible Config:** Admin bisa mengatur variabel potongan per menit keterlambatan.

### 3. Automated Reporting 📄
* **Slip Gaji Digital (PDF):** Generate payslip otomatis yang bisa diunduh karyawan.
* **Attendance Recap:** Laporan kehadiran bulanan/tahunan siap cetak.

### 4. Role-Based Access Control (RBAC) 🛡️
* **Admin:** Full akses pengaturan & approval.
* **Employee:** Absen, lihat riwayat, unduh slip gaji.

## 🛠 Tech Stack
*(SESUAIKAN DENGAN KODEMU YANG SEBENARNYA! JANGAN SALAH LAGI)*
* **Backend:** [PHP Native / Laravel / CodeIgniter / Node.js?]
* **Database:** [MySQL / PostgreSQL]
* **Frontend:** [Bootstrap / Tailwind / React]
* **PDF Engine:** [DomPDF / FPDF / jsPDF]
* **Maps API:** [Leaflet.js / Google Maps API]

## 📸 System Previews

### Attendance Flow (GPS Check)
![Attendance Screenshot](link_screenshot_halaman_absen_dengan_peta)

### Generated Payslip (Slip Gaji)
![Payslip Screenshot](link_screenshot_pdf_slip_gaji)
*(Ini "Money Shot"-nya. Tunjukkan bahwa sistemmu bisa bikin dokumen rapi).*

## 🚀 Installation

1.  Clone repo
2.  Import database `database.sql`
3.  Konfigurasi `.env` atau `config.php`
4.  Login Admin (User: admin, Pass: 123)

---
**Disclaimer:** Project ini dibuat untuk tujuan edukasi/portofolio simulasi sistem enterprise.
