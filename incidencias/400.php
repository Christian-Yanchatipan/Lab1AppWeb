<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit;
}

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit;
}

http_response_code(400);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código 400</title>
</head>
<body>
    <h1>Error 400 – Bad request</h1>
    <h2>Usuario actual: <?php echo ($_SESSION['nombre_usuario']); ?></h2>
    <a href="registrar.php">Volver al formulario</a>
    <a href="listar.php">Volver al listado</a>
    <a href="cerrar_sesion.php">Cerrar Sesión</a>
</body>
</html>