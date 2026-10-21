<?php

session_start();

if (!isset($_SESSION['id_usuario'])){
    header("Location: index.php");
    exit;
}
if (!isset($_SESSION['incidencia_creada'])) {
    header("Location: registrar.php");
    exit;
}

unset($_SESSION['incidencia_creada']);
http_response_code(201);

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código 201</title>
</head>
<body>
<h1>Incidencia Creada – 201 Created</h1>
    <h2>Usuario actual: <?php echo ($_SESSION['nombre_usuario']); ?></h2>

    <a href="listar.php">Volver al listado</a>
    <a href="cerrar_sesion.php">Cerrar Sesión</a>
</body>
</html>