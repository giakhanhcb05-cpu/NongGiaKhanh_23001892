SET NAMES utf8mb4;
CREATE DATABASE IF NOT EXISTS buoi8_products CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE buoi8_products;

DROP TABLE IF EXISTS products;
CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  price INT NOT NULL CHECK (price > 0),
  stock INT NOT NULL CHECK (stock >= 0)
) CHARACTER SET utf8mb4;

INSERT INTO products (name, price, stock) VALUES
('Bút bi', 5000, 20),
('Vở ô ly', 12000, 15),
('Thước kẻ', 8000, 0);
