-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS clinica_veterinaria;

-- Seleccionar la base de datos
USE clinica_veterinaria;

-- Tabla para usuarios
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('client', 'admin') NOT NULL
);

-- Tabla para servicios
CREATE TABLE IF NOT EXISTS servicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL
);

-- Tabla para reservas
CREATE TABLE IF NOT EXISTS reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    service_id INT NOT NULL,
    reservation_date DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (service_id) REFERENCES servicios(id)
);


--admin@admin 123456
--cliente@cliente 123456
--$servername = "localhost";
--$username = "veteadmin";
--$password = "123456";
--$dbname = "clinica_veterinaria";