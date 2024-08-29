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

--añadir un "activo" en la tabla servicios
ALTER TABLE servicios ADD COLUMN available BOOLEAN DEFAULT TRUE;

--manejar eliminacion en cascada
ALTER TABLE reservas
DROP FOREIGN KEY reservas_ibfk_2;

ALTER TABLE reservas
ADD CONSTRAINT reservas_ibfk_2
FOREIGN KEY (service_id) REFERENCES servicios(id)
ON DELETE CASCADE;

--tabla de contactos para almacenar los mensajes
CREATE TABLE IF NOT EXISTS contactos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    asunto VARCHAR(150) NOT NULL,
    mensaje TEXT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--tabla para mascotas
CREATE TABLE IF NOT EXISTS mascotas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    especie VARCHAR(50) NOT NULL,
    raza VARCHAR(50),
    edad INT,
    peso DECIMAL(5, 2),
    dueño_id INT,
    historial_medico TEXT,
    FOREIGN KEY (dueño_id) REFERENCES users(id) ON DELETE CASCADE
);
