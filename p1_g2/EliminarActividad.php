<?php
// Incluir los archivos necesarios para la configuración y el servicio de actividades
require_once("includes/config.php");
require_once("includes/actividad/actividadAppService.php");

// Verificar si se ha recibido un ID válido mediante GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Obtener la instancia del servicio de actividades
        $actividadAppService = actividadAppService::GetSingleton();

        // Intentar eliminar la actividad usando el método del servicio
        $resultado = $actividadAppService->eliminarPorId($id);

        // Redirigir con el mensaje correspondiente según el resultado
        if ($resultado) {
            header("Location: EditarActividades.php?mensaje=Actividad eliminada con éxito");
        } else {
            header("Location: EditarActividades.php?mensaje=Error al eliminar la actividad");
        }
        exit;

    } catch (Exception $e) {
        // Manejo de excepciones: redirigir con mensaje de error específico
        header("Location: EditarActividades.php?mensaje=Error: " . $e->getMessage());
        exit;
    }

} else {
    // Si no se recibe un ID válido, redirigir con un mensaje de error
    header("Location: EditarActividades.php?mensaje=ID inválido");
    exit;
}
?>
