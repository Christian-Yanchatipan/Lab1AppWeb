<?php
#session_start();
#if(!isset($_SESSION['nombre']) || !isset($_SESSION['clave'])){
#    header("Location: index.php");
#    exit;
#}




if($_SERVER["REQUEST_METHOD"] == 'POST'){

    $nombre = is_string($_POST['nombre'] ?? null) ? trim($_POST['nombre']) : '';

    if($nombre === '' || preg_match('/[$\\\\=]/', $nombre)){
        header('Location: 400.php');
        exit;
    }

    $descripcion = is_string($_POST['descripcion']??null)? trim($_POST['descripcion']):'';
    if ($descripcion === '' || preg_match('/[$\[\]\\\\=]/', $descripcion)){
        header('Location: 400.php');
        exit;
    }

    $prioridad = $_POST['prioridad'] ?? '';

    if(!in_array($prioridad, ['Alta', 'Media', 'Baja'], true)){
        header('Location: 400.php');
        exit;
    }
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

<!-- <h2>Usuario Logeado: <?php #echo $_SESSION['nombre']; ?></h2> -->
    <h1>Registro de Incidencia</h1>
    <p><a href="cerrar_sesion.php">Cerrar Sesión</a></p>
    <a href="listar.php">Volver al listado</a>
    <br>
    <br>
    <form action="registrar.php" method="POST">
        <fieldset>
                
            <label for= "nombre"> Nombre: </label>
            <input type = "text" id = "nombre" name = "nombre"
            required pattern="[^$\\=]+" 
            title = "El campo nombre no admite caracteres $ \ ="><br><br>


            <label for = "descripcion"> Descripción: </label>
            <input type = "text" id= "descripcion" name = "descripcion"
            required pattern = "[^$\[\]\\=]+" 
            title ="El campo descripción no admite caracteres $ [ ] \ =">

            <label for="cmbPrioridad">Prioridad: </label>
            <select name="prioridad" id="cmbPrioridad" required>
                <option value = ""> </option>
                <option value="Alta">Alta</option>
                <option value ="Media"> Media </option>
                <option value = "Baja"> Baja </option>
            </select>
            <input type = "submit" value = "Enviar">
        </fieldset>    
    </form>
</body>
</html>


