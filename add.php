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
        
        <label for="nombre_cd">Nombre del CD:</label>
        <input type="text" id="nombre_cd" name="nombre_cd" required><br><br>
        
        <label for="numero_cd">Número de CD:</label>
        <input type="number" id="numero_cd" name="numero_cd" required><br><br>
        
        <button type="submit" name="submit">Agregar Canción</button>
    </form>

    <?php
    // Incluir el archivo de conexión a la base de datos
    include 'conexion.php';

    // Verificar si se han enviado los datos del formulario
    if(isset($_POST['submit'])) {
        if(isset($_POST['nombre_cancion'], $_POST['nombre_cd'], $_POST['numero_cd'])) {
            // Recuperar los datos del formulario
            $nombre_cancion = $_POST['nombre_cancion'];
            $nombre_cd = $_POST['nombre_cd'];
            $numero_cd = $_POST['numero_cd'];

            // Preparar la consulta SQL para insertar la nueva canción
            $consulta = "INSERT INTO canciones (nomcancion, nomcd, numcd) VALUES ('$nombre_cancion', '$nombre_cd', '$numero_cd')";

            // Ejecutar la consulta
            if(mysqli_query($conexion, $consulta)) {
                echo "La canción se ha agregado correctamente. <br>";
                echo "<a href='index.php'>Volver a la página principal</a>";
            } else {
                echo "Error al agregar la canción: " . mysqli_error($conexion);
            }
        } else {
            echo "Por favor, rellena todos los campos del formulario.";
        }
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
