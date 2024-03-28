<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Canción</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="styles-light.css" id="theme">
</head>
<body>
    <h1>Añadir Nueva Canción</h1>
    <button onclick="toggleTheme()">Cambiar Tema</button>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="nombre_cancion">Nombre de la Canción:</label>
        <input type="text" id="nombre_cancion" name="nombre_cancion" required><br><br>
        
        <label for="nombre_artista">Nombre del Artista:</label>
        <input type="text" id="nombre_artista" name="nombre_artista" required><br><br>
        
        <label for="nombre_cd">Nombre del CD:</label>
        <input type="text" id="nombre_cd" name="nombre_cd" required><br><br>
        
        <label for="numero_cd">Número de CD:</label>
        <input type="number" id="numero_cd" name="numero_cd" required><br><br>
        
        <button type="submit" name="submit">Agregar Canción</button>
    </form>

    <?php
    // Verificar si se han enviado los datos del formulario
    if(isset($_POST['submit'])) {
       // Incluir el archivo de conexión a la base de datos
    include 'conexion.php';

        if(isset($_POST['nombre_cancion'], $_POST['nombre_artista'], $_POST['nombre_cd'], $_POST['numero_cd'])) {
            // Recuperar los datos del formulario
            $nombre_cancion = $_POST['nombre_cancion'];
            $nombre_artista = $_POST['nombre_artista'];
            $nombre_cd = $_POST['nombre_cd'];
            $numero_cd = $_POST['numero_cd'];

            // Verificar si el artista ya existe en la tabla de artistas
            $sql_artista = "SELECT id FROM artistas WHERE nombre = '$nombre_artista'";
            $result_artista = $conexion->query($sql_artista);

            if ($result_artista->num_rows > 0) {
                // El artista ya existe en la tabla, obtenemos su id
                $row_artista = $result_artista->fetch_assoc();
                $id_artista = $row_artista["id"];
            } else {
                // El artista no existe, lo insertamos en la tabla de artistas
                $sql_insert_artista = "INSERT INTO artistas (nombre) VALUES ('$nombre_artista')";
                if ($conexion->query($sql_insert_artista) === TRUE) {
                    $id_artista = $conexion->insert_id;
                } else {
                    echo "Error al insertar el artista: " . $conexion->error;
                    exit();
                }
            }

            // Verificar si el CD ya existe en la tabla de CDs
            $sql_cd = "SELECT id FROM cds WHERE nomcd = '$nombre_cd' AND numcd = $numero_cd";
            $result_cd = $conexion->query($sql_cd);

            if ($result_cd->num_rows > 0) {
                // El CD ya existe en la tabla, obtenemos su id
                $row_cd = $result_cd->fetch_assoc();
                $id_cd = $row_cd["id"];
            } else {
                // El CD no existe, lo insertamos en la tabla de CDs
                $sql_insert_cd = "INSERT INTO cds (nomcd, numcd) VALUES ('$nombre_cd', $numero_cd)";
                if ($conexion->query($sql_insert_cd) === TRUE) {
                    $id_cd = $conexion->insert_id;
                } else {
                    echo "Error al insertar el CD: " . $conexion->error;
                    exit();
                }
            }

            // Insertar datos en la tabla de canciones
            $sql_insert_cancion = "INSERT INTO canciones (nomcancion, id_cd, id_artista) VALUES ('$nombre_cancion', $id_cd, $id_artista)";

            if ($conexion->query($sql_insert_cancion) === TRUE) {
                echo "La canción se ha agregado correctamente. <br>";
                echo "<a href='index.php'>Volver a la página principal</a>";
            } else {
                echo "Error al agregar la canción: " . $conexion->error;
            }
        } else {
            echo "Por favor, rellena todos los campos del formulario.";
        }

        // Cerrar la conexión
        $conexion->close();
    }
    ?>

    <script>
        function toggleTheme() {
            var theme = document.getElementById('theme');
            if (theme.getAttribute('href') === 'styles-light.css') {
                theme.setAttribute('href', 'styles-dark.css');
            } else {
                theme.setAttribute('href', 'styles-light.css');
            }
        }
    </script>
</body>
</html>
