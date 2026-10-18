<?php

class BaseDatos {

    private $servidor = "127.0.0.1";
    private $usuario = "root";
    private $contrasena = "";
    private $nombreBaseDatos = "incidencias_db";
    private $puerto = 3307;

    private $conexion;

    // Conectar con MySQL
    public function conectar() {

        $this->conexion = new mysqli(
            $this->servidor,
            $this->usuario,
            $this->contrasena,
            $this->nombreBaseDatos,
            $this->puerto
        );

        if ($this->conexion->connect_error) {
            die("Error al conectar con la base de datos.");
        }

        $this->conexion->set_charset("utf8mb4");

        return $this->conexion;
    }

    // Consultar un usuario por su nombre de usuario
    public function consultarUsuario($username) {

        $sql = "SELECT * FROM usuario WHERE username = ?";

        $consulta = $this->conexion->prepare($sql);
        $consulta->bind_param("s", $username);
        $consulta->execute();

        return $consulta->get_result();
    }

    // Listar las incidencias de un usuario
    public function listarIncidencias($id_usuario) {

        $sql = "SELECT * FROM incidencia WHERE id_usuario = ?";

        $consulta = $this->conexion->prepare($sql);
        $consulta->bind_param("i", $id_usuario);
        $consulta->execute();

        return $consulta->get_result();
    }

    // Consultar una incidencia específica de un usuario
    public function obtenerIncidencia($id_incidencia, $id_usuario) {

        $sql = "SELECT * FROM incidencia
                WHERE id_incidencia = ? AND id_usuario = ?";

        $consulta = $this->conexion->prepare($sql);
        $consulta->bind_param("ii", $id_incidencia, $id_usuario);
        $consulta->execute();

        return $consulta->get_result();
    }

    // Insertar una incidencia
    public function insertarIncidencia(
        $nombre,
        $descripcion,
        $prioridad,
        $id_usuario
    ) {

        $sql = "INSERT INTO incidencia
                (nombre, descripcion, prioridad, id_usuario)
                VALUES (?, ?, ?, ?)";

        $consulta = $this->conexion->prepare($sql);

        $consulta->bind_param(
            "sssi",
            $nombre,
            $descripcion,
            $prioridad,
            $id_usuario
        );

        return $consulta->execute();
    }
}

// Crear la clase y conectar con la base de datos
$baseDatos = new BaseDatos();
$conexion = $baseDatos->conectar();

?>
