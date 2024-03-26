<?php
//mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Canciones</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Lista de Canciones</h1>
    <form action="buscar.php" method="GET">
        <label for="search">Buscar canción:</label>
        <input type="text" id="search" name="search">
        <button type="submit">Buscar</button>
    </form>
    <table>
        <tr>
            <th>Nombre de la Canción</th>
            <th>Disco</th>
            <th>Número de CD</th>
        </tr>
        <?php

        // Consulta SQL para obtener las canciones y sus discos
        $consulta = "SELECT nomcancion, nomcd, numcd FROM canciones";

        // Verificar si se envió una consulta de búsqueda
        if(isset($_GET['search']) && !empty($_GET['search'])){
            $search = $_GET['search'];
            // Añadir filtro de búsqueda a la consulta SQL
            $consulta .= " WHERE nomcancion LIKE '%$search%'";
        }

        $resultado = mysqli_query($conexion, $consulta);

        // Verificar si hay resultados
        if (mysqli_num_rows($resultado) > 0) {
            // Mostrar los resultados en forma de tabla
            while ($fila = mysqli_fetch_assoc($resultado)) {
                echo "<tr>";
                echo "<td>{$fila['nomcancion']}</td>";
                echo "<td>{$fila['nomcd']}</td>";
                echo "<td>{$fila['numcd']}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No hay canciones disponibles.</td></tr>";
        }

        // Cerrar la conexión
        mysqli_close($conexion);
        ?>
    </table>
</body>
</html>
