
<?php
class BaseDatos {
    private $servidor = "127.0.0.1";
    private $usuario = "root";
    private $contrasena = "";
    private $nombreBaseDatos = "incidencias_db";
    private $puerto = 3307;

    public function conectar() {
        $conexion = new mysqli(
            $this->servidor,
            $this->usuario,
            $this->contrasena,
            $this->nombreBaseDatos,
            $this->puerto
        );

        if ($conexion->connect_error) {
            die("Error al conectar con la base de datos.");
        }

        $conexion->set_charset("utf8mb4");

        return $conexion;
    }
}

// Crear el objeto y establecer la conexión
$baseDatos = new BaseDatos();
$conexion = $baseDatos->conectar();
?>

