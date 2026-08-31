-- Active: 1787978646222@@127.0.0.1@3306@db_kantin

-- Buat tabel suppliers
CREATE TABLE IF NOT EXISTS `suppliers` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(50) DEFAULT NULL,
    `address` TEXT DEFAULT NULL,
    `note` TEXT DEFAULT NULL,
    `created_at` DATETIME DEFAULT NULL,
    `updated_at` DATETIME DEFAULT NULL,
    `deleted_at` DATETIME DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tambah kolom supplier_id ke tabel products
-- Jalankan perintah ini HANYA jika kolom belum ada:
-- Cek dulu: SHOW COLUMNS FROM products LIKE 'supplier_id';
-- Jika hasilnya kosong, jalankan:
ALTER TABLE `products` ADD COLUMN `supplier_id` INT DEFAULT NULL AFTER `sell_price`;
ALTER TABLE `products` ADD COLUMN `deleted_at` INT DEFAULT NULL AFTER `created_at`;
