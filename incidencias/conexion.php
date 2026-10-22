<?php

// Hacer que mysqli lance excepciones en cualquier versión de PHP,
// para capturarlas siempre de la misma forma con try/catch.
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

class BaseDatos {

    private $servidor = "127.0.0.1";
    private $usuario = "root";
    private $contrasena = "";
    private $nombreBaseDatos = "incidencias_db";
    private $puerto = 3307;

    private $conexion = null;

    // Conectar con MySQL. Devuelve la conexión o false si falla.
    public function conectar() {
        try {
            $this->conexion = new mysqli(
                $this->servidor,
                $this->usuario,
                $this->contrasena,
                $this->nombreBaseDatos,
                $this->puerto
            );

            $this->conexion->set_charset("utf8mb4");

            return $this->conexion;

        } catch (mysqli_sql_exception $e) {
            error_log("Error de conexion: " . $e->getMessage());
            $this->conexion = null;
            return false;
        }
    }

    // Indica si hay una conexión activa
    public function estaConectado() {
        return $this->conexion !== null;
    }

    // Consultar un usuario por su nombre de usuario
    public function consultarUsuario($username) {

        if (!$this->estaConectado()) {
            return false;
        }

        try {
            $sql = "SELECT * FROM usuario WHERE username = ?";

            $consulta = $this->conexion->prepare($sql);
            $consulta->bind_param("s", $username);
            $consulta->execute();

            return $consulta->get_result();

        } catch (mysqli_sql_exception $e) {
            error_log("Error en consultarUsuario: " . $e->getMessage());
            return false;
        }
    }

    // Listar las incidencias de un usuario
    public function listarIncidencias($id_usuario) {

        if (!$this->estaConectado()) {
            return false;
        }

        try {
            $sql = "SELECT * FROM incidencia WHERE id_usuario = ?";

            $consulta = $this->conexion->prepare($sql);
            $consulta->bind_param("i", $id_usuario);
            $consulta->execute();

            return $consulta->get_result();

        } catch (mysqli_sql_exception $e) {
            error_log("Error en listarIncidencias: " . $e->getMessage());
            return false;
        }
    }

    // Consultar una incidencia específica de un usuario
    public function obtenerIncidencia($id_incidencia, $id_usuario) {

        if (!$this->estaConectado()) {
            return false;
        }

        try {
            $sql = "SELECT * FROM incidencia
                    WHERE id_incidencia = ? AND id_usuario = ?";

            $consulta = $this->conexion->prepare($sql);
            $consulta->bind_param("ii", $id_incidencia, $id_usuario);
            $consulta->execute();

            return $consulta->get_result();

        } catch (mysqli_sql_exception $e) {
            error_log("Error en obtenerIncidencia: " . $e->getMessage());
            return false;
        }
    }

    // Insertar una incidencia. Devuelve true si se guardó, false si falló.
    public function insertarIncidencia(
        $nombre,
        $descripcion,
        $prioridad,
        $id_usuario
    ) {

        if (!$this->estaConectado()) {
            return false;
        }

        try {
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

        } catch (mysqli_sql_exception $e) {
            error_log("Error en insertarIncidencia: " . $e->getMessage());
            return false;
        }
    }
}

// Crear la clase y conectar con la base de datos
// ($conexion será false si no se pudo conectar)
$baseDatos = new BaseDatos();
$conexion = $baseDatos->conectar();
?>