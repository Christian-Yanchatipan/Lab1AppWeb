CREATE DATABASE IF NOT EXISTS incidencias_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE incidencias_db;

CREATE TABLE IF NOT EXISTS usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nombre VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS incidencia (
    id_incidencia INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT NOT NULL,
    prioridad ENUM('alta', 'media', 'baja') NOT NULL,
    id_usuario INT NOT NULL,
    CONSTRAINT fk_incidencia_usuario
        FOREIGN KEY (id_usuario)
        REFERENCES usuario(id_usuario)
);
