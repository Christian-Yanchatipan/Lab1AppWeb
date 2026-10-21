<?php

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit;
}

require_once "conexion.php";

$idUsuario = $_SESSION['id_usuario'];
$nombreUsuario = $_SESSION['nombre'];

$resultado = $baseDatos->listarIncidencias($idUsuario);

?>

<html>
    <head>
    </head>
    <body>
        <h1>Sistema de Incidencias</h1>
        <h3>Bienvenido: <?php echo $_SESSION['nombre'] ?> </h3>
         <h2> Lista de Incidencias </h2>
         
         <ul>
            
            <?php while ($fila = $resultado->fetch_assoc()){?>
                <li> 
                    <form method="POST" action="detalle.php">
                        <?php echo $fila['id_incidencia']?> 
                        <input type="hidden" name="id" value="<?php echo $fila['id_incidencia']?>">
                        <input type="submit" value="<?php echo $fila['nombre']?>">
                    </form>
                </li>
            <?php
            }?>
        </ul>

        <h2>Añadir nueva Incidencia</h2>
        <p><a href="registrar.php">Registrar nueva incidencia</a></p>
        <p><a href="cerrarsesion.php">Cerrar Sesion</a></p>
     </body>
</html>

