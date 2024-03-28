<!-- Este archivo es el que permite buscar en la pagina que es solo un buscador (index.html) -->
<?php
// Establecer conexión con la base de datos
include 'conexion.php';

// Obtener el término de búsqueda
$query = $_GET['query'];

// Realizar la consulta
$sql = "SELECT canciones.nomcancion, cds.nomcd, cds.numcd, artistas.nombre as nombre_artista 
        FROM canciones 
        INNER JOIN cds ON canciones.id_cd = cds.id 
        INNER JOIN artistas ON canciones.id_artista = artistas.id
        WHERE canciones.nomcancion LIKE '%$query%'
        OR cds.nomcd LIKE '%$query%'
        OR CAST(cds.numcd AS CHAR) LIKE '%$query%'
        OR artistas.nombre LIKE '%$query%'";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    // Mostrar resultados
    echo "<table border='1'>";
    echo "<tr><th>Canción</th><th>CD</th><th>Número de CD</th><th>Artista</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["nomcancion"]. "</td><td>" . $row["nomcd"]. "</td><td>" . $row["numcd"]. "</td><td>" . $row["nombre_artista"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 resultados";
}
$conexion->close();
?>
