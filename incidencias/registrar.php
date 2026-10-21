<?php
session_start();

if(!isset($_SESSION['id_usuario'])){
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html >
<head>
    <title>Registrar Incidencia</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

    <h1>Registro de Incidencia</h1>
    
    <h2>Usuario Logeado: <?php echo $_SESSION['nombre_usuario']; ?></h2>
    <p><a href="cerrar_sesion.php">Cerrar Sesión</a></p>
    <a href="listar.php">Volver al listado</a>
    <br>
    <br>
    <p>Todos los campos son obligatorios.</p>
    <form action="procesar_registro.php" method="POST">
        <fieldset>
                
            <label for= "nombre"> Nombre: </label>
            <input type= "text" id= "nombre" name = "nombre">
            <br>
            <p>El campo nombre no admite caracteres $ \ =.</p>


            <label for = "descripcion"> Descripción: </label>
            <input type = "text" id= "descripcion" name = "descripcion">
            <br>
            <p>El campo descripción no admite caracteres $ [ ] \ =.</p>

            <label for="cmbPrioridad">Prioridad: </label>
            <select name="prioridad" id="cmbPrioridad">
                <option value = ""> </option>
                <option value="alta">Alta</option>
                <option value ="media"> Media </option>
                <option value = "baja"> Baja </option>
            </select>
            <input type = "submit" value = "Enviar">
        </fieldset>    
    </form>
</body>
</html>


