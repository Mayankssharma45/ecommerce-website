-- Database for E-Shop (Bootstrap Option B)
CREATE DATABASE IF NOT EXISTS ecommerce_boot;
USE ecommerce_boot;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  price INT NOT NULL,
  description TEXT,
  category VARCHAR(100),
  image VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  product_id INT NOT NULL,
  quantity INT NOT NULL,
  order_date DATETIME,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (product_id) REFERENCES products(id)
);

INSERT INTO products (name, price, description, category) VALUES
('Running Shoes', 1999, 'Comfortable running shoes for daily use.', 'Footwear'),
('Classic Watch', 3499, 'Stylish analog watch with leather strap.', 'Accessories'),
('Backpack', 1299, 'Durable backpack with multiple compartments.', 'Bags');
