-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2021 at 01:30 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skripsi1`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_activation_attempts`
--

CREATE TABLE `auth_activation_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups`
--

CREATE TABLE `auth_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_groups`
--

INSERT INTO `auth_groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Admin adalah aktor yang mengelola akun, penjadwalan pendampingan ujian, dan segala konfirmasi pendampingan ujian'),
(2, 'madif', 'Mahasiswa Difabel adalah user yang membutuhkan pendampingan dalam melakukan ujian'),
(3, 'pendamping', 'Pendamping adalah user yang menjadi bagian dari mahasiswa, dan dapat melakukan pendampingan kepada madif');

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_permissions`
--

CREATE TABLE `auth_groups_permissions` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_groups_permissions`
--

INSERT INTO `auth_groups_permissions` (`group_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(2, 2),
(3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_users`
--

CREATE TABLE `auth_groups_users` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_groups_users`
--

INSERT INTO `auth_groups_users` (`group_id`, `user_id`) VALUES
(1, 5),
(2, 52),
(2, 55),
(2, 56),
(3, 53),
(3, 54);

-- --------------------------------------------------------

--
-- Table structure for table `auth_logins`
--

CREATE TABLE `auth_logins` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_logins`
--

INSERT INTO `auth_logins` (`id`, `ip_address`, `email`, `user_id`, `date`, `success`) VALUES
(1, '::1', 'aditkw43@gmail.com', 5, '2021-08-19 10:40:31', 1),
(2, '::1', 'aditkw43@gmail.com', 5, '2021-08-19 10:41:57', 1),
(3, '::1', 'aditkw43@gmail.com', 5, '2021-08-19 11:00:09', 1),
(4, '::1', 'aditkw15@student.ub.ac.id', 7, '2021-08-19 11:04:00', 1),
(5, '::1', 'aditkw15@student.ub.ac.id', 7, '2021-08-19 11:04:15', 1),
(6, '::1', 'aditkw43@gmail.com', NULL, '2021-08-19 11:04:38', 0),
(7, '::1', 'aditkw43@gmail.com', 5, '2021-08-19 11:04:49', 1),
(8, '::1', '175150400111017', NULL, '2021-08-19 11:19:19', 0),
(9, '::1', 'aditkw43@gmail.com', 5, '2021-08-19 11:19:25', 1),
(10, '::1', '1751504001110171', NULL, '2021-08-19 11:19:56', 0),
(11, '::1', '1751504001110171', NULL, '2021-08-19 11:20:14', 0),
(12, '::1', '1751504001110171', NULL, '2021-08-19 11:20:22', 0),
(13, '::1', 'aditkw15@student.ub.ac.id', 7, '2021-08-19 11:20:38', 1),
(14, '::1', '175150400111017', NULL, '2021-08-19 11:31:43', 0),
(15, '::1', 'aditkw43@gmail.com', 5, '2021-08-19 11:31:49', 1),
(16, '::1', '175150400111017', NULL, '2021-08-19 13:39:56', 0),
(17, '::1', 'aditkw15@student.ub.ac.id', 11, '2021-08-19 13:40:11', 1),
(18, '::1', 'summercrazyfrog12@gmail.com', 10, '2021-08-19 13:53:29', 1),
(19, '::1', 'aditkw43@gmail.com', 5, '2021-08-19 23:51:06', 1),
(20, '::1', 'aditkw15@student.ub.ac.id', 11, '2021-08-19 23:52:46', 1),
(21, '::1', 'summercrazyfrog12@gmail.com', 10, '2021-08-19 23:52:57', 1),
(22, '::1', 'aditkw43@gmail.com', 5, '2021-08-19 23:53:43', 1),
(23, '::1', 'aditkw15@student.ub.ac.id', 11, '2021-08-20 00:29:58', 1),
(24, '::1', 'summercrazyfrog12@gmail.com', 10, '2021-08-20 00:30:07', 1),
(25, '::1', 'aditkw15@student.ub.ac.id', 11, '2021-08-20 00:32:47', 1),
(26, '::1', 'summercrazyfrog12@gmail.com', 36, '2021-08-20 03:30:24', 1),
(27, '::1', 'aditkw15@student.ub.ac.id', 11, '2021-08-20 03:31:18', 1),
(28, '::1', 'aditkw15@student.ub.ac.id', 11, '2021-08-20 03:31:35', 1),
(29, '::1', 'aditkw43@gmail.com', 5, '2021-08-20 03:35:09', 1),
(30, '::1', 'summercrazyfrog12@gmail.com', 36, '2021-08-20 03:35:24', 1),
(31, '::1', 'aditkw15@student.ub.ac.id', 11, '2021-08-20 03:35:35', 1),
(32, '::1', 'summercrazyfrog12@gmail.com', 36, '2021-08-20 05:20:04', 1),
(33, '::1', 'aditkw15@student.ub.ac.id', 11, '2021-08-20 05:20:17', 1),
(34, '::1', 'aditkw15@student.ub.ac.id', 11, '2021-08-20 05:46:52', 1),
(35, '::1', 'aditkw15@student.ub.ac.id', 11, '2021-08-21 05:03:17', 1),
(36, '::1', 'aditkw15@student.ub.ac.id', 11, '2021-08-21 11:58:47', 1),
(37, '::1', 'summercrazyfrog12@gmail.com', 36, '2021-08-21 11:59:17', 1),
(38, '::1', '175150400111017', NULL, '2021-08-21 12:39:26', 0),
(39, '::1', 'aditkw43@gmail.com', 5, '2021-08-21 12:39:32', 1),
(40, '::1', 'summercrazyfrog12@gmail.com', 36, '2021-08-21 12:39:51', 1),
(41, '::1', 'summercrazyfrog12@gmail.com', 36, '2021-08-21 23:06:46', 1),
(42, '::1', 'aditkw15@student.ub.ac.id', 11, '2021-08-22 23:14:55', 1),
(43, '::1', 'summercrazyfrog12@gmail.com', 36, '2021-08-22 23:15:14', 1),
(44, '::1', 'summercrazyfrog12@gmail.com', 36, '2021-08-23 18:18:19', 1),
(45, '::1', 'aditkw15@student.ub.ac.id', 11, '2021-08-24 05:00:51', 1),
(46, '::1', 'aditkw15@student.ub.ac.id', 11, '2021-08-24 13:04:26', 1),
(47, '::1', '1751504001110174', NULL, '2021-08-24 13:49:50', 0),
(48, '::1', '1751504001110174', NULL, '2021-08-24 13:49:59', 0),
(49, '::1', '1751504001110174', NULL, '2021-08-24 13:50:09', 0),
(50, '::1', 'madif2@gmail.com', 37, '2021-08-24 13:50:36', 1),
(51, '::1', 'aditkw@yahoo.co.id', 42, '2021-08-25 00:37:52', 1),
(52, '::1', 'aditkw43@gmail.com', 5, '2021-08-25 10:54:39', 1),
(53, '::1', 'aditkw43@gmail.com', 5, '2021-08-26 00:57:37', 1),
(54, '::1', 'aditkw43@gmail.com', 5, '2021-08-26 03:08:30', 1),
(55, '::1', '1751504001110171', NULL, '2021-08-26 03:09:05', 0),
(56, '::1', 'aditkw@yahoo.co.id', 42, '2021-08-26 03:09:14', 1),
(57, '::1', 'aditkw43@gmail.com', 5, '2021-08-26 03:09:54', 1),
(58, '::1', 'aditkw43@gmail.com', 5, '2021-08-27 02:10:06', 1),
(59, '::1', '1751504001110173@gmail.com', 50, '2021-08-28 05:44:11', 1),
(60, '::1', 'aditkw43@gmail.com', 5, '2021-08-28 17:53:01', 1),
(61, '::1', 'aditkw@yahoo.co.id', 42, '2021-08-28 17:53:41', 1),
(62, '::1', '1751504001110172@gmail.com', 53, '2021-08-29 09:35:57', 1),
(63, '::1', '1751504001110171@gmail.com', 52, '2021-08-30 00:46:31', 1),
(64, '::1', '1751504001110172@gmail.com', 53, '2021-08-30 00:47:47', 1),
(65, '::1', '1751504001110171@gmail.com', 52, '2021-08-30 03:07:29', 1),
(66, '::1', '1751504001110171@gmail.com', 52, '2021-08-30 03:10:28', 1),
(67, '::1', '1751504001110172@gmail.com', 53, '2021-08-30 03:14:37', 1),
(68, '::1', '1751504001110171@gmail.com', 52, '2021-08-30 08:35:14', 1),
(69, '::1', '1751504001110171@gmail.com', 52, '2021-08-30 08:45:13', 1),
(70, '::1', 'aditkw43@gmail.com', 5, '2021-08-30 09:29:57', 1),
(71, '::1', '1751504001110171@gmail.com', 52, '2021-08-30 10:16:46', 1),
(72, '::1', '1751504001110172@gmail.com', 53, '2021-08-30 10:17:05', 1),
(73, '::1', 'aditkw43@gmail.com', 5, '2021-08-30 10:17:20', 1),
(74, '::1', '1751504001110171@gmail.com', 52, '2021-08-30 10:25:30', 1),
(75, '::1', 'aditkw43@gmail.com', 5, '2021-08-30 10:25:50', 1),
(76, '::1', '1751504001110171@gmail.com', 52, '2021-08-30 10:46:11', 1),
(77, '::1', '1751504001110172@gmail.com', 53, '2021-08-30 10:46:20', 1),
(78, '::1', '1751504001110171@gmail.com', 52, '2021-08-30 11:09:59', 1),
(79, '::1', 'aditkw43@gmail.com', 5, '2021-08-30 11:24:43', 1),
(80, '::1', '1751504001110171@gmail.com', 52, '2021-08-30 11:25:21', 1),
(81, '::1', '1751504001110172@gmail.com', 53, '2021-08-30 11:31:49', 1),
(82, '::1', 'aditkw43@gmail.com', 5, '2021-08-30 11:58:20', 1),
(83, '::1', '1751504001110171@gmail.com', 52, '2021-08-30 11:59:56', 1),
(84, '::1', 'aditkw43@gmail.com', 5, '2021-08-30 12:09:09', 1),
(85, '::1', '1751504001110171@gmail.com', 52, '2021-08-30 12:09:28', 1),
(86, '::1', '1751504001110172@gmail.com', 53, '2021-08-30 12:10:31', 1),
(87, '::1', 'aditkw43@gmail.com', 5, '2021-08-30 12:11:40', 1),
(88, '::1', '1751504001110171@gmail.com', 52, '2021-08-30 12:18:48', 1),
(89, '::1', '1751504001110172@gmail.com', 53, '2021-08-30 12:20:32', 1),
(90, '::1', 'aditkw43@gmail.com', 5, '2021-08-30 12:21:35', 1),
(91, '::1', 'aditkw43@gmail.com', 5, '2021-08-30 12:23:57', 1),
(92, '::1', '1751504001110171@gmail.com', 52, '2021-08-30 12:24:23', 1),
(93, '::1', '1751504001110172@gmail.com', 53, '2021-08-30 12:46:10', 1),
(94, '::1', '1751504001110171@gmail.com', 52, '2021-08-30 13:54:58', 1),
(95, '::1', '1751504001110172@gmail.com', 53, '2021-08-30 14:09:53', 1),
(96, '::1', '1751504001110171@gmail.com', 52, '2021-08-30 14:11:01', 1),
(97, '::1', 'aditkw43@gmail.com', 5, '2021-08-30 22:01:35', 1),
(98, '::1', '1751504001110172@gmail.com', 53, '2021-08-30 22:06:52', 1),
(99, '::1', '1751504001110172@gmail.com', 53, '2021-08-31 03:58:36', 1),
(100, '::1', 'aditkw43@gmail.com', 5, '2021-08-31 04:54:06', 1),
(101, '::1', '1751504001110171@gmail.com', 52, '2021-08-31 04:57:11', 1),
(102, '::1', 'aditkw43@gmail.com', 5, '2021-08-31 05:40:45', 1),
(103, '::1', '1751504001110171@gmail.com', 52, '2021-08-31 05:42:14', 1),
(104, '::1', '1751504001110172@gmail.com', 53, '2021-08-31 05:42:28', 1),
(105, '::1', '1751504001110171@gmail.com', 52, '2021-08-31 10:54:41', 1),
(106, '::1', 'aditkw43@gmail.com', 5, '2021-08-31 11:36:25', 1),
(107, '::1', '1751504001110172@gmail.com', 53, '2021-08-31 11:47:11', 1),
(108, '::1', '1751504001110171@gmail.com', 52, '2021-08-31 11:47:40', 1),
(109, '::1', '1751504001110171@gmail.com', 52, '2021-08-31 11:52:17', 1),
(110, '::1', 'aditkw43@gmail.com', 5, '2021-08-31 12:02:51', 1),
(111, '::1', '1751504001110172@gmail.com', 53, '2021-08-31 12:10:22', 1),
(112, '::1', 'aditkw43@gmail.com', 5, '2021-08-31 12:17:54', 1),
(113, '::1', '1751504001110172@gmail.com', 53, '2021-08-31 12:18:44', 1),
(114, '::1', '1751504001110171@gmail.com', 52, '2021-08-31 12:21:57', 1),
(115, '::1', 'aditkw43@gmail.com', 5, '2021-08-31 12:23:12', 1),
(116, '::1', '1751504001110171@gmail.com', 52, '2021-08-31 12:23:36', 1),
(117, '::1', 'aditkw43@gmail.com', 5, '2021-08-31 12:38:14', 1),
(118, '::1', '1751504001110171@gmail.com', 52, '2021-08-31 12:48:07', 1),
(119, '::1', '1751504001110172@gmail.com', 53, '2021-08-31 12:48:16', 1),
(120, '::1', '1751504001110171@gmail.com', 52, '2021-08-31 12:49:38', 1),
(121, '::1', '1751504001110173@gmail.com', 54, '2021-08-31 13:55:18', 1),
(122, '::1', 'aditkw43@gmail.com', 5, '2021-08-31 18:19:55', 1),
(123, '::1', '1751504001110171@gmail.com', 52, '2021-09-01 01:22:37', 1),
(124, '::1', 'aditkw43@gmail.com', 5, '2021-09-01 01:22:47', 1),
(125, '::1', '1751504001110174@gmail.com', 55, '2021-09-01 12:14:29', 1),
(126, '::1', 'aditkw43@gmail.com', 5, '2021-09-01 12:16:26', 1),
(127, '::1', '1751504001110175@gmail.com', 56, '2021-09-01 13:05:19', 1),
(128, '::1', 'aditkw43@gmail.com', 5, '2021-09-01 13:07:16', 1);

-- --------------------------------------------------------

--
-- Table structure for table `auth_permissions`
--

CREATE TABLE `auth_permissions` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_permissions`
--

INSERT INTO `auth_permissions` (`id`, `name`, `description`) VALUES
(1, 'kelola-akun', 'Dapat melakukan pengelolaan akun pada sistem penjadwalan pendampingan ujian'),
(2, 'kelola-profile', 'Dapat melakukan pengelolaan profile');

-- --------------------------------------------------------

--
-- Table structure for table `auth_reset_attempts`
--

CREATE TABLE `auth_reset_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_tokens`
--

CREATE TABLE `auth_tokens` (
  `id` int(11) UNSIGNED NOT NULL,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_users_permissions`
--

CREATE TABLE `auth_users_permissions` (
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `biodata`
--

CREATE TABLE `biodata` (
  `id_profile_admin` int(11) UNSIGNED DEFAULT NULL,
  `id_profile_mhs` int(11) UNSIGNED DEFAULT NULL,
  `nickname` varchar(25) DEFAULT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `jenis_kelamin` tinyint(1) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `nomor_hp` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `biodata`
--

INSERT INTO `biodata` (`id_profile_admin`, `id_profile_mhs`, `nickname`, `fullname`, `jenis_kelamin`, `alamat`, `nomor_hp`) VALUES
(NULL, 30, 'Kahfi', 'Aditya Kahfi Wicaksono', 1, 'jl. taman malaka barat blok E3 No.15', '085885683928'),
(2, NULL, 'Wicak', 'Wicaksono', 1, 'Jl. Sigura-gura VI, Lowokwaru, Malang', '085885683928'),
(NULL, 31, 'Aditya', 'Aditya Kahfiw', 1, 'Jl. Singosari VI', '085885683927'),
(NULL, 32, 'Hello', 'Hello Wicaksono', 0, 'Jl. Sigura-gura VI, Lowokwaru, Malang', '085885683928'),
(NULL, 33, 'Haryanto', 'Dani Haryanto', 1, 'Jl. Mayjend Pandjaitan', '085885683928'),
(NULL, 34, 'Putri', 'Putri Mangarea', 0, 'Jl. Sigura-gura VI, Lowokwaru, Malang', '085885683928');

-- --------------------------------------------------------

--
-- Table structure for table `cuti`
--

CREATE TABLE `cuti` (
  `id_cuti` int(10) UNSIGNED NOT NULL,
  `id_profile_mhs` int(10) UNSIGNED NOT NULL,
  `jenis_cuti` varchar(100) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `keterangan` text NOT NULL,
  `dokumen` varchar(100) DEFAULT NULL,
  `approval` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `damping_ujian`
--

CREATE TABLE `damping_ujian` (
  `id_damping` int(10) UNSIGNED NOT NULL,
  `id_jadwal_ujian_madif` int(10) UNSIGNED NOT NULL,
  `id_profile_madif` int(10) UNSIGNED NOT NULL,
  `id_profile_pendamping` int(10) UNSIGNED DEFAULT NULL,
  `jenis_ujian` varchar(50) NOT NULL,
  `status_damping` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `izin_tidak_damping`
--

CREATE TABLE `izin_tidak_damping` (
  `id_izin` int(11) UNSIGNED NOT NULL,
  `id_damping_ujian` int(11) UNSIGNED NOT NULL,
  `id_pendamping_lama` int(11) UNSIGNED NOT NULL,
  `id_pendamping_baru` int(11) UNSIGNED NOT NULL,
  `keterangan` text NOT NULL,
  `dokumen` varchar(100) DEFAULT NULL,
  `approval_pendamping_lama` tinyint(1) DEFAULT NULL,
  `approval` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_ujian`
--

CREATE TABLE `jadwal_ujian` (
  `id_jadwal_ujian` int(11) UNSIGNED NOT NULL,
  `id_profile_mhs` int(11) UNSIGNED NOT NULL,
  `mata_kuliah` varchar(100) NOT NULL,
  `tanggal_ujian` date NOT NULL,
  `waktu_mulai_ujian` time NOT NULL,
  `waktu_selesai_ujian` time NOT NULL,
  `ruangan` varchar(50) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `approval` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jadwal_ujian`
--

INSERT INTO `jadwal_ujian` (`id_jadwal_ujian`, `id_profile_mhs`, `mata_kuliah`, `tanggal_ujian`, `waktu_mulai_ujian`, `waktu_selesai_ujian`, `ruangan`, `keterangan`, `approval`, `created_at`, `updated_at`, `deleted_at`) VALUES
(12, 30, 'Data Warehouse', '2021-10-03', '07:00:00', '09:00:00', 'FILKOM Gedung A2.2', 'Keterangan DW', NULL, '2021-08-31 12:46:27', '2021-08-31 12:46:27', NULL),
(13, 30, 'Algoritma dan Struktur Data', '2021-10-03', '10:47:00', '12:47:00', 'FILKOM Gedung A2.2', 'Keterangan ASD!', NULL, '2021-08-31 12:47:55', '2021-08-31 12:47:55', NULL),
(14, 31, 'Pemrograman Dasar', '2021-10-03', '13:48:00', '14:48:00', 'FILKOM Gedung A2.2', 'Keterangan Pemdas!', NULL, '2021-08-31 12:49:03', '2021-08-31 12:49:03', NULL),
(15, 31, 'Pengantar Big Data', '2021-10-03', '07:00:00', '09:00:00', 'FILKOM Gedung F2.2', 'Keterangan PBD!', NULL, '2021-08-31 20:18:25', '2021-08-31 20:18:25', NULL),
(16, 32, 'Data Warehouse', '2021-09-13', '07:00:00', '14:00:00', 'FILKOM Gedung A2.2', 'Keterangan DW!', NULL, '2021-08-31 14:02:57', '2021-08-31 14:02:57', NULL),
(17, 30, 'Sistem Operasi', '2021-09-03', '07:05:00', '11:10:00', 'FILKOM Gedung F2.2', 'Keterangan Sistem Operasi', NULL, '2021-09-01 08:33:37', '2021-09-01 08:33:37', NULL),
(18, 30, 'Pemrograman Lanjut', '2021-09-13', '13:00:00', '14:00:00', 'FILKOM Gedung A2.2', 'Keternagan PEMLAN!', NULL, '2021-09-01 08:33:37', '2021-09-01 08:33:37', NULL),
(19, 32, 'Pemrograman Lanjut', '2021-10-03', '08:00:00', '10:00:00', 'FILKOM Gedung F2.2', 'Keterangan OSPEK PEMLAN!', NULL, '2021-09-01 11:29:15', '2021-09-01 11:29:15', NULL),
(20, 31, 'Algoritma dan Struktur Data', '2021-09-13', '13:30:00', '16:31:00', 'FILKOM Gedung F2.2', 'Keterangan UJIAN ASD!', NULL, '2021-09-01 11:31:17', '2021-09-01 11:31:17', NULL),
(22, 32, 'Sistem Operasi', '2021-09-12', '07:00:00', '09:00:00', 'FILKOM Gedung D2.2', 'Keterangan ujian SISOP!', NULL, '2021-09-01 11:42:56', '2021-09-01 11:42:56', NULL),
(23, 33, 'Data Warehouse', '2021-09-03', '12:14:00', '14:14:00', 'FILKOM Gedung F2.2', 'keterangan Data Warehouse!', NULL, '2021-09-01 12:15:09', '2021-09-01 12:15:09', NULL),
(24, 33, 'Pengantar Big Data', '2021-10-03', '12:15:00', '14:15:00', 'FILKOM Gedung A2.2', 'keterangan Pengantar Big Data', NULL, '2021-09-01 12:16:02', '2021-09-01 12:16:02', NULL),
(25, 34, 'Sistem Operasi', '2021-09-13', '13:06:00', '19:06:00', 'FILKOM Gedung B2.2', 'Keterangan SISOP!', NULL, '2021-09-01 13:06:45', '2021-09-01 13:06:45', NULL),
(26, 34, 'Data Warehouse', '2021-10-03', '01:06:00', '13:06:00', 'FILKOM Gedung A2.2', 'Keterangan DW!', NULL, '2021-09-01 13:07:07', '2021-09-01 13:07:07', NULL),
(27, 34, 'Pengantar Big Data', '2021-09-21', '11:00:00', '13:00:00', 'FILKOM Gedung D2.2', 'Keterangan PBD!', NULL, '2021-09-01 20:07:57', '2021-09-01 20:07:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_difabel`
--

CREATE TABLE `kategori_difabel` (
  `id` int(11) NOT NULL,
  `jenis` varchar(50) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori_difabel`
--

INSERT INTO `kategori_difabel` (`id`, `jenis`, `description`) VALUES
(1, 'Tunarungu', 'yaitu kondisi fisik yang ditandai dengan penurunan atau ketidakmampuan seseorang untuk mendengarkan '),
(2, 'Tunadaksa', 'yaitu kelainan atau kerusakan pada fisik dan kesehatan'),
(3, 'Tunanetra', 'yaitu kondisi seseorang yang mengalami gangguan atau hambatan dalam indra penglihatannya. Berdasarka'),
(4, 'Autisme', 'yaitu gangguan perkembangan pervasif yang ditandai dengan adanya gangguan dan keterlambatan dalam bi'),
(5, 'ADHD', ''),
(6, 'Celebral Palsy', ''),
(7, 'Slow Learner', ''),
(8, 'Tunagrahita', 'yaitu keterbelakangan mental atau dikenal juga sebagai retardasi mental'),
(9, 'Bibir Sumbing', ''),
(10, 'Down Syndrome', ''),
(11, 'Gangguan Syaraf', ''),
(12, 'Hydrochepalus', ''),
(13, 'IQ Borderline', ''),
(14, 'Low Vision', ''),
(15, 'Tunawicara', 'yaitu ketidakmampuan seseorang untuk berbicara'),
(16, 'Writer\'s Cramp Dystonia', '');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_damping`
--

CREATE TABLE `laporan_damping` (
  `id_laporan_damping` int(11) UNSIGNED NOT NULL,
  `id_damping` int(11) UNSIGNED NOT NULL,
  `madif_review` text DEFAULT NULL,
  `pendamping_review` text DEFAULT NULL,
  `approval` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2017-11-20-223112', 'Myth\\Auth\\Database\\Migrations\\CreateAuthTables', 'default', 'Myth\\Auth', 1629292194, 1);

-- --------------------------------------------------------

--
-- Table structure for table `presensi`
--

CREATE TABLE `presensi` (
  `id_damping_ujian` int(11) UNSIGNED NOT NULL,
  `status_kehadiran` tinyint(1) DEFAULT NULL,
  `waktu_hadir` time DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `approval_madif` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `profile_admin`
--

CREATE TABLE `profile_admin` (
  `id_profile_admin` int(11) UNSIGNED NOT NULL,
  `username` varchar(30) CHARACTER SET utf8 NOT NULL,
  `jabatan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profile_admin`
--

INSERT INTO `profile_admin` (`id_profile_admin`, `username`, `jabatan`) VALUES
(2, '175150400111017', 'Staff Pendampingan');

-- --------------------------------------------------------

--
-- Table structure for table `profile_jenis_madif`
--

CREATE TABLE `profile_jenis_madif` (
  `id_profile_madif` int(11) UNSIGNED NOT NULL,
  `id_jenis_difabel` int(11) NOT NULL,
  `approval` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profile_jenis_madif`
--

INSERT INTO `profile_jenis_madif` (`id_profile_madif`, `id_jenis_difabel`, `approval`) VALUES
(30, 2, NULL),
(33, 2, NULL),
(34, 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `profile_mhs`
--

CREATE TABLE `profile_mhs` (
  `id_profile_mhs` int(11) UNSIGNED NOT NULL,
  `nim` varchar(30) CHARACTER SET utf8 NOT NULL,
  `fakultas` varchar(100) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `prodi` varchar(100) NOT NULL,
  `semester` int(11) DEFAULT NULL,
  `madif` tinyint(1) DEFAULT NULL,
  `pendamping` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profile_mhs`
--

INSERT INTO `profile_mhs` (`id_profile_mhs`, `nim`, `fakultas`, `jurusan`, `prodi`, `semester`, `madif`, `pendamping`) VALUES
(30, '1751504001110171', 'Fakultas Ilmu Komputer', 'Sistem Informasi', 'Sistem Informasi', 5, 1, NULL),
(31, '1751504001110172', 'Fakultas Kedokteran', 'Ilmu dokter', 'Kedokteran', 5, NULL, 1),
(32, '1751504001110173', 'Fakultas Kedokteran', 'Ilmu Kesehetan', 'Kedokteran', 3, 0, 1),
(33, '1751504001110174', 'Fakultas Ilmu Budaya', 'Ilmu sastra indonesia', 'sastra indonesia', 5, 1, 0),
(34, '1751504001110175', 'Fakultas Kedokteran', 'Ilmu dokter', 'Kedokteran', 3, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `profile_skills`
--

CREATE TABLE `profile_skills` (
  `id_profile_pendamping` int(11) UNSIGNED NOT NULL,
  `ref_pendampingan` int(11) NOT NULL,
  `prioritas` tinyint(3) UNSIGNED NOT NULL,
  `approval` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profile_skills`
--

INSERT INTO `profile_skills` (`id_profile_pendamping`, `ref_pendampingan`, `prioritas`, `approval`) VALUES
(31, 1, 2, NULL),
(31, 4, 3, NULL),
(31, 16, 1, NULL),
(32, 3, 2, NULL),
(32, 8, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `user_image` varchar(255) NOT NULL DEFAULT 'default.svg',
  `password_hash` varchar(255) NOT NULL,
  `reset_hash` varchar(255) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `activate_hash` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `user_image`, `password_hash`, `reset_hash`, `reset_at`, `reset_expires`, `activate_hash`, `status`, `status_message`, `active`, `force_pass_reset`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, '175150400111017', 'aditkw43@gmail.com', 'default.svg', '$2y$10$Ho25FXym8aueEWg6ZXkOuunq30FT7rCHBK6CSeL.lGHKRWz7PBiNu', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2021-08-19 10:34:13', '2021-08-19 10:34:13', NULL),
(52, '1751504001110171', '1751504001110171@gmail.com', 'default.svg', '$2y$10$FbBvkoha2Rfi0/D8LMcTaewo9sdKhbqY7e/B4B4DDi9Y.plP2W1w6', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2021-08-29 09:29:36', '2021-08-29 09:29:36', NULL),
(53, '1751504001110172', '1751504001110172@gmail.com', 'default.svg', '$2y$10$Z68Zf5bJeqMIpjfNGqGhZez/nZktCIIBOz0NDK4J2PNJ6lhhhbhsi', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2021-08-29 09:35:07', '2021-08-29 09:35:07', NULL),
(54, '1751504001110173', '1751504001110173@gmail.com', 'default.svg', '$2y$10$i4bXV..JY3tBOEFwFtT1N.kaT/ep8my1PuFfSEbcDRwpYQzAA7Qn6', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2021-08-31 13:52:58', '2021-08-31 13:52:58', NULL),
(55, '1751504001110174', '1751504001110174@gmail.com', 'default.svg', '$2y$10$KL/lB.qoNj9WCL5mWi1mNu5tEnU1xzl3VNMQXXPanb4rqnK1Hvl36', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2021-09-01 12:14:20', '2021-09-01 12:14:20', NULL),
(56, '1751504001110175', '1751504001110175@gmail.com', 'default.svg', '$2y$10$CvXKyNcgSc6O/qRncCph0uyMNQvwzQAU2eyrm8UVFlse1O2Fd7mfa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2021-09-01 13:05:09', '2021-09-01 13:05:09', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_groups`
--
ALTER TABLE `auth_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD KEY `auth_groups_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `group_id_permission_id` (`group_id`,`permission_id`);

--
-- Indexes for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD KEY `auth_groups_users_user_id_foreign` (`user_id`),
  ADD KEY `group_id_user_id` (`group_id`,`user_id`);

--
-- Indexes for table `auth_logins`
--
ALTER TABLE `auth_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_permissions`
--
ALTER TABLE `auth_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_tokens_user_id_foreign` (`user_id`),
  ADD KEY `selector` (`selector`);

--
-- Indexes for table `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD KEY `auth_users_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `user_id_permission_id` (`user_id`,`permission_id`);

--
-- Indexes for table `biodata`
--
ALTER TABLE `biodata`
  ADD UNIQUE KEY `bio_nim_mhs_fk` (`id_profile_mhs`) USING BTREE,
  ADD UNIQUE KEY `bio_id_admin_fk` (`id_profile_admin`) USING BTREE;

--
-- Indexes for table `cuti`
--
ALTER TABLE `cuti`
  ADD PRIMARY KEY (`id_cuti`),
  ADD KEY `cuti_id_profile_mhs_fk` (`id_profile_mhs`);

--
-- Indexes for table `damping_ujian`
--
ALTER TABLE `damping_ujian`
  ADD PRIMARY KEY (`id_damping`),
  ADD KEY `damping_ujian_id_jadwal_ujian_madif_fk` (`id_jadwal_ujian_madif`),
  ADD KEY `id_profile_madif_fk` (`id_profile_madif`),
  ADD KEY `id_profile_pendamping_fk` (`id_profile_pendamping`);

--
-- Indexes for table `izin_tidak_damping`
--
ALTER TABLE `izin_tidak_damping`
  ADD PRIMARY KEY (`id_izin`),
  ADD KEY `izin_id_damping_ujian_fk` (`id_damping_ujian`),
  ADD KEY `izin_nim_pendamping_fk` (`id_pendamping_lama`,`id_pendamping_baru`),
  ADD KEY `izin_id_pendamping_lama_fk` (`id_pendamping_baru`);

--
-- Indexes for table `jadwal_ujian`
--
ALTER TABLE `jadwal_ujian`
  ADD PRIMARY KEY (`id_jadwal_ujian`),
  ADD KEY `jadwal_ujian_id_profile_mhs_fk` (`id_profile_mhs`) USING BTREE;

--
-- Indexes for table `kategori_difabel`
--
ALTER TABLE `kategori_difabel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporan_damping`
--
ALTER TABLE `laporan_damping`
  ADD PRIMARY KEY (`id_laporan_damping`),
  ADD UNIQUE KEY `laporan_damping_id_damping_fk` (`id_damping`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `presensi`
--
ALTER TABLE `presensi`
  ADD UNIQUE KEY `presensi_id_damping_ujian_fk` (`id_damping_ujian`);

--
-- Indexes for table `profile_admin`
--
ALTER TABLE `profile_admin`
  ADD PRIMARY KEY (`id_profile_admin`),
  ADD UNIQUE KEY `profile_admin_username_fk` (`username`) USING BTREE;

--
-- Indexes for table `profile_jenis_madif`
--
ALTER TABLE `profile_jenis_madif`
  ADD UNIQUE KEY `id_madif_fk` (`id_profile_madif`) USING BTREE,
  ADD KEY `profile_jenis_difabel_id_jenis_difabel_fk` (`id_jenis_difabel`) USING BTREE;

--
-- Indexes for table `profile_mhs`
--
ALTER TABLE `profile_mhs`
  ADD PRIMARY KEY (`id_profile_mhs`),
  ADD UNIQUE KEY `profile_mhs_user_nim_fk` (`nim`) USING BTREE;

--
-- Indexes for table `profile_skills`
--
ALTER TABLE `profile_skills`
  ADD UNIQUE KEY `profile_id_pendamping_skill_fk` (`id_profile_pendamping`,`ref_pendampingan`) USING BTREE,
  ADD UNIQUE KEY `id_pendamping_prioritas` (`id_profile_pendamping`,`prioritas`),
  ADD KEY `skills_id_kategori_difabel_fk` (`ref_pendampingan`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_groups`
--
ALTER TABLE `auth_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `auth_logins`
--
ALTER TABLE `auth_logins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `auth_permissions`
--
ALTER TABLE `auth_permissions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cuti`
--
ALTER TABLE `cuti`
  MODIFY `id_cuti` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `izin_tidak_damping`
--
ALTER TABLE `izin_tidak_damping`
  MODIFY `id_izin` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal_ujian`
--
ALTER TABLE `jadwal_ujian`
  MODIFY `id_jadwal_ujian` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `kategori_difabel`
--
ALTER TABLE `kategori_difabel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `laporan_damping`
--
ALTER TABLE `laporan_damping`
  MODIFY `id_laporan_damping` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `profile_admin`
--
ALTER TABLE `profile_admin`
  MODIFY `id_profile_admin` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `profile_mhs`
--
ALTER TABLE `profile_mhs`
  MODIFY `id_profile_mhs` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD CONSTRAINT `auth_groups_permissions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD CONSTRAINT `auth_groups_users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD CONSTRAINT `auth_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD CONSTRAINT `auth_users_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_users_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `biodata`
--
ALTER TABLE `biodata`
  ADD CONSTRAINT `biodata_id_admin_bio_fk` FOREIGN KEY (`id_profile_admin`) REFERENCES `profile_admin` (`id_profile_admin`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `biodata_id_mhs_bio_fk` FOREIGN KEY (`id_profile_mhs`) REFERENCES `profile_mhs` (`id_profile_mhs`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cuti`
--
ALTER TABLE `cuti`
  ADD CONSTRAINT `cuti_id_profile_mhs_fk` FOREIGN KEY (`id_profile_mhs`) REFERENCES `profile_mhs` (`id_profile_mhs`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `damping_ujian`
--
ALTER TABLE `damping_ujian`
  ADD CONSTRAINT `damping_ujian_id_jadwal_ujian_madif` FOREIGN KEY (`id_jadwal_ujian_madif`) REFERENCES `jadwal_ujian` (`id_jadwal_ujian`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `damping_ujian_id_profile_madif_fk` FOREIGN KEY (`id_profile_madif`) REFERENCES `profile_mhs` (`id_profile_mhs`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `damping_ujian_id_profile_pendamping_fk` FOREIGN KEY (`id_profile_pendamping`) REFERENCES `profile_mhs` (`id_profile_mhs`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `izin_tidak_damping`
--
ALTER TABLE `izin_tidak_damping`
  ADD CONSTRAINT `izin_id_damping_ujian_fk` FOREIGN KEY (`id_damping_ujian`) REFERENCES `damping_ujian` (`id_damping`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `izin_id_pendamping_baru` FOREIGN KEY (`id_pendamping_lama`) REFERENCES `profile_mhs` (`id_profile_mhs`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `izin_id_pendamping_lama_fk` FOREIGN KEY (`id_pendamping_baru`) REFERENCES `profile_mhs` (`id_profile_mhs`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jadwal_ujian`
--
ALTER TABLE `jadwal_ujian`
  ADD CONSTRAINT `jadwal_ujian_id_profile_mhs_fk` FOREIGN KEY (`id_profile_mhs`) REFERENCES `profile_mhs` (`id_profile_mhs`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `laporan_damping`
--
ALTER TABLE `laporan_damping`
  ADD CONSTRAINT `laporan_id_damping_fk` FOREIGN KEY (`id_damping`) REFERENCES `damping_ujian` (`id_damping`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `presensi`
--
ALTER TABLE `presensi`
  ADD CONSTRAINT `presensi_id_damping_ujian_fk` FOREIGN KEY (`id_damping_ujian`) REFERENCES `damping_ujian` (`id_damping`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profile_admin`
--
ALTER TABLE `profile_admin`
  ADD CONSTRAINT `profile_admin_id_admin_fk` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profile_jenis_madif`
--
ALTER TABLE `profile_jenis_madif`
  ADD CONSTRAINT `jenis_madif_id_kategori_difabel_fk` FOREIGN KEY (`id_jenis_difabel`) REFERENCES `kategori_difabel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jenis_madif_id_profile_madif_fk` FOREIGN KEY (`id_profile_madif`) REFERENCES `profile_mhs` (`id_profile_mhs`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profile_mhs`
--
ALTER TABLE `profile_mhs`
  ADD CONSTRAINT `profile_mhs_user_nim_fk` FOREIGN KEY (`nim`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profile_skills`
--
ALTER TABLE `profile_skills`
  ADD CONSTRAINT `skills_id_kategori_difabel_fk` FOREIGN KEY (`ref_pendampingan`) REFERENCES `kategori_difabel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `skills_id_profile_pendamping_fk` FOREIGN KEY (`id_profile_pendamping`) REFERENCES `profile_mhs` (`id_profile_mhs`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
