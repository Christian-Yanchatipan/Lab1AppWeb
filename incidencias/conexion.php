<?php
$servidor = "127.0.0.1";
$usuario = "root";
$password = "";
$baseDatos = "incidencias_db";
$puerto = 3307;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conexion = new mysqli(
        $servidor,
        $usuario,
        $password,
        $baseDatos,
        $puerto
    );

    $conexion->set_charset("utf8mb4");

} catch (mysqli_sql_exception $e) {
    error_log("Error de conexión MySQL: " . $e->getMessage());

    http_response_code(500);
    exit("No se pudo conectar con la base de datos.");
}
?>
