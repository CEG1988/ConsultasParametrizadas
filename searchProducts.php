<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "S3gur1d4d";
$dbname = "myDB";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verificar si se recibió la variable 'searchText'
if(isset($_GET['searchText'])) {
    // Preparar la consulta SQL con una sentencia parametrizada
    $searchText = "%" . $_GET['searchText'] . "%";
    $sql = "SELECT * FROM empleados WHERE nombre LIKE ? OR cargo LIKE ? OR departamento LIKE ?";
    $stmt = $conn->prepare($sql);

    // Verificar si la preparación de la consulta fue exitosa
    if ($stmt) {
        // Vincular los parámetros y ejecutar la consulta
        $stmt->bind_param("sss", $searchText, $searchText, $searchText);
        $stmt->execute();
        
        // Obtener resultados de la consulta
        $result = $stmt->get_result();

        // Generar tabla HTML con los resultados
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["nombre"] . "</td><td>" . $row["cargo"] . "</td><td>" . $row["departamento"] . "</td><td>" . $row["salario"] . "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No se encontraron empleados</td></tr>";
        }

        // Cerrar la consulta y liberar recursos
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
    }
} else {
    echo "<tr><td colspan='4'>Por favor, ingrese un término de búsqueda</td></tr>";
}

// Cerrar conexión
$conn->close();
?>