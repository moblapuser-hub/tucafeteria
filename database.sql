CREATE DATABASE IF NOT EXISTS cafeteria_db;
USE cafeteria_db;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  wallet DECIMAL(10,2) DEFAULT 0
);

CREATE TABLE items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  category VARCHAR(50),
  price DECIMAL(10,2)
);

CREATE TABLE cart (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_email VARCHAR(100),
  item_id INT,
  qty INT DEFAULT 1
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_email VARCHAR(100),
  total DECIMAL(10,2),
  status VARCHAR(30) DEFAULT 'Pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  item_name VARCHAR(100),
  price DECIMAL(10,2),
  qty INT
);

CREATE TABLE admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE,
  password VARCHAR(255)
);

INSERT INTO admin (username, password) VALUES ('admin', 'admin123');

INSERT INTO items (name, category, price) VALUES
('Paratha with Egg','Breakfast',120),
('Halwa Puri','Breakfast',150),
('Bread Omelette','Breakfast',100),
('Chicken Biryani','Lunch',250),
('Beef Pulao','Lunch',280),
('Daal Chawal','Lunch',180),
('Samosa','Snacks',40),
('French Fries','Snacks',120),
('Spring Roll','Snacks',80),
('Tea','Drinks',50),
('Coffee','Drinks',100),
('Cold Drink','Drinks',80);

-- Wallet transactions (for deposit reference tracking)
CREATE TABLE IF NOT EXISTS wallet_txn (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_email VARCHAR(100) NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  method VARCHAR(50) NOT NULL,
  reference_no VARCHAR(80) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
