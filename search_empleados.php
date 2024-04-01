<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "S3gur1d4d";
$dbname = "myDBEmpleados";

$conn = new mysqli($servername, $username, $password, $dbname);

// Consulta SQL para buscar empleados por nombre, cargo o departamento
$searchText = $_GET['searchText'];
$sql = "SELECT * FROM empleados WHERE nombre LIKE '%$searchText%' OR cargo LIKE '%$searchText%' OR departamento LIKE '%$searchText%'";
$result = $conn->query($sql);

// Generar tabla HTML con los resultados
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["nombre"] . "</td><td>" . $row["cargo"] . "</td><td>" . $row["departamento"] . "</td><td>" . $row["salario"] . "</td></tr>";
    }
} else {
    echo "<tr><td colspan='4'>No se encontraron empleados</td></tr>";
}
$conn->close();
?>
