-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2025 at 03:56 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci4_absensi`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) UNSIGNED NOT NULL,
  `karyawan_id` int(5) UNSIGNED NOT NULL,
  `tgl_absen` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_pulang` time DEFAULT NULL,
  `foto_masuk` varchar(255) DEFAULT NULL,
  `foto_pulang` varchar(255) DEFAULT NULL,
  `lokasi_masuk` varchar(255) DEFAULT NULL,
  `lokasi_pulang` varchar(255) DEFAULT NULL,
  `status` enum('Hadir','Sakit','Izin','Cuti','Alpha') NOT NULL DEFAULT 'Alpha',
  `keterangan` text DEFAULT NULL,
  `dokumen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `karyawan_id`, `tgl_absen`, `jam_masuk`, `jam_pulang`, `foto_masuk`, `foto_pulang`, `lokasi_masuk`, `lokasi_pulang`, `status`, `keterangan`, `dokumen`) VALUES
(1, 1, '2025-07-09', NULL, NULL, NULL, NULL, NULL, NULL, 'Cuti', 'Cuti Disetujui: capek pengen turu', NULL),
(2, 1, '2025-07-10', NULL, NULL, NULL, NULL, NULL, NULL, 'Cuti', 'Cuti Disetujui: capek pengen turu', NULL),
(3, 1, '2025-07-11', NULL, NULL, NULL, NULL, NULL, NULL, 'Cuti', 'Cuti Disetujui: capek pengen turu', NULL),
(4, 1, '2025-07-14', NULL, NULL, NULL, NULL, NULL, NULL, 'Cuti', 'Cuti Disetujui: capek pengen turu', NULL),
(5, 1, '2025-07-15', NULL, NULL, NULL, NULL, NULL, NULL, 'Cuti', 'Cuti Disetujui: capek pengen turu', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cuti`
--

CREATE TABLE `cuti` (
  `id` int(11) UNSIGNED NOT NULL,
  `karyawan_id` int(5) UNSIGNED NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `jumlah_hari` int(3) NOT NULL,
  `keterangan` text NOT NULL,
  `status` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cuti`
--

INSERT INTO `cuti` (`id`, `karyawan_id`, `tanggal_mulai`, `tanggal_selesai`, `jumlah_hari`, `keterangan`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-07-09', '2025-07-15', 5, 'capek pengen turu', 'Approved', '2025-07-07 00:31:46', '2025-07-07 00:32:16');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id` int(5) UNSIGNED NOT NULL,
  `nama_jabatan` varchar(100) NOT NULL,
  `gaji_pokok` decimal(10,2) UNSIGNED NOT NULL,
  `tunjangan_jabatan` decimal(10,2) DEFAULT 0.00,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id`, `nama_jabatan`, `gaji_pokok`, `tunjangan_jabatan`, `created_at`, `updated_at`) VALUES
(1, 'HRD', 9000000.00, 3231231.00, '2025-07-07 00:29:33', '2025-07-25 04:27:34');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id` int(5) UNSIGNED NOT NULL,
  `user_id` int(5) UNSIGNED NOT NULL,
  `jabatan_id` int(5) UNSIGNED NOT NULL,
  `nik` varchar(50) NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `alamat` text DEFAULT NULL,
  `jatah_cuti` int(5) UNSIGNED DEFAULT 12,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id`, `user_id`, `jabatan_id`, `nik`, `nama_lengkap`, `no_telepon`, `alamat`, `jatah_cuti`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '0987654321654321', 'Dzaki', '085269617993', 'Dago', 7, '2025-07-07 00:30:02', '2025-07-07 00:32:16');

-- --------------------------------------------------------

--
-- Table structure for table `lembur`
--

CREATE TABLE `lembur` (
  `id` int(11) UNSIGNED NOT NULL,
  `karyawan_id` int(5) UNSIGNED NOT NULL,
  `tanggal_lembur` date NOT NULL,
  `jumlah_jam` int(3) NOT NULL,
  `upah_per_jam_saat_pengajuan` decimal(10,2) NOT NULL,
  `total_upah_lembur` decimal(10,2) NOT NULL,
  `keterangan` text NOT NULL,
  `status` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lembur`
--

INSERT INTO `lembur` (`id`, `karyawan_id`, `tanggal_lembur`, `jumlah_jam`, `upah_per_jam_saat_pengajuan`, `total_upah_lembur`, `keterangan`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-07-26', 4, 30000.00, 120000.00, 'tugas membludak', 'Approved', '2025-07-25 04:34:54', '2025-07-25 05:05:49');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2023-07-04-185800', 'App\\Database\\Migrations\\BuatTabelUsers', 'default', 'App', 1751822621, 1),
(2, '2023-07-04-185900', 'App\\Database\\Migrations\\BuatTabelJabatan', 'default', 'App', 1751822621, 1),
(3, '2023-07-04-190000', 'App\\Database\\Migrations\\BuatTabelKaryawan', 'default', 'App', 1751822621, 1),
(4, '2023-07-04-190100', 'App\\Database\\Migrations\\BuatTabelAbsensi', 'default', 'App', 1751822699, 2),
(5, '2023-07-04-190400', 'App\\Database\\Migrations\\BuatTabelPayroll', 'default', 'App', 1751822699, 2),
(6, '2023-07-04-190500', 'App\\Database\\Migrations\\BuatTabelPengaturan', 'default', 'App', 1751822699, 2),
(7, '2025-07-04-111917', 'App\\Database\\Migrations\\TambahJatahCuti', 'default', 'App', 1751822699, 2),
(8, '2025-07-04-111949', 'App\\Database\\Migrations\\BuatTabelCuti', 'default', 'App', 1751822699, 2),
(9, '2025-07-24-142656', 'App\\Database\\Migrations\\RombakFiturLemburDanTunjangan', 'default', 'App', 1753367312, 3);

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE `payroll` (
  `id` int(11) UNSIGNED NOT NULL,
  `karyawan_id` int(5) UNSIGNED NOT NULL,
  `bulan` int(2) NOT NULL,
  `tahun` int(4) NOT NULL,
  `gaji_pokok` decimal(10,2) NOT NULL,
  `total_hadir` int(2) NOT NULL,
  `total_sakit` int(2) NOT NULL,
  `total_izin` int(2) NOT NULL,
  `total_alpha` int(2) NOT NULL,
  `total_upah_lembur` decimal(10,2) NOT NULL DEFAULT 0.00,
  `potongan` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tunjangan` decimal(10,2) NOT NULL DEFAULT 0.00,
  `gaji_bersih` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `total_jam_lembur` decimal(6,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payroll`
--

INSERT INTO `payroll` (`id`, `karyawan_id`, `bulan`, `tahun`, `gaji_pokok`, `total_hadir`, `total_sakit`, `total_izin`, `total_alpha`, `total_upah_lembur`, `potongan`, `tunjangan`, `gaji_bersih`, `created_at`, `total_jam_lembur`) VALUES
(2, 1, 7, 2025, 9000000.00, 0, 0, 0, 18, 120000.00, 900000.00, 3231231.00, 11451231.00, NULL, 4.00);

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id` int(5) UNSIGNED NOT NULL,
  `nama_pengaturan` varchar(100) NOT NULL,
  `nilai_pengaturan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengaturan`
--

INSERT INTO `pengaturan` (`id`, `nama_pengaturan`, `nilai_pengaturan`) VALUES
(1, 'lokasi_kantor_lat', '-7.8612038'),
(2, 'lokasi_kantor_lon', '110.3973365'),
(3, 'radius_absensi', '100'),
(4, 'jam_masuk_mulai', '07:00:00'),
(5, 'jam_masuk_selesai', '08:00:00'),
(6, 'jam_pulang_mulai', '16:00:00'),
(7, 'potongan_alpha_per_hari', '50000'),
(8, 'upah_lembur_per_menit', '500'),
(9, 'upah_lembur_per_jam', '30000');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','karyawan') NOT NULL DEFAULT 'karyawan',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$TEmE0YStaaW4wGpfGLdxKO276VE0rt.R.JU7YQHljcPGtYgJrOFtq', 'admin', '2025-07-07 00:28:32', '2025-07-07 00:28:32'),
(2, 'dzaki', '$2y$10$C9X8mhRVRwIn7StUJT8dBuXCA8ERzQyICs0xAzzaFuC.GydyKJTSm', 'karyawan', '2025-07-07 00:30:02', '2025-07-07 00:37:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `absensi_karyawan_id_foreign` (`karyawan_id`);

--
-- Indexes for table `cuti`
--
ALTER TABLE `cuti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cuti_karyawan_id_foreign` (`karyawan_id`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD KEY `karyawan_user_id_foreign` (`user_id`),
  ADD KEY `karyawan_jabatan_id_foreign` (`jabatan_id`);

--
-- Indexes for table `lembur`
--
ALTER TABLE `lembur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lembur_karyawan_id_foreign` (`karyawan_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `karyawan_id_bulan_tahun` (`karyawan_id`,`bulan`,`tahun`);

--
-- Indexes for table `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_pengaturan` (`nama_pengaturan`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cuti`
--
ALTER TABLE `cuti`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lembur`
--
ALTER TABLE `lembur`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payroll`
--
ALTER TABLE `payroll`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cuti`
--
ALTER TABLE `cuti`
  ADD CONSTRAINT `cuti_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD CONSTRAINT `karyawan_jabatan_id_foreign` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatan` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `karyawan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lembur`
--
ALTER TABLE `lembur`
  ADD CONSTRAINT `lembur_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payroll`
--
ALTER TABLE `payroll`
  ADD CONSTRAINT `payroll_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
