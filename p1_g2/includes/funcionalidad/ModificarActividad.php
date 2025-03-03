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

// Obtener la actividad a modificar
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM actividades WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $actividad = $result->fetch_assoc();
} else {
    die("ID de actividad no proporcionado.");
}

// Actualizar la actividad
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $localizacion = $_POST['localizacion'];
    $fecha_hora = $_POST['fecha_hora'];
    $descripcion = $_POST['descripcion'];
    
    $sql = "UPDATE actividades SET nombre=?, localizacion=?, fecha_hora=?, descripcion=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nombre, $localizacion, $fecha_hora, $descripcion, $id);
    
    if ($stmt->execute()) {
        header("Location: actividades.php");
    } else {
        echo "Error al modificar actividad: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Actividad - Conecta65</title>
</head>
<body>
    <h2>Modificar Actividad</h2>
    <form action="" method="POST">
        <label>Nombre de la actividad:</label>
        <input type="text" name="nombre" value="<?php echo $actividad['nombre']; ?>" required><br>
        
        <label>Localización:</label>
        <input type="text" name="localizacion" value="<?php echo $actividad['localizacion']; ?>" required><br>
        
        <label>Fecha y Hora:</label>
        <input type="datetime-local" name="fecha_hora" value="<?php echo date('Y-m-d\TH:i', strtotime($actividad['fecha_hora'])); ?>" required><br>
        
        <label>Descripción:</label>
        <textarea name="descripcion" required><?php echo $actividad['descripcion']; ?></textarea><br>
        
        <input type="submit" value="Guardar Cambios">
    </form>
</body>
</html>
