<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "aw";

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
    <title>Crear Actividad - Conecta65</title>
</head>
<body>
    <h2>Crear Nueva Actividad</h2>
    <form action="" method="post">
        <label>Nombre de la actividad:</label>
        <input type="text" name="nombre" required><br>
        
        <label>Localización:</label>
        <input type="text" name="localizacion" required><br>
        
        <label>Fecha y hora:</label>
        <input type="datetime-local" name="fecha_hora" required><br>
        
        <label>Descripción detallada:</label>
        <textarea name="descripcion" required></textarea><br>
        
        <button type="submit">Crear</button>
    </form>
</body>
</html>
