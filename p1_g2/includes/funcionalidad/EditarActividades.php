<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "conecta65";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $localizacion = $_POST['localizacion'];
    $fecha_hora = $_POST['fecha_hora'];
    $descripcion = $_POST['descripcion'];
    
    $sql = "INSERT INTO actividades (nombre, localizacion, fecha_hora, descripcion) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $localizacion, $fecha_hora, $descripcion);
    
    if ($stmt->execute()) {
        header("Location: actividades.php");
    } else {
        echo "Error al crear actividad: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actividades - Conecta65</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Lista de Actividades</h2>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Localización</th>
            <th>Fecha y Hora</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
        <?php
        $sql = "SELECT id, nombre, localizacion, fecha_hora, descripcion FROM actividades";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['nombre'] . "</td>";
            echo "<td>" . $row['localizacion'] . "</td>";
            echo "<td>" . $row['fecha_hora'] . "</td>";
            echo "<td>" . $row['descripcion'] . "</td>";
            echo "<td>
                    <a href='modificar.php?id=" . $row['id'] . "'>Modificar</a> |
                    <a href='eliminar.php?id=" . $row['id'] . "' onclick='return confirm('¿Seguro que quieres eliminar esta actividad?')'>Eliminar</a>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
