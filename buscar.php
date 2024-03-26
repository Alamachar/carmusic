<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="styles-light.css" id="theme">
</head>
<body>
<button onclick="toggleTheme()">Cambiar Tema</button>

<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Verificar si se ha enviado una consulta de búsqueda
if(isset($_GET['search']) && !empty($_GET['search'])){
    $search = $_GET['search'];

    // Consulta SQL para obtener las canciones que coinciden con el término de búsqueda
    $consulta = "SELECT nomcancion, nomcd, numcd FROM canciones 
                 WHERE nomcancion LIKE '%$search%'
                 OR nomcd LIKE '%$search%'
                 OR numcd LIKE '%$search%'";

    $resultado = mysqli_query($conexion, $consulta);

    // Verificar si hay resultados
    if (mysqli_num_rows($resultado) > 0) {
        // Mostrar los resultados en forma de tabla
        echo "<a href='index.php'>Volver a la página principal</a>";

        echo "<table>";
        echo "<tr><th>Nombre de la Canción</th><th>Disco</th><th>Número de CD</th></tr>";
        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>{$fila['nomcancion']}</td>";
            echo "<td>{$fila['nomcd']}</td>";
            echo "<td>{$fila['numcd']}</td>";
            echo "</tr>";
        }
        echo "</table>";

    } else {
        echo "No se encontraron resultados para la búsqueda: $search";
        echo "<a href='index.php'>Volver a la página principal</a>";

    }
} else {
    echo "No se ha especificado un término de búsqueda.";
    echo "<a href='index.php'>Volver a la página principal</a>";

}

// Cerrar la conexión
mysqli_close($conexion);
?>
<script>
        function toggleTheme() {
            // Obtiene el elemento link que enlaza al CSS
            var theme = document.getElementById('theme');

            // Comprueba si el tema actual es claro o no
            if (theme.getAttribute('href') === 'styles-light.css') {
                // Cambia al tema oscuro
                theme.setAttribute('href', 'styles-dark.css');
            } else {
                // Cambia al tema claro
                theme.setAttribute('href', 'styles-light.css');
            }
        }
    </script>
</body>
</html>


