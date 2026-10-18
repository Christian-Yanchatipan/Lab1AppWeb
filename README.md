# Sistema de Tickets - Guía de Desarrollo y Base de Datos

Este documento contiene las consideraciones y reglas necesarias para trabajar de forma colaborativa y evitar conflictos en el código del proyecto **Sistema de Tickets**. 

Actualmente ya contamos con la base de datos `incidencias_db` en MySQL (XAMPP), las tablas `usuario` e `incidencia`, el script `database.sql` y el archivo de conexión `conexion.php`.

---

## ⚙️ 1. Configuración Local (Entorno de Desarrollo)
Cada integrante debe preparar su entorno local antes de iniciar:
* Asegúrate de tener **XAMPP y MySQL** en ejecución.
* Importa el archivo `database.sql` en tu servidor local.
* Verifica que el puerto y las credenciales de tu servidor coincidan con los valores de `conexion.php`. *(Si necesitas usar un puerto distinto, ajusta tu configuración local y avisa al equipo).*

## 🔌 2. Conexión a la Base de Datos
Los parámetros de conexión centralizados son los siguientes:
* **Servidor:** `127.0.0.1`
* **Puerto:** `3307`
* **Base de datos:** `incidencias_db`
* **Usuario local:** `root`
* **Contraseña local:** *(vacía, según configuración estándar de XAMPP)*

⚠️ **Regla de oro:** No crees una conexión diferente en cada archivo. Para utilizar la conexión existente, incluye este bloque de código al inicio de tus scripts:

```php
<?php
require_once "conexion.php";
?>
```
*(Nota: Esta instrucción funciona directamente cuando el archivo está en la misma carpeta que `conexion.php`. Si tu archivo está en un subdirectorio, recuerda ajustar la ruta).*

---

## 🗄️ 3. Estructura de Tablas
Por favor, respeta **exactamente** estos nombres para evitar errores en las consultas SQL de los demás. 

### Tabla `usuario`
* `id_usuario`
* `username`
* `password`
* `nombre`

### Tabla `incidencia`
* `id_incidencia`
* `nombre` *(Título de la incidencia)*
* `descripcion`
* `prioridad` *(Valores permitidos: `alta`, `media`, `baja`)*
* `id_usuario`

---

## 🚀 4. Lógica y Reglas de Negocio

### Inicio de Sesión y Listado
* **Autenticación:** El inicio de sesión debe consultar la tabla `usuario`.
* **Sesiones:** Una vez autenticado el usuario, el sistema debe conservar su identificación mediante las variables de sesión de PHP (`$_SESSION`).
* **Filtro de privacidad:** El listado debe mostrar **únicamente** las incidencias del usuario que inició sesión. Utiliza el `id_usuario` correspondiente para filtrar; no muestres todas las incidencias indiscriminadamente.

### Registro de Incidencias
* Al crear una incidencia, asegúrate de guardar la prioridad asignada y de relacionarla con el usuario que la está registrando a través del campo `id_usuario`.

### Manejo de Errores y Pruebas
* Si una operación de la base de datos falla, debes manejar el error y mostrar una respuesta controlada.
* Los códigos de estado (ej. `201`, `400`, `500`) deben enviarse como **estados HTTP reales** a través de las cabeceras, no solamente imprimirse como texto en el cuerpo de la página.

---
**🛑 IMPORTANTE:** Antes de modificar `conexion.php`, alterar el esquema de la base de datos o cambiar los nombres de las tablas/campos, **comunícalo y coordínalo primero con el grupo**. Esto evitará que los archivos de los demás dejen de funcionar.