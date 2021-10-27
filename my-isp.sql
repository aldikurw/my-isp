-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Oct 27, 2021 at 04:10 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `akun_hotspot_voucher`
--

CREATE TABLE `akun_hotspot_voucher` (
  `id_akun_hotspot_voucher` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `ip_router` varchar(15) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(2, 'Pojok');

-- --------------------------------------------------------

--
-- Table structure for table `bulan`
--

CREATE TABLE `bulan` (
  `id_bulan` int(11) NOT NULL,
  `nama` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `id_invoice_akun_home_wifi` varchar(100) NOT NULL,
  `id_akun_home` int(11) NOT NULL,
  `total_tagihan` int(11) NOT NULL,
  `status_pembayaran` varchar(10) NOT NULL,
  `tanggal_pembayaran` datetime NOT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `tahun` int(11) NOT NULL,
  `bulan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `harga_jual` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paket_voucher`
--

INSERT INTO `paket_voucher` (`id_paket_voucher`, `nama`, `kecepatan`, `durasi`, `harga_beli`, `harga_jual`) VALUES
(1, 'Bronze', '1500k/1500k', '12h', 1500, 2000),
(2, 'Silver', '1500k/1500k', '7d', 15000, 20000),
(3, 'Gold', '1500k/1500k', '30d', 45000, 50000);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
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
  `id_akun_hotspot_voucher` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_voucher_detail`
--

CREATE TABLE `transaksi_voucher_detail` (
  `id_transaksi_voucher_detail` int(11) NOT NULL,
  `id_transaksi_voucher` int(11) NOT NULL,
  `id_paket_voucher` int(11) NOT NULL,
  `jumlah_pembelian` int(11) NOT NULL,
  `total_pembelian` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Structure for view `view_pelanggan_home`
--
DROP TABLE IF EXISTS `view_pelanggan_home`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `view_pelanggan_home`  AS SELECT `plg`.`id_pelanggan` AS `id_pelanggan`, `akn`.`id_akun_home_wifi` AS `id_akun_home_wifi`, `plg`.`nama` AS `nama`, `alm`.`nama` AS `alamat`, `pkt`.`kecepatan` AS `kecepatan`, if((`akn`.`jenis_koneksi` = 'IP static'),`akn`.`ip_static`,`akn`.`username_pppoe`) AS `koneksi` FROM (((`akun_home_wifi` `akn` join `pelanggan` `plg` on((`akn`.`id_pelanggan` = `plg`.`id_pelanggan`))) join `paket_home_wifi` `pkt` on((`pkt`.`id_paket_home_wifi` = `akn`.`id_paket_home_wifi`))) join `alamat` `alm` on((`alm`.`id_alamat` = `plg`.`id_alamat`))) ;

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
-- Indexes for table `akun_hotspot_voucher`
--
ALTER TABLE `akun_hotspot_voucher`
  ADD PRIMARY KEY (`id_akun_hotspot_voucher`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `alamat`
--
ALTER TABLE `alamat`
  ADD PRIMARY KEY (`id_alamat`);

--
-- Indexes for table `bulan`
--
ALTER TABLE `bulan`
  ADD PRIMARY KEY (`id_bulan`);

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
  ADD PRIMARY KEY (`id_invoice_akun_home_wifi`),
  ADD KEY `id_akun_home` (`id_akun_home`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `bulan` (`bulan`);

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
  ADD KEY `id_akun_hotspot_voucher` (`id_akun_hotspot_voucher`);

--
-- Indexes for table `transaksi_voucher_detail`
--
ALTER TABLE `transaksi_voucher_detail`
  ADD PRIMARY KEY (`id_transaksi_voucher_detail`),
  ADD KEY `id_transaksi_voucher` (`id_transaksi_voucher`),
  ADD KEY `id_paket_voucher` (`id_paket_voucher`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akun_home_wifi`
--
ALTER TABLE `akun_home_wifi`
  MODIFY `id_akun_home_wifi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `akun_hotspot_voucher`
--
ALTER TABLE `akun_hotspot_voucher`
  MODIFY `id_akun_hotspot_voucher` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `alamat`
--
ALTER TABLE `alamat`
  MODIFY `id_alamat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bulan`
--
ALTER TABLE `bulan`
  MODIFY `id_bulan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `calon_pelanggan`
--
ALTER TABLE `calon_pelanggan`
  MODIFY `id_calon_pelanggan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `laporan_gangguan`
--
ALTER TABLE `laporan_gangguan`
  MODIFY `id_laporan_gangguan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paket_home_wifi`
--
ALTER TABLE `paket_home_wifi`
  MODIFY `id_paket_home_wifi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `paket_voucher`
--
ALTER TABLE `paket_voucher`
  MODIFY `id_paket_voucher` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `transaksi_voucher_detail`
--
ALTER TABLE `transaksi_voucher_detail`
  MODIFY `id_transaksi_voucher_detail` int(11) NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `akun_hotspot_voucher`
--
ALTER TABLE `akun_hotspot_voucher`
  ADD CONSTRAINT `akun_hotspot_voucher_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`);

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
  ADD CONSTRAINT `invoice_home_wifi_ibfk_1` FOREIGN KEY (`id_akun_home`) REFERENCES `akun_home_wifi` (`id_akun_home_wifi`),
  ADD CONSTRAINT `invoice_home_wifi_ibfk_2` FOREIGN KEY (`tahun`) REFERENCES `tahun` (`tahun`),
  ADD CONSTRAINT `invoice_home_wifi_ibfk_3` FOREIGN KEY (`bulan`) REFERENCES `bulan` (`id_bulan`);

--
-- Constraints for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD CONSTRAINT `pelanggan_ibfk_1` FOREIGN KEY (`id_alamat`) REFERENCES `alamat` (`id_alamat`);

--
-- Constraints for table `transaksi_voucher`
--
ALTER TABLE `transaksi_voucher`
  ADD CONSTRAINT `transaksi_voucher_ibfk_1` FOREIGN KEY (`id_akun_hotspot_voucher`) REFERENCES `akun_hotspot_voucher` (`id_akun_hotspot_voucher`);

--
-- Constraints for table `transaksi_voucher_detail`
--
ALTER TABLE `transaksi_voucher_detail`
  ADD CONSTRAINT `transaksi_voucher_detail_ibfk_2` FOREIGN KEY (`id_transaksi_voucher`) REFERENCES `transaksi_voucher` (`id_transaksi_voucher`),
  ADD CONSTRAINT `transaksi_voucher_detail_ibfk_3` FOREIGN KEY (`id_paket_voucher`) REFERENCES `paket_voucher` (`id_paket_voucher`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
