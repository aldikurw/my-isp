-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Oct 29, 2021 at 02:52 AM
-- Server version: 5.7.35
-- PHP Version: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my-isp`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun_home_wifi`
--

CREATE TABLE `akun_home_wifi` (
  `id_akun_home_wifi` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_paket_home_wifi` int(11) NOT NULL,
  `jenis_koneksi` enum('IP static','PPPOE') NOT NULL,
  `ip_static` varchar(15) DEFAULT NULL,
  `username_pppoe` varchar(100) DEFAULT NULL,
  `password_pppoe` varchar(100) DEFAULT NULL,
  `tanggal_pemasangan` date DEFAULT NULL,
  `bulan_awal_penagihan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akun_home_wifi`
--

INSERT INTO `akun_home_wifi` (`id_akun_home_wifi`, `id_pelanggan`, `id_paket_home_wifi`, `jenis_koneksi`, `ip_static`, `username_pppoe`, `password_pppoe`, `tanggal_pemasangan`, `bulan_awal_penagihan`) VALUES
(12, 32, 2, 'IP static', '10.10.0.234', '', '', '2021-10-19', '2021-10-19'),
(13, 33, 1, 'PPPOE', NULL, 'slamet@gmdp-ptr.net', '123', '2021-10-18', '2021-10-04'),
(15, 35, 2, 'IP static', '10.10.3.65', '', '', '2021-10-14', '2021-10-28'),
(16, 41, 1, 'IP static', '10.10.9.57', NULL, NULL, '2021-10-25', '2021-10-28');

-- --------------------------------------------------------

--
-- Table structure for table `akun_reseller`
--

CREATE TABLE `akun_reseller` (
  `id_akun_reseller` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `ip_router` varchar(15) NOT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `tanggal_pemasangan` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akun_reseller`
--

INSERT INTO `akun_reseller` (`id_akun_reseller`, `id_pelanggan`, `ip_router`, `keterangan`, `tanggal_pemasangan`) VALUES
(5, 40, '10.10.0.23', NULL, '2021-10-20'),
(6, 42, '10.10.0.32', NULL, '2021-10-13');

-- --------------------------------------------------------

--
-- Table structure for table `alamat`
--

CREATE TABLE `alamat` (
  `id_alamat` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alamat`
--

INSERT INTO `alamat` (`id_alamat`, `nama`) VALUES
(1, 'Sugihwaras'),
(2, 'Pojok'),
(3, 'Gajah');

-- --------------------------------------------------------

--
-- Table structure for table `calon_pelanggan`
--

CREATE TABLE `calon_pelanggan` (
  `id_calon_pelanggan` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(1) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `jenis_langganan` enum('Home','Voucher') NOT NULL,
  `id_paket_home_wifi` int(11) DEFAULT NULL,
  `id_alamat` int(11) DEFAULT NULL,
  `alamat_lain` varchar(100) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_home_wifi`
--

CREATE TABLE `invoice_home_wifi` (
  `id_invoice_home_wifi` int(11) NOT NULL,
  `uuid` varchar(100) NOT NULL,
  `id_akun_home_wifi` int(11) NOT NULL,
  `status_pembayaran` enum('Lunas','Belum Lunas') NOT NULL DEFAULT 'Lunas',
  `tanggal_pembayaran` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `keterangan` varchar(100) DEFAULT NULL,
  `tahun` int(11) NOT NULL,
  `bulan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_home_wifi`
--

INSERT INTO `invoice_home_wifi` (`id_invoice_home_wifi`, `uuid`, `id_akun_home_wifi`, `status_pembayaran`, `tanggal_pembayaran`, `keterangan`, `tahun`, `bulan`) VALUES
(1, '27b76c53-3778-11ec-bd86-0242ac120004', 12, 'Belum Lunas', '0000-00-00 00:00:00', NULL, 2021, 11),
(7, '650af2ae-3779-11ec-bd86-0242ac120004', 12, 'Belum Lunas', '0000-00-00 00:00:00', NULL, 2021, 12),
(8, '5ea78dbf-37a0-11ec-bd86-0242ac120004', 13, 'Belum Lunas', '0000-00-00 00:00:00', NULL, 2021, 11),
(9, 'cec09041-37b5-11ec-bd86-0242ac120004', 12, 'Lunas', '2021-10-28 13:10:53', NULL, 2021, 10),
(10, 'd5235b4c-37b5-11ec-bd86-0242ac120004', 13, 'Lunas', '2021-10-28 13:11:04', NULL, 2021, 10),
(11, '1d830757-37b7-11ec-bd86-0242ac120004', 15, 'Belum Lunas', '0000-00-00 00:00:00', NULL, 2021, 10),
(12, '6559eb93-37fa-11ec-bd86-0242ac120004', 16, 'Lunas', '2021-10-28 21:21:52', NULL, 2021, 10);

-- --------------------------------------------------------

--
-- Table structure for table `laporan_gangguan`
--

CREATE TABLE `laporan_gangguan` (
  `id_laporan_gangguan` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `waktu_gangguan` datetime NOT NULL,
  `keterangan` varchar(1000) NOT NULL,
  `waktu_input` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `paket_home_wifi`
--

CREATE TABLE `paket_home_wifi` (
  `id_paket_home_wifi` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `kecepatan` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paket_home_wifi`
--

INSERT INTO `paket_home_wifi` (`id_paket_home_wifi`, `nama`, `kecepatan`, `harga`) VALUES
(1, 'Basic', '2M/2M', 125000),
(2, 'Plus', '5M/5M', 175000),
(3, 'Premium', '10M/10M', 250000);

-- --------------------------------------------------------

--
-- Table structure for table `paket_voucher`
--

CREATE TABLE `paket_voucher` (
  `id_paket_voucher` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kecepatan` varchar(100) NOT NULL,
  `durasi` varchar(100) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `target_bonus` int(11) NOT NULL,
  `jumlah_bonus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paket_voucher`
--

INSERT INTO `paket_voucher` (`id_paket_voucher`, `nama`, `kecepatan`, `durasi`, `harga_beli`, `harga_jual`, `target_bonus`, `jumlah_bonus`) VALUES
(1, 'Bronze', '1500k/1500k', '12h', 1500, 2000, 100, 10),
(2, 'Silver', '1500k/1500k', '7d', 15000, 20000, 50, 5),
(3, 'Gold', '1500k/1500k', '30d', 45000, 50000, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `username_akun` varchar(50) NOT NULL,
  `password_akun` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nik` varchar(16) DEFAULT NULL,
  `jenis_kelamin` enum('Laki-Laki','Perempuan') NOT NULL,
  `kontak` varchar(13) NOT NULL,
  `id_alamat` int(11) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `jenis_pemasangan` enum('Media converter','OLT','Antena') NOT NULL,
  `url_foto_ktp` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `username_akun`, `password_akun`, `nama`, `nik`, `jenis_kelamin`, `kontak`, `id_alamat`, `lat`, `lng`, `jenis_pemasangan`, `url_foto_ktp`, `created_at`) VALUES
(32, 'aldi', '123', 'Aldi Kurniawan', '3517031234', 'Laki-Laki', '0812345678', 1, -7.64031, 112.254, 'OLT', '32.png', '2021-10-27 16:23:00'),
(33, 'slamet', 'abc', 'Slamet Wirawan', '345345', 'Laki-Laki', '345346', 1, -7.6365, 112.255, 'OLT', '', '2021-10-27 16:24:37'),
(35, 'budi', 'kentang', 'Budi Dermawan', '3413425', 'Laki-Laki', '08123', 1, -7.63423, 112.253, 'OLT', '', '2021-10-28 13:20:06'),
(40, 'paijo', '123', 'Paijooo', '3413425', 'Laki-Laki', '08123456', 1, -7.63885, 112.254, 'Media converter', '40.png', '2021-10-28 21:00:11'),
(41, 'ahmad', 'ahmad123', 'ahmad', '341234346', 'Laki-Laki', '08111', 3, -7.63946, 112.256, 'Media converter', '41.png', '2021-10-28 21:21:28'),
(42, 'sukijan', '123', 'Sukijan', '56783465', 'Laki-Laki', '63412346', 1, -7.63867, 112.254, 'Media converter', NULL, '2021-10-28 22:39:59');

-- --------------------------------------------------------

--
-- Table structure for table `tahun`
--

CREATE TABLE `tahun` (
  `tahun` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tahun`
--

INSERT INTO `tahun` (`tahun`) VALUES
(2021);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_voucher`
--

CREATE TABLE `transaksi_voucher` (
  `id_transaksi_voucher` int(11) NOT NULL,
  `id_akun_reseller` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi_voucher`
--

INSERT INTO `transaksi_voucher` (`id_transaksi_voucher`, `id_akun_reseller`, `total`, `keterangan`, `created_at`) VALUES
(5, 5, 150000, '', '2021-10-28 21:00:40'),
(10, 5, 225000, '', '2021-10-29 04:09:48');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_voucher_detail`
--

CREATE TABLE `transaksi_voucher_detail` (
  `id_transaksi_voucher_detail` int(11) NOT NULL,
  `id_transaksi_voucher` int(11) NOT NULL,
  `id_paket_voucher` int(11) NOT NULL,
  `jumlah_pembelian` int(11) NOT NULL,
  `bonus` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi_voucher_detail`
--

INSERT INTO `transaksi_voucher_detail` (`id_transaksi_voucher_detail`, `id_transaksi_voucher`, `id_paket_voucher`, `jumlah_pembelian`, `bonus`) VALUES
(1, 5, 1, 100, 20),
(8, 10, 1, 100, 10),
(9, 10, 2, 5, 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_pelanggan_home`
-- (See below for the actual view)
--
CREATE TABLE `view_pelanggan_home` (
`id_pelanggan` int(11)
,`id_akun_home_wifi` int(11)
,`nama` varchar(100)
,`alamat` varchar(100)
,`kecepatan` varchar(100)
,`koneksi` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_reseller`
-- (See below for the actual view)
--
CREATE TABLE `view_reseller` (
`id_pelanggan` int(11)
,`id_akun_reseller` int(11)
,`nama` varchar(100)
,`alamat` varchar(100)
,`ip_router` varchar(15)
,`trx_bulan_ini` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_transaksi_voucher`
-- (See below for the actual view)
--
CREATE TABLE `view_transaksi_voucher` (
`id_pelanggan` int(11)
,`id_akun_reseller` int(11)
,`id_transaksi_voucher` int(11)
,`created_at` datetime
,`nama` varchar(100)
,`alamat` varchar(100)
,`total` int(11)
);

-- --------------------------------------------------------

--
-- Structure for view `view_pelanggan_home`
--
DROP TABLE IF EXISTS `view_pelanggan_home`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `view_pelanggan_home`  AS SELECT `plg`.`id_pelanggan` AS `id_pelanggan`, `akn`.`id_akun_home_wifi` AS `id_akun_home_wifi`, `plg`.`nama` AS `nama`, `alm`.`nama` AS `alamat`, `pkt`.`kecepatan` AS `kecepatan`, if((`akn`.`jenis_koneksi` = 'IP static'),`akn`.`ip_static`,`akn`.`username_pppoe`) AS `koneksi` FROM (((`akun_home_wifi` `akn` join `pelanggan` `plg` on((`akn`.`id_pelanggan` = `plg`.`id_pelanggan`))) join `paket_home_wifi` `pkt` on((`pkt`.`id_paket_home_wifi` = `akn`.`id_paket_home_wifi`))) join `alamat` `alm` on((`alm`.`id_alamat` = `plg`.`id_alamat`))) ;

-- --------------------------------------------------------

--
-- Structure for view `view_reseller`
--
DROP TABLE IF EXISTS `view_reseller`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `view_reseller`  AS SELECT `akun`.`id_pelanggan` AS `id_pelanggan`, `akun`.`id_akun_reseller` AS `id_akun_reseller`, `akun`.`nama` AS `nama`, `akun`.`alamat` AS `alamat`, `akun`.`ip_router` AS `ip_router`, sum(`trx`.`total`) AS `trx_bulan_ini` FROM (((select `plg`.`id_pelanggan` AS `id_pelanggan`,`akn`.`id_akun_reseller` AS `id_akun_reseller`,`plg`.`nama` AS `nama`,`alm`.`nama` AS `alamat`,`akn`.`ip_router` AS `ip_router` from ((`akun_reseller` `akn` join `pelanggan` `plg` on((`plg`.`id_pelanggan` = `akn`.`id_pelanggan`))) join `alamat` `alm` on((`alm`.`id_alamat` = `plg`.`id_alamat`))))) `akun` left join `transaksi_voucher` `trx` on((`trx`.`id_akun_reseller` = `akun`.`id_akun_reseller`))) WHERE (((month(`trx`.`created_at`) = month(curdate())) AND (year(`trx`.`created_at`) = year(curdate()))) OR isnull(`trx`.`created_at`)) GROUP BY `akun`.`id_akun_reseller` ;

-- --------------------------------------------------------

--
-- Structure for view `view_transaksi_voucher`
--
DROP TABLE IF EXISTS `view_transaksi_voucher`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `view_transaksi_voucher`  AS SELECT `plg`.`id_pelanggan` AS `id_pelanggan`, `akn`.`id_akun_reseller` AS `id_akun_reseller`, `trx`.`id_transaksi_voucher` AS `id_transaksi_voucher`, `trx`.`created_at` AS `created_at`, `plg`.`nama` AS `nama`, `alm`.`nama` AS `alamat`, `trx`.`total` AS `total` FROM (((`transaksi_voucher` `trx` join `akun_reseller` `akn` on((`akn`.`id_akun_reseller` = `trx`.`id_akun_reseller`))) join `pelanggan` `plg` on((`plg`.`id_pelanggan` = `akn`.`id_pelanggan`))) join `alamat` `alm` on((`alm`.`id_alamat` = `plg`.`id_alamat`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun_home_wifi`
--
ALTER TABLE `akun_home_wifi`
  ADD PRIMARY KEY (`id_akun_home_wifi`),
  ADD KEY `id_paket_wifihome` (`id_paket_home_wifi`),
  ADD KEY `akun_home_wifi_ibfk_2` (`id_pelanggan`);

--
-- Indexes for table `akun_reseller`
--
ALTER TABLE `akun_reseller`
  ADD PRIMARY KEY (`id_akun_reseller`),
  ADD KEY `akun_reseller_ibfk_1` (`id_pelanggan`);

--
-- Indexes for table `alamat`
--
ALTER TABLE `alamat`
  ADD PRIMARY KEY (`id_alamat`);

--
-- Indexes for table `calon_pelanggan`
--
ALTER TABLE `calon_pelanggan`
  ADD PRIMARY KEY (`id_calon_pelanggan`),
  ADD KEY `id_paket_wifihome` (`id_paket_home_wifi`),
  ADD KEY `id_alamat` (`id_alamat`);

--
-- Indexes for table `invoice_home_wifi`
--
ALTER TABLE `invoice_home_wifi`
  ADD PRIMARY KEY (`id_invoice_home_wifi`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `invoice_home_wifi_ibfk_1` (`id_akun_home_wifi`);

--
-- Indexes for table `laporan_gangguan`
--
ALTER TABLE `laporan_gangguan`
  ADD PRIMARY KEY (`id_laporan_gangguan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `paket_home_wifi`
--
ALTER TABLE `paket_home_wifi`
  ADD PRIMARY KEY (`id_paket_home_wifi`);

--
-- Indexes for table `paket_voucher`
--
ALTER TABLE `paket_voucher`
  ADD PRIMARY KEY (`id_paket_voucher`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD KEY `id_alamat` (`id_alamat`);

--
-- Indexes for table `tahun`
--
ALTER TABLE `tahun`
  ADD PRIMARY KEY (`tahun`);

--
-- Indexes for table `transaksi_voucher`
--
ALTER TABLE `transaksi_voucher`
  ADD PRIMARY KEY (`id_transaksi_voucher`),
  ADD KEY `id_akun_hotspot_voucher` (`id_akun_reseller`);

--
-- Indexes for table `transaksi_voucher_detail`
--
ALTER TABLE `transaksi_voucher_detail`
  ADD PRIMARY KEY (`id_transaksi_voucher_detail`),
  ADD KEY `transaksi_voucher_detail_ibfk_3` (`id_paket_voucher`),
  ADD KEY `transaksi_voucher_detail_ibfk_4` (`id_transaksi_voucher`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akun_home_wifi`
--
ALTER TABLE `akun_home_wifi`
  MODIFY `id_akun_home_wifi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `akun_reseller`
--
ALTER TABLE `akun_reseller`
  MODIFY `id_akun_reseller` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `alamat`
--
ALTER TABLE `alamat`
  MODIFY `id_alamat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `calon_pelanggan`
--
ALTER TABLE `calon_pelanggan`
  MODIFY `id_calon_pelanggan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_home_wifi`
--
ALTER TABLE `invoice_home_wifi`
  MODIFY `id_invoice_home_wifi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `laporan_gangguan`
--
ALTER TABLE `laporan_gangguan`
  MODIFY `id_laporan_gangguan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paket_home_wifi`
--
ALTER TABLE `paket_home_wifi`
  MODIFY `id_paket_home_wifi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `paket_voucher`
--
ALTER TABLE `paket_voucher`
  MODIFY `id_paket_voucher` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `transaksi_voucher`
--
ALTER TABLE `transaksi_voucher`
  MODIFY `id_transaksi_voucher` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transaksi_voucher_detail`
--
ALTER TABLE `transaksi_voucher_detail`
  MODIFY `id_transaksi_voucher_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `akun_home_wifi`
--
ALTER TABLE `akun_home_wifi`
  ADD CONSTRAINT `akun_home_wifi_ibfk_1` FOREIGN KEY (`id_paket_home_wifi`) REFERENCES `paket_home_wifi` (`id_paket_home_wifi`),
  ADD CONSTRAINT `akun_home_wifi_ibfk_2` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE;

--
-- Constraints for table `akun_reseller`
--
ALTER TABLE `akun_reseller`
  ADD CONSTRAINT `akun_reseller_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE;

--
-- Constraints for table `calon_pelanggan`
--
ALTER TABLE `calon_pelanggan`
  ADD CONSTRAINT `calon_pelanggan_ibfk_1` FOREIGN KEY (`id_paket_home_wifi`) REFERENCES `paket_home_wifi` (`id_paket_home_wifi`),
  ADD CONSTRAINT `calon_pelanggan_ibfk_2` FOREIGN KEY (`id_alamat`) REFERENCES `alamat` (`id_alamat`);

--
-- Constraints for table `invoice_home_wifi`
--
ALTER TABLE `invoice_home_wifi`
  ADD CONSTRAINT `invoice_home_wifi_ibfk_1` FOREIGN KEY (`id_akun_home_wifi`) REFERENCES `akun_home_wifi` (`id_akun_home_wifi`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoice_home_wifi_ibfk_2` FOREIGN KEY (`tahun`) REFERENCES `tahun` (`tahun`);

--
-- Constraints for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD CONSTRAINT `pelanggan_ibfk_1` FOREIGN KEY (`id_alamat`) REFERENCES `alamat` (`id_alamat`);

--
-- Constraints for table `transaksi_voucher`
--
ALTER TABLE `transaksi_voucher`
  ADD CONSTRAINT `transaksi_voucher_ibfk_1` FOREIGN KEY (`id_akun_reseller`) REFERENCES `akun_reseller` (`id_akun_reseller`);

--
-- Constraints for table `transaksi_voucher_detail`
--
ALTER TABLE `transaksi_voucher_detail`
  ADD CONSTRAINT `transaksi_voucher_detail_ibfk_3` FOREIGN KEY (`id_paket_voucher`) REFERENCES `paket_voucher` (`id_paket_voucher`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksi_voucher_detail_ibfk_4` FOREIGN KEY (`id_transaksi_voucher`) REFERENCES `transaksi_voucher` (`id_transaksi_voucher`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
