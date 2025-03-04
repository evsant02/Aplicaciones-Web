<?php
// Incluir los archivos necesarios
require_once(__DIR__ . '/../actividad/actividadAppService.php');
require_once(__DIR__ . '/../actividad/actividadDTO.php');

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
                header("Location: actividades.php?mensaje=Actividad eliminada con éxito");
                exit;
            } else {
                // Si no fue exitosa, redirigir con un mensaje de error
                header("Location: actividades.php?mensaje=Error al eliminar la actividad");
                exit;
            }
        } else {
            // Si no se encontró la actividad, redirigir con un mensaje de error
            header("Location: actividades.php?mensaje=Actividad no encontrada");
            exit;
        }
    } catch (Exception $e) {
        // En caso de error, redirigir con un mensaje de excepción
        header("Location: actividades.php?mensaje=Error: " . $e->getMessage());
        exit;
    }
} else {
    // Si no se recibe un id válido, redirigir con un mensaje de error
    header("Location: actividades.php?mensaje=ID inválido");
    exit;
}
?>
