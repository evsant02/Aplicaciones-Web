<?php

require_once("includes/config.php");

// Asegúrate de que el ID de la actividad se pasa correctamente, por ejemplo, a través de la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Redirigir directamente a eliminarActividad.php para realizar la eliminación
    header("Location: includes/editarActividades/eliminarActividad.php?id=" . $id);
    exit; // Asegúrate de terminar el script después de la redirección
} else {
    // Si no se proporciona un ID válido, redirigir a la página principal o mostrar un mensaje de error
    header("Location: EditarActividades.php?mensaje=ID inválido");
    exit;
}
?>
