<?php
// 1. Iniciar la sesión siempre al principio
session_start();

// 2. Traer la conexión y la clase BaseDatos
require_once 'conexion.php';

$baseDatos = new BaseDatos();

$mensaje_error = "";

// 3. Verificar si el formulario fue enviado
if (isset($_POST['username']) && isset($_POST['password'])) {
    
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // 4. Usar el método de tu clase para buscar al usuario
    // (La variable $baseDatos ya existe gracias al require_once)
    $resultado = $baseDatos->consultarUsuario($user);

    // 5. Validar si la base de datos devolvió algún registro (si el usuario existe)
    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();

        // 6. Verificar que la contraseña ingresada coincida con la de la base de datos
        if ($pass === $fila['password']) {
            
            // 7. Crear la sesión para guardar la información del usuario autenticado
            $_SESSION['id_usuario'] = $fila['id_usuario'];
            $_SESSION['nombre_usuario'] = $fila['nombre'];

            // 8. Redirigir al fichero listar.php si el usuario es autenticado
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
                    <br>
                    <input type ="text" name = "username" value ="" >
                    <br>
                    
                    <h2> Clave </h2>
                    <br>
                    <input type ="password" name = "password" value ="" >
                    <br>
                    <br>
                    <input type ="submit" value = "Ingresar">    
                </fieldset>
            </form>

        </body>
</html>