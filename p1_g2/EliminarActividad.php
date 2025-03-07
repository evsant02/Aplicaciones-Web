<?php
// Incluir los archivos necesarios para la configuración y el servicio de actividades
require_once("includes/config.php");
require_once("includes/actividad/actividadAppService.php");
require_once("includes/actividad/actividadDTO.php");

// Verificar si se ha recibido un ID válido mediante GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Obtener la instancia del servicio de actividades
        $actividadAppService = actividadAppService::GetSingleton();

        // Obtener la actividad de la base de datos mediante su ID
        $actividad = $actividadAppService->getActividadById($id);

        if ($actividad !== null) {
            // Intentar eliminar la actividad
            $resultado = $actividadAppService->eliminar($actividad);

            // Si la eliminación fue exitosa, redirigir con mensaje de éxito
            if ($resultado) {
                header("Location: EditarActividades.php?mensaje=Actividad eliminada con éxito");
                exit;
            } else {
                // Redirigir con mensaje de error si la eliminación falla
                header("Location: EditarActividades.php?mensaje=Error al eliminar la actividad");
                exit;
            }
        } else {
            // Si la actividad no existe, redirigir con mensaje de error
            header("Location: EditarActividades.php?mensaje=Actividad no encontrada");
            exit;
        }
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
