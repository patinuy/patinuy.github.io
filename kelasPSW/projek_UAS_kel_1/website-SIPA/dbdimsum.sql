-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Jun 2025 pada 14.26
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbdimsum`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alamat_pengiriman`
--

CREATE TABLE `alamat_pengiriman` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `alamat` text NOT NULL,
  `kota` varchar(50) DEFAULT NULL,
  `provinsi` varchar(50) DEFAULT NULL,
  `kode_pos` varchar(10) DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `alamat_pengiriman`
--

INSERT INTO `alamat_pengiriman` (`id`, `users_id`, `alamat`, `kota`, `provinsi`, `kode_pos`, `no_hp`) VALUES
(1, 1, 'lubuk baja', 'Kota B A T A M', 'Kepulauan Riau', '29427', '082284111419'),
(5, 3, 'taman kota mas', 'batam', 'kepulauan riau', '1222', '2313131');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id`, `nama`) VALUES
(1, 'Reguler Series');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjang`
--

CREATE TABLE `keranjang` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `keranjang`
--

INSERT INTO `keranjang` (`id`, `users_id`, `produk_id`, `jumlah`) VALUES
(15, 1, 2, 1),
(16, 1, 7, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `metode_pembayaran`
--

CREATE TABLE `metode_pembayaran` (
  `id` int(11) NOT NULL,
  `nama_metode` varchar(100) NOT NULL,
  `nomor_rekening` varchar(50) DEFAULT NULL,
  `pemilik_rekening` varchar(100) DEFAULT NULL,
  `jenis_metode` enum('Bank') DEFAULT 'Bank'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `metode_pembayaran`
--

INSERT INTO `metode_pembayaran` (`id`, `nama_metode`, `nomor_rekening`, `pemilik_rekening`, `jenis_metode`) VALUES
(1, 'Bank BCA', '1234567890', 'John Doe', 'Bank'),
(2, 'Bank Mandiri', '9876543210', 'Jane Smith', 'Bank');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `status` varchar(50) DEFAULT 'Menunggu Pembayaran',
  `payment_method_id` int(11) NOT NULL,
  `alamat_pengiriman_id` int(11) NOT NULL,
  `shipping_cost` int(11) DEFAULT 0,
  `shipping_method` varchar(50) DEFAULT NULL,
  `tanggal_order` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `users_id`, `total`, `status`, `payment_method_id`, `alamat_pengiriman_id`, `shipping_cost`, `shipping_method`, `tanggal_order`) VALUES
(1, 1, 112000, 'Selesai', 1, 1, 20000, 'Reguler', '2025-06-16 21:22:35'),
(2, 1, 86000, 'Selesai', 1, 1, 20000, 'Reguler', '2025-06-16 22:25:51'),
(3, 3, 92000, 'Selesai', 1, 5, 20000, 'Reguler', '2025-06-17 01:07:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `produk_id`, `jumlah`, `harga`) VALUES
(4, 2, 2, 2, 33000),
(5, 3, 1, 3, 24000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `kategori_id` int(11) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int(11) NOT NULL,
  `rekomendasi` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `nama`, `deskripsi`, `kategori_id`, `harga`, `stok`, `rekomendasi`) VALUES
(1, 'Mentai Cheese - Paket A', 'Dimsum mentai keju isi 4', 1, 24000.00, 100, 1),
(2, 'Mentai Cheese - Paket B', 'Dimsum mentai keju isi 6', 1, 33000.00, 100, 0),
(3, 'Mentai Cheese - Paket Family', 'Dimsum mentai keju isi 20', 1, 104000.00, 100, 0),
(4, 'Dimsum Mentai - Paket A', 'Dimsum mentai isi 5', 1, 24000.00, 100, 1),
(5, 'Dimsum Mentai - Paket B', 'Dimsum mentai isi 8', 1, 35000.00, 100, 0),
(6, 'Dimsum Mentai - Paket Family', 'Dimsum mentai isi 20', 1, 84000.00, 100, 0),
(7, 'Mentai Spicy Cheese - Paket A', 'Dimsum mentai pedas keju isi 4', 1, 28000.00, 100, 1),
(8, 'Mentai Spicy Cheese - Paket B', 'Dimsum mentai pedas keju isi 6', 1, 37000.00, 100, 0),
(9, 'Mentai Spicy Cheese - Paket Family', 'Dimsum mentai pedas keju isi 20', 1, 124000.00, 100, 0),
(10, 'Dimsum Mix All - Paket A', 'Isi 5 campuran varian', 1, 27000.00, 100, 1),
(11, 'Dimsum Mix All - Paket B', 'Isi 8 campuran varian', 1, 38000.00, 100, 0),
(12, 'Dimsum Mix All - Paket Family', 'Isi 20 campuran varian', 1, 104000.00, 100, 0),
(13, 'Dimsum Original - Paket A', 'Dimsum original isi 5', 1, 19000.00, 100, 0),
(14, 'Dimsum Original - Paket B', 'Dimsum original isi 8', 1, 27000.00, 100, 0),
(15, 'Dimsum Original - Paket Family', 'Dimsum original isi 20', 1, 64000.00, 100, 0),
(16, 'Dimsum Moza - Paket A', 'Dimsum mozzarella isi 4', 1, 24000.00, 100, 0),
(17, 'Dimsum Moza - Paket B', 'Dimsum mozzarella isi 6', 1, 33000.00, 100, 0),
(18, 'Dimsum Moza - Paket Family', 'Dimsum mozzarella isi 20', 1, 104000.00, 100, 0),
(19, 'Dimsum Tartar Cheese - Paket A', 'Dimsum tartar keju isi 4', 1, 24000.00, 100, 0),
(20, 'Dimsum Tartar Cheese - Paket B', 'Dimsum tartar keju isi 6', 1, 33000.00, 100, 0),
(21, 'Dimsum Tartar Cheese - Paket Family', 'Dimsum tartar keju isi 20', 1, 104000.00, 100, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ulasan`
--

CREATE TABLE `ulasan` (
  `id` int(11) NOT NULL,
  `users_id` int(11) DEFAULT NULL,
  `produk_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `komentar` text DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'tanri indra', 'tanriindra25@gmail.com', '$2y$10$Aixyxqe482LCB0SB0.H81e7WqAGPBQNoN.6/35D.cz79KZ/pcoUWm', 'user', '2025-06-15 01:58:37'),
(2, 'Admin', 'vallingdark@gmail.com', '$2y$10$ZVAA92g8mTDdEiUamJyrC.rPbK4rt0MEG8vchO9knXThLARJTsSBW', 'admin', '2025-06-16 10:04:28'),
(3, 'akun', 'tanriindra03@gmail.com', '$2y$10$fV8Twhv.EalrsElofVpoiuMwqcZm/iu1r2s1W//ujDgy6NMkbWH6a', 'user', '2025-06-16 18:29:39');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alamat_pengiriman`
--
ALTER TABLE `alamat_pengiriman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`users_id`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`users_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indeks untuk tabel `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`users_id`),
  ADD KEY `payment_method_id` (`payment_method_id`),
  ADD KEY `alamat_pengiriman_id` (`alamat_pengiriman_id`);

--
-- Indeks untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indeks untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`users_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alamat_pengiriman`
--
ALTER TABLE `alamat_pengiriman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `alamat_pengiriman`
--
ALTER TABLE `alamat_pengiriman`
  ADD CONSTRAINT `alamat_pengiriman_fk_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_fk_produk` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `keranjang_fk_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`payment_method_id`) REFERENCES `metode_pembayaran` (`id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`alamat_pengiriman_id`) REFERENCES `alamat_pengiriman` (`id`);

--
-- Ketidakleluasaan untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`);

--
-- Ketidakleluasaan untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_fk_kategori` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  ADD CONSTRAINT `ulasan_fk_produk` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ulasan_fk_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
