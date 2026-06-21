-- PuspusPerpus Database Schema
-- Run this script in your MySQL Database tool (e.g. phpMyAdmin, MySQL Workbench, or Command Line)

CREATE DATABASE IF NOT EXISTS puspusperpus;
USE puspusperpus;

-- 1. Table users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Table categories
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Table books
CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    publisher VARCHAR(255) NOT NULL,
    publication_year INT NOT NULL,
    category_id INT NOT NULL,
    status ENUM('Tersedia', 'Dipinjam') NOT NULL DEFAULT 'Tersedia',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed default categories
INSERT INTO categories (id, name) VALUES 
(1, 'Sains & Teknologi'),
(2, 'Sastra & Novel'),
(3, 'Sejarah & Filsafat'),
(4, 'Pengembangan Diri'),
(5, 'Komik & Hiburan')
ON DUPLICATE KEY UPDATE name=name;

-- Seed default books
INSERT INTO books (id, title, author, publisher, publication_year, category_id, status) VALUES
(1, 'Dasar Pemrograman Web dengan PHP', 'Rian Hidayat', 'Informatika', 2024, 1, 'Tersedia'),
(2, 'Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', 2005, 2, 'Tersedia'),
(3, 'Sebuah Seni untuk Bersikap Bodo Amat', 'Mark Manson', 'Gramedia', 2018, 4, 'Dipinjam'),
(4, 'Sapiens: Sejarah Singkat Umat Manusia', 'Yuval Noah Harari', 'Harper', 2014, 3, 'Tersedia')
ON DUPLICATE KEY UPDATE title=title;
