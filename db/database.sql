CREATE DATABASE IF NOT EXISTS taller_api;

USE taller_api;
-- Tabla de categorías
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

-- Tabla de productos
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    categoria_id INT,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
    ON DELETE SET NULL
    ON UPDATE CASCADE
);

-- Tabla de promociones
CREATE TABLE promociones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descripcion TEXT NOT NULL,
    descuento DECIMAL(5,2),
    producto_id INT,
    FOREIGN KEY (producto_id) REFERENCES productos(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);