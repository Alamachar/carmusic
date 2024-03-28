<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Canciones</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="styles-light.css" id="theme">
</head>
<body>
    <h1>Lista de Canciones</h1>
    <button onclick="toggleTheme()">Cambiar Tema</button>
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
            <th>Artista</th> <!-- Nueva columna para el nombre del artista -->
        </tr>
        <?php
        // Incluir el archivo de conexión a la base de datos
        include 'conexion.php';

        // Consulta SQL para obtener las canciones, sus discos y el nombre del artista
        $consulta = "SELECT canciones.nomcancion, cds.nomcd, cds.numcd, artistas.nombre AS nombre_artista 
                     FROM canciones 
                     INNER JOIN cds ON canciones.id_cd = cds.id 
                     INNER JOIN artistas ON canciones.id_artista = artistas.id";

        // Verificar si se envió una consulta de búsqueda
        if(isset($_GET['search']) && !empty($_GET['search'])){
            $search = $_GET['search'];
            // Añadir filtro de búsqueda a la consulta SQL
            $consulta .= " WHERE canciones.nomcancion LIKE '%$search%'";
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
                echo "<td>{$fila['nombre_artista']}</td>"; // Mostrar el nombre del artista
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No hay canciones disponibles.</td></tr>";
        }

        // Cerrar la conexión
        mysqli_close($conexion);
        ?>
    </table>
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
