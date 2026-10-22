<?php
session_start();

require_once 'conexion.php';

$mensaje_error = "";

if (isset($_POST['username']) && isset($_POST['password'])) {
    
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $resultado = $baseDatos->consultarUsuario($user);

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();

        if ($pass === $fila['password']) {
            
            $_SESSION['id_usuario'] = $fila['id_usuario'];
            $_SESSION['nombre_usuario'] = $fila['nombre'];

            header("Location: listar.php");
            exit(); 
            
        } else {
            $mensaje_error = "Contraseña incorrecta.";
        }
    } else {
        $mensaje_error = "El usuario no existe.";
    }
}
?>

<html>
    <head>
    </head>
        <body>

            <h1> Sistema de Tickets de Incidencias Técnicas </h1>

            <?php if($mensaje_error != ""): ?>
                <p style="color: red; font-weight: bold;"><?php echo $mensaje_error; ?></p>
            <?php endif; ?>

            <form method ="POST" action = "">
                <fieldset>
                    <h2> Usuario </h2>
                    <input type ="text" name = "username" value ="" >
                    <br>
                    
                    <h2> Clave </h2>
                    <input type ="password" name = "password" value ="" >
                    <br>
                    <br>
                    <input type ="submit" value = "Ingresar">    
                </fieldset>
            </form>

        </body>
</html>
