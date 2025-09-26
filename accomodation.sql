CREATE DATABASE IF NOT EXISTS rbnb_db
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE rbnb_db;

CREATE TABLE accommodation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    address VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    available BOOLEAN DEFAULT TRUE,
    imageUrl VARCHAR(255)
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    rol ENUM('user', 'admin') NOT NULL DEFAULT 'user'
);

CREATE TABLE books (
    id_books INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_accommodation INT NOT NULL,
    reservation BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   
    CONSTRAINT fk_books_user FOREIGN KEY (id_user)
        REFERENCES users(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
   
    CONSTRAINT fk_books_accommodation FOREIGN KEY (id_accommodation)
        REFERENCES accommodation(id)
        ON DELETE CASCADE ON UPDATE CASCADE
);
