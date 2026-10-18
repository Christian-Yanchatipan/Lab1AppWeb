# Sistema de Tickets - Guía de Desarrollo y Base de Datos

Este documento contiene las consideraciones y reglas necesarias para trabajar de forma colaborativa y evitar conflictos en el código del proyecto **Sistema de Tickets de Incidencias Técnicas**.

Actualmente contamos con la base de datos `incidencias_db` en MySQL (XAMPP), las tablas `usuario` e `incidencia`, el script `database.sql` y el archivo `conexion.php`. El archivo `conexion.php` centraliza la conexión y contiene la clase `BaseDatos`, con métodos reutilizables para consultar usuarios e incidencias y registrar incidencias.

---

## 1. Configuración local (entorno de desarrollo)

Cada integrante debe preparar su entorno local antes de iniciar:

- Asegúrate de tener **XAMPP y MySQL** en ejecución.
- Importa el archivo `database.sql` en tu servidor local.
- Verifica que el puerto y las credenciales de tu servidor coincidan con los valores de `conexion.php`. Si necesitas usar un puerto distinto, ajusta tu configuración local y avisa al equipo.
- En este proyecto, MySQL está configurado localmente en el puerto `3307`.

## 2. Conexión a la base de datos

Los parámetros de conexión configurados actualmente son:

- **Servidor:** `127.0.0.1`
- **Puerto:** `3307`
- **Base de datos:** `incidencias_db`
- **Usuario local:** `root`
- **Contraseña local:** vacía, según la configuración local actual de XAMPP

No se debe crear una conexión independiente en cada archivo. Para utilizar la conexión y la clase definidas en `conexion.php`, incluye al principio del archivo:

```php
<?php
require_once "conexion.php";
?>
```

Esta ruta funciona cuando el archivo PHP está en la misma carpeta que `conexion.php`. Si el archivo está en un subdirectorio, se debe ajustar la ruta.

Después de incluir el archivo, estarán disponibles:

- `$conexion`: conexión activa de MySQL.
- `$baseDatos`: objeto de la clase `BaseDatos`.

Por ejemplo:

```php
<?php
require_once "conexion.php";

$resultado = $baseDatos->listarIncidencias(1);
?>
```

El valor `1` es solo ilustrativo. En el sistema real, debe usarse el `id_usuario` de la persona que inició sesión, obtenido de la sesión de PHP.

**Importante:** estas credenciales son para el entorno local académico. No deben reutilizarse tal cual en un servidor de producción.

## 3. Clase `BaseDatos` y métodos disponibles

La clase `BaseDatos` está definida en `conexion.php`. Su responsabilidad es centralizar el acceso a MySQL, evitando repetir consultas y conexiones en cada página.

Métodos disponibles:

| Método | Función |
|---|---|
| `conectar()` | Establece la conexión con MySQL. |
| `consultarUsuario($username)` | Busca un usuario por su nombre de usuario. Devuelve un resultado de consulta. |
| `listarIncidencias($id_usuario)` | Devuelve las incidencias asociadas a un usuario. |
| `obtenerIncidencia($id_incidencia, $id_usuario)` | Busca una incidencia específica y comprueba que pertenezca al usuario indicado. |
| `insertarIncidencia($nombre, $descripcion, $prioridad, $id_usuario)` | Inserta una incidencia relacionada con el usuario indicado. Devuelve `true` si la consulta se ejecuta correctamente y `false` si no. |

Ejemplo de consulta de usuario:

```php
<?php
require_once "conexion.php";

$resultado = $baseDatos->consultarUsuario("pedro");

if ($resultado && $resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();
    echo $usuario["nombre"];
}
?>
```

Ejemplo de listado de incidencias:

```php
<?php
require_once "conexion.php";

$id_usuario = 1; // Ejemplo: reemplazar por el ID guardado en la sesión
$resultado = $baseDatos->listarIncidencias($id_usuario);

while ($fila = $resultado->fetch_assoc()) {
    echo $fila["nombre"] . "<br>";
}
?>
```

Ejemplo de inserción de incidencia:

```php
<?php
require_once "conexion.php";

$correcto = $baseDatos->insertarIncidencia(
    "Error de impresión",
    "No se puede imprimir el reporte",
    "media",
    1 // Ejemplo: debe ser el ID del usuario que inició sesión
);

if ($correcto) {
    echo "Incidencia registrada correctamente.";
} else {
    echo "No se pudo registrar la incidencia.";
}
?>
```

Estos ejemplos sirven para explicar cómo llamar a los métodos. No sustituyen los formularios ni la validación que debe implementar cada página.

### Reglas para usar la clase

- No vuelvas a crear una conexión `new mysqli(...)` en otros archivos si ya estás incluyendo `conexion.php`.
- Usa los nombres exactos de los métodos y sus parámetros.
- Para consultas de incidencias, filtra por `id_usuario`; no muestres incidencias de otros usuarios.
- El `id_usuario` de un registro debe provenir del usuario autenticado, no de un valor fijo ni de un dato enviado libremente por el formulario.
- Las consultas preparadas usadas por los métodos reciben los valores como parámetros, en vez de concatenarlos directamente en el SQL.
- Si se modifica la clase o se cambia el nombre de un método, avisa al equipo antes para evitar que los demás archivos dejen de funcionar.

---

## 4. Estructura de las tablas

Respeta exactamente los nombres de las tablas y columnas para evitar errores en las consultas SQL.

### Tabla `usuario`

- `id_usuario`
- `username`
- `password`
- `nombre`

### Tabla `incidencia`

- `id_incidencia`
- `nombre` — título de la incidencia
- `descripcion`
- `prioridad` — valores previstos: `alta`, `media`, `baja`
- `id_usuario` — identifica al usuario que registró la incidencia

La relación entre `incidencia.id_usuario` y `usuario.id_usuario` permite asociar cada incidencia con su usuario.

## 5. Lógica y reglas de negocio

### Inicio de sesión y listado

- **Autenticación:** el inicio de sesión debe consultar la tabla `usuario`, por ejemplo usando `consultarUsuario($username)`.
- **Contraseña:** el código de inicio de sesión debe usar el mismo criterio de almacenamiento y validación de contraseñas que haya acordado el equipo. No se deben guardar contraseñas en texto plano en una aplicación real; para un sistema real se deben almacenar con un mecanismo seguro de hash.
- **Sesiones:** una vez autenticado el usuario, el sistema debe conservar su identificación mediante variables de sesión de PHP (`$_SESSION`).
- **Filtro de privacidad:** el listado debe mostrar únicamente las incidencias del usuario que inició sesión. Usa el `id_usuario` correspondiente para filtrar; no muestres todas las incidencias indiscriminadamente.
- **Detalle:** al consultar una incidencia, comprueba también que pertenezca al usuario autenticado.

### Registro de incidencias

- Al crear una incidencia, guarda el nombre, la descripción, la prioridad y el `id_usuario` correspondiente.
- Utiliza `insertarIncidencia(...)` para insertar el registro.
- Valida los datos recibidos del formulario antes de intentar guardar la incidencia.
- El usuario asociado debe ser el usuario autenticado en la sesión.

### Manejo de errores y códigos HTTP

- Si una operación de la base de datos falla, maneja el error y muestra una respuesta controlada.
- Los códigos de estado (por ejemplo, `201`, `400` y `500`) deben enviarse como **estados HTTP reales** mediante las cabeceras, no solamente imprimirse como texto en el cuerpo de la página.
- La clase `BaseDatos` ayuda a ejecutar operaciones de base de datos, pero cada página que procesa una solicitud debe decidir qué código HTTP corresponde y cómo responder.
- No indiques que una operación tuvo éxito si la inserción o consulta falló.

---

## 6. Coordinación del equipo

Antes de modificar `conexion.php`, cambiar los métodos de `BaseDatos`, alterar el esquema de la base de datos o cambiar los nombres de las tablas o campos, comunícalo y coordínalo primero con el grupo. Esto evita que los archivos de los demás integrantes dejen de funcionar.

Cada integrante debe comprobar que su entorno local usa los datos de conexión adecuados. Si los puertos o credenciales locales son diferentes, debe ajustar su propia configuración y avisar al equipo.

## 7. Evidencias para el informe

Guarda capturas reales de:

1. `conexion.php` mostrando la clase `BaseDatos` y sus métodos.
2. La base de datos `incidencias_db` y las tablas `usuario` e `incidencia` en phpMyAdmin.
3. La página de prueba mostrando que la conexión funciona.
4. Una consulta o inserción probada correctamente, si ya está implementada.
5. Esta conversación con ChatGPT como evidencia del apoyo de IA, indicando en el informe qué sugerencias se utilizaron y qué se probó manualmente.
Las capturas deben corresponder a tu propio entorno y a resultados que hayas comprobado. No presentes ejemplos de código como si fueran pruebas de ejecución.
