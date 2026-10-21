<?php
session_start();

if(!isset($_SESSION['id_usuario'])){
    header("Location: index.php");
    exit;
}
require_once "conexion.php";

if($_SERVER["REQUEST_METHOD"] != 'POST'){
    header("Location: registrar.php");
    exit;
}

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

    if(!is_string($prioridad)|| !in_array($prioridad, ['alta', 'media', 'baja'], true)){
        header('Location: 400.php');
        exit;
    }

    $id_usuario = $_SESSION['id_usuario'];

    $correcto = $baseDatos->insertarIncidencia(
        $nombre,
        $descripcion,
        $prioridad,
        $id_usuario
    );

    if ($correcto){
        $_SESSION['incidencia_creada']=true;
        header("Location: 201.php");
        exit;
    } else{
        header("Location: 500.php");
        exit;
    }
}

?>