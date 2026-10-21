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
    ('carlos',  'Carlos123',  'Carlos Mendoza'),
    ('ana',     'Ana123',     'Ana Ruiz'),
    ('luis',    'Luis123',    'Luis Paredes'),
    ('sofia',   'Sofia123',   'Sofia Herrera'),
    ('jorge',   'Jorge123',   'Jorge Castillo'),
    ('lucia',   'Lucia123',   'Lucia Vega'),
    ('diego',   'Diego123',   'Diego Morales'),
    ('valeria', 'Valeria123', 'Valeria Ramos');

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

-- INCIDENCIAS DE CARLOS
INSERT INTO incidencia
    (nombre, descripcion, prioridad, id_usuario)
SELECT
    'Lentitud en el sistema de inventario',
    'Las consultas de inventario tardan mas de un minuto en cargar.',
    'media',
    id_usuario
FROM usuario
WHERE username = 'carlos';

-- INCIDENCIAS DE ANA
INSERT INTO incidencia
    (nombre, descripcion, prioridad, id_usuario)
SELECT
    'No llegan correos de notificacion',
    'Los correos de confirmacion de pedidos no se envian a los clientes.',
    'alta',
    id_usuario
FROM usuario
WHERE username = 'ana';

-- INCIDENCIAS DE LUIS
INSERT INTO incidencia
    (nombre, descripcion, prioridad, id_usuario)
SELECT
    'Error al exportar a Excel',
    'Al exportar el reporte de ventas el archivo se descarga vacio.',
    'media',
    id_usuario
FROM usuario
WHERE username = 'luis';

-- INCIDENCIAS DE SOFIA
INSERT INTO incidencia
    (nombre, descripcion, prioridad, id_usuario)
SELECT
    'Cuenta de usuario bloqueada',
    'Despues de tres intentos fallidos la cuenta queda bloqueada y no se puede desbloquear.',
    'alta',
    id_usuario
FROM usuario
WHERE username = 'sofia';

-- INCIDENCIAS DE JORGE
INSERT INTO incidencia
    (nombre, descripcion, prioridad, id_usuario)
SELECT
    'Fechas incorrectas en reportes',
    'Los reportes mensuales muestran la fecha del dia anterior.',
    'baja',
    id_usuario
FROM usuario
WHERE username = 'jorge';

-- INCIDENCIAS DE LUCIA
INSERT INTO incidencia
    (nombre, descripcion, prioridad, id_usuario)
SELECT
    'Cambio de color del menu',
    'Se solicita cambiar el color del menu principal para mejorar la lectura.',
    'baja',
    id_usuario
FROM usuario
WHERE username = 'lucia';