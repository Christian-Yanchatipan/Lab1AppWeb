<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit;
}

http_response_code(500);
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Error 500</title>
    </head>
    <body>
        <h1>Error 500 - Internal Server Error</h1>
        <h2>Usuario actual: <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></h2>
        <p>Ocurrió un error interno del servidor</p>

        <a href="cerrar_sesion.php">Volver al incio de sesión</a>
        
    </body>
</html>