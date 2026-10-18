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

-- USUARIOS 
INSERT INTO usuario (username, password, nombre)
VALUES
    ('pedro', 'Pedro123', 'Pedro Lopez'),
    ('maria', 'Maria123', 'Maria Torres');

-- INCIDENCIAS DE PEDRO
INSERT INTO incidencia
    (nombre, descripcion, prioridad, id_usuario)
SELECT
    'Error en facturacion',
    'El total de la factura no coincide con los detalles.',
    'alta',
    id_usuario
FROM usuario
WHERE username = 'pedro';

INSERT INTO incidencia
    (nombre, descripcion, prioridad, id_usuario)
SELECT
    'Problema al imprimir',
    'El sistema no permite imprimir el reporte.',
    'media',
    id_usuario
FROM usuario
WHERE username = 'pedro';

-- INCIDENCIAS DE MARIA
INSERT INTO incidencia
    (nombre, descripcion, prioridad, id_usuario)
SELECT
    'Error al iniciar el sistema',
    'La aplicacion muestra un error al ingresar.',
    'alta',
    id_usuario
FROM usuario
WHERE username = 'maria';

INSERT INTO incidencia
    (nombre, descripcion, prioridad, id_usuario)
SELECT
    'Solicitud de mejora',
    'Se solicita mejorar la presentacion de los reportes.',
    'baja',
    id_usuario
FROM usuario
WHERE username = 'maria';