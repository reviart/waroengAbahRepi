-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2018 at 07:51 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_enak2`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbbarang`
--

CREATE TABLE `tbbarang` (
  `idBarang` char(5) NOT NULL,
  `nmBarang` char(50) NOT NULL,
  `jnBarang` char(20) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `gambar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbbarang`
--

INSERT INTO `tbbarang` (`idBarang`, `nmBarang`, `jnBarang`, `harga`, `stok`, `gambar`) VALUES
('B01', 'Jus Mangga Coklat', 'MINUMAN', 12000, 60, '670777-kreasi-minuman-mangga.jpg'),
('B02', 'King Mango', 'MINUMAN', 25000, 54, '3034255697.jpg'),
('B03', 'Buble Drink', 'MINUMAN', 15000, 45, 'gWVwwF_usaha_minuman_bubble_drink.jpg'),
('B04', 'Risol Modern', 'MAKANAN', 5000, 53, '5-Makanan-Murah-Yang-Bisa-Dicicipin-Waktu-Nge-mall.jpg'),
('B05', 'Sate Ayam', 'MAKANAN', 29000, 109, 'hipwee-Sate-Ayam-750x500.jpg'),
('B06', 'Mie Ayam', 'MAKANAN', 20000, 53, 'mieayam.jpg'),
('B07', 'Ikan Tawar', 'MAKANAN', 100000, 32, 'ocbvemv9ro8hzenf4po8.jpg'),
('B08', 'Sop Sapi', 'MAKANAN', 110000, 40, 'resepbunda-net-6be2c451bd8aab56177dcc745d1eb791.jpg'),
('B09', 'Rendang Khas Minang', 'MAKANAN', 95000, 48, 'resep-rendang-padang.jpg'),
('B10', 'Torabika Latte', 'MINUMAN', 25000, 22, 'minuman.jpg'),
('B11', 'Es Laksana Pekanbaru', 'MINUMAN', 20000, 47, '33273-es-laksana-mengamuk-minuman-khas-pekan-baru-yang-bisa-jadi-penyegar-instan.JPG'),
('B12', 'Es Serut Cirebon', 'MINUMAN', 16000, 35, 'esserutcirebon.jpg'),
('B13', 'Es Serbat Kweni Lampung', 'MINUMAN', 10000, 43, 'serbatkweni.jpg'),
('B14', 'Tutug Oncom Tasikmalaya', 'MAKANAN', 10000, 29, 'Resep-Nasi-Tutug-Oncom.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbkeranjang`
--

CREATE TABLE `tbkeranjang` (
  `idBarang` char(5) NOT NULL,
  `pcs` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `idUser` char(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbtransaksi`
--

CREATE TABLE `tbtransaksi` (
  `idTransaksi` char(25) NOT NULL,
  `tglTransaksi` char(15) NOT NULL,
  `idUser` char(15) NOT NULL,
  `qty` int(11) NOT NULL,
  `bayar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbtransaksi`
--

INSERT INTO `tbtransaksi` (`idTransaksi`, `tglTransaksi`, `idUser`, `qty`, `bayar`) VALUES
('20180109admin', '20180109', 'admin', 2, 3800000),
('20180109revicere', '20180109', 'revicere', 2, 8145000),
('20180110revicere', '20180110', 'revicere', 3, 115000);

-- --------------------------------------------------------

--
-- Table structure for table `tbuser`
--

CREATE TABLE `tbuser` (
  `idUser` char(15) NOT NULL,
  `pwUser` char(15) NOT NULL,
  `nmUser` char(50) NOT NULL,
  `stUser` char(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbuser`
--

INSERT INTO `tbuser` (`idUser`, `pwUser`, `nmUser`, `stUser`) VALUES
('admin', 'admin', 'admin', 'admin'),
('revicere', 'secret', 'Risjad Muhammad Reviansyah', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `idTransaksi` char(25) NOT NULL,
  `idBarang` char(5) NOT NULL,
  `pcs` int(11) NOT NULL,
  `totalharga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`idTransaksi`, `idBarang`, `pcs`, `totalharga`) VALUES
('20180103andis', 'B12', 1, 3546000),
('20180103andis', 'B07', 1, 14000000),
('20180109admin', 'B03', 1, 1300000),
('20180109admin', 'B10', 1, 2500000),
('20180109revicere', 'B12', 1, 3546000),
('20180109revicere', 'B09', 1, 4599000),
('20180110revicere', 'B13', 1, 10000),
('20180110revicere', 'B14', 1, 10000),
('20180110revicere', 'B09', 1, 95000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbbarang`
--
ALTER TABLE `tbbarang`
  ADD PRIMARY KEY (`idBarang`);

--
-- Indexes for table `tbtransaksi`
--
ALTER TABLE `tbtransaksi`
  ADD PRIMARY KEY (`idTransaksi`);

--
-- Indexes for table `tbuser`
--
ALTER TABLE `tbuser`
  ADD PRIMARY KEY (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
