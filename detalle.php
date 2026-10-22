<?php

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Location: index.php");
    exit;
}

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit;
}

$id = isset($_POST['id']) ? $_POST['id'] : ''; 

if (!ctype_digit($id)) {
    header("Location: listar.php");
    exit;
}
 
require_once "conexion.php";

 
$resultado = $baseDatos->obtenerIncidencia($id, $_SESSION['id_usuario']);
$incidencia = $resultado->fetch_assoc();

?>
 
<html>
    <head>
    </head>
    <body>
        <h1>Detalle de Incidencia</h1>
        <h3>Bienvenido: <?php echo $_SESSION['nombre_usuario'] ?> </h3>
        <p><a href="cerrar_sesion.php">Cerrar Sesion</a></p>
        <hr>
 
        <?php
        if ($incidencia == null) {
            echo "<p>Incidencia no encontrada.</p>";
        } else {
        ?>
            <p>ID: <?php echo $incidencia['id_incidencia'] ?></p>
            <p>Nombre: <?php echo $incidencia['nombre'] ?></p>
            <p>Descripción: <?php echo $incidencia['descripcion'] ?></p>
            <p>Prioridad: <?php echo $incidencia['prioridad'] ?></p>
        <?php
        }
        ?>
 
        <hr>
        <p><a href="listar.php">Regresar al listado</a></p>
    </body>
</html>