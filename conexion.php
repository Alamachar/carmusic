<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "musica"; // Reemplazar con el nombre de usuario de la base de datos
$password = "1234"; // Reemplazar con la contraseña de la base de datos
$database = "carmusic"; // Reemplazar con el nombre de la base de datos

// Crear conexión
$conexion = mysqli_connect($servername, $username, $password, $database);

// Verificar la conexión
if (!$conexion) {
    die("La conexión a la base de datos ha fallado: " . mysqli_connect_error());
}
?>
