-- ============================================
-- DATABASE SETUP UNTUK PROJECT E-COMMERCE
-- ============================================
-- Nama Database: projectpbw
-- ============================================

-- 1. TABEL USERS (Untuk Admin & Customer)
-- ============================================
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `is_admin` int(11) DEFAULT 0,
  `tanggal_daftar` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 2. TABEL PRODUK (Untuk Data Produk)
-- ============================================
CREATE TABLE IF NOT EXISTS `produk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `spesifikasi` json DEFAULT NULL,
  `tanggal_upload` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `kategori` (`kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 3. TABEL ORDERS (Untuk Pesanan Customer)
-- ============================================
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(255) NOT NULL,
  `alamat_lengkap` text NOT NULL,
  `nomor_telepon` varchar(20) NOT NULL,
  `produk_dipesan` text NOT NULL,
  `ukuran` varchar(50) DEFAULT NULL,
  `metode_pembayaran` varchar(100) NOT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `tanggal_pesan` timestamp DEFAULT CURRENT_TIMESTAMP,
  `total_harga` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nama_lengkap` (`nama_lengkap`),
  KEY `tanggal_pesan` (`tanggal_pesan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- DATA SAMPLE (OPTIONAL - Bisa dihapus)
-- ============================================

-- Insert Sample Admin User
-- Email: admin@example.com
-- Password: admin123 (MD5 hash akan dijalankan di PHP)
INSERT INTO `users` (`id`, `nama_lengkap`, `email`, `password`, `is_admin`, `tanggal_daftar`) 
VALUES (1, 'Admin Josia', 'admin@example.com', '$2y$10$Y6w0Nri3V7QFGz5K9VxZJOqGVx8VfVqVx8VfVqVx8VfVqVx8VfVqVx', 1, CURRENT_TIMESTAMP)
ON DUPLICATE KEY UPDATE id=id;

-- Insert Sample Products
INSERT INTO `produk` (`id`, `nama`, `harga`, `stok`, `kategori`, `deskripsi`, `spesifikasi`, `tanggal_upload`) 
VALUES 
(1, 'Kaos Hitam Premium', 75000, 50, 'Pakaian', 'Kaos hitam berkualitas premium dengan bahan katun 100%', '{\"bahan\": \"Katun 100%\", \"ukuran\": \"M, L, XL\", \"warna\": \"Hitam\"}', CURRENT_TIMESTAMP),
(2, 'Hoodie Putih Nyaman', 150000, 30, 'Pakaian', 'Hoodie putih nyaman dengan material fleece', '{\"bahan\": \"Fleece\", \"ukuran\": \"M, L, XL, XXL\", \"warna\": \"Putih\"}', CURRENT_TIMESTAMP),
(3, 'Celana Jeans Biru', 200000, 20, 'Pakaian', 'Celana jeans biru dengan desain modern', '{\"bahan\": \"Denim\", \"ukuran\": \"28-34\", \"warna\": \"Biru\"}', CURRENT_TIMESTAMP)
ON DUPLICATE KEY UPDATE id=id;

-- ============================================
-- VERIFIKASI TABEL
-- ============================================
-- Untuk memverifikasi, jalankan query ini:
-- SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'projectpbw';
-- 
-- Output yang diharapkan:
-- | TABLE_NAME |
-- |------------|
-- | users      |
-- | produk     |
-- | orders     |
