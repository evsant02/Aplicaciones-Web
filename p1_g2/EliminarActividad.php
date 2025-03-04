<?php
// Incluir los archivos necesarios
require_once("includes/config.php");
require_once("includes/actividad/actividadAppService.php");
require_once("includes/actividad/actividadDTO.php");

// Verificar si se ha recibido un id para eliminar
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Obtener la instancia del servicio de aplicación
        $actividadAppService = actividadAppService::GetSingleton();

        // Obtener la actividad por ID
        $actividad = $actividadAppService->getActividadById($id);

        if ($actividad !== null) {
            // Eliminar la actividad
            $resultado = $actividadAppService->eliminar($actividad);

            // Si la eliminación fue exitosa, redirigir a la página de actividades con un mensaje de éxito
            if ($resultado) {
                header("Location: EditarActividades.php?mensaje=Actividad eliminada con éxito");
                exit;
            } else {
                // Si no fue exitosa, redirigir con un mensaje de error
                header("Location: EditarActividades.php?mensaje=Error al eliminar la actividad");
                exit;
            }
        } else {
            // Si no se encontró la actividad, redirigir con un mensaje de error
            header("Location: EditarActividades.php?mensaje=Actividad no encontrada");
            exit;
        }
    } catch (Exception $e) {
        // En caso de error, redirigir con un mensaje de excepción
        header("Location: EditarActividades.php?mensaje=Error: " . $e->getMessage());
        exit;
    }
} else {
    // Si no se recibe un id válido, redirigir con un mensaje de error
    header("Location: EditarActividades.php?mensaje=ID inválido");
    exit;
}
?>
