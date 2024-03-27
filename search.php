<?php
// Establecer conexión con la base de datos
include 'conexion.php';

// Obtener el término de búsqueda
$query = $_GET['query'];

// Realizar la consulta
$sql = "SELECT * FROM canciones WHERE nomcancion LIKE '%$query%'";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    // Mostrar resultados
    echo "<table border='1'>";
    echo "<tr><th>Canción</th><th>CD</th><th>Número de CD</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["nomcancion"]. "</td><td>" . $row["nomcd"]. "</td><td>" . $row["numcd"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 resultados";
}
$conexion->close();
?>