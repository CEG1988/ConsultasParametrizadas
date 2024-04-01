<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "S3gur1d4d";
$dbname = "myDBVentas";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verificar si se recibieron las variables 'startDate' y 'endDate'
if(isset($_GET['startDate']) && isset($_GET['endDate'])) {
    // Preparar la consulta SQL con una sentencia parametrizada
    $startDate = $_GET['startDate'];
    $endDate = $_GET['endDate'];
    $sql = "SELECT fecha, SUM(total) AS total_ventas FROM ventas WHERE fecha BETWEEN ? AND ? GROUP BY fecha";
    $stmt = $conn->prepare($sql);

    // Verificar si la preparación de la consulta fue exitosa
    if ($stmt) {
        // Vincular los parámetros y ejecutar la consulta
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        
        // Obtener resultados de la consulta
        $result = $stmt->get_result();

        // Preparar datos para el gráfico
        $dataPoints = array();
        while($row = $result->fetch_assoc()) {
            $dataPoints[] = array("label" => $row["fecha"], "y" => $row["total_ventas"]);
        }

        // Convertir datos a formato JSON
        echo json_encode($dataPoints);

        // Cerrar la consulta y liberar recursos
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
    }
} else {
    echo "Por favor, seleccione una fecha de inicio y una fecha de fin";
}

// Cerrar conexión
$conn->close();
?>
