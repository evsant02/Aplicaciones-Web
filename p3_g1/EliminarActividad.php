<?php
// Incluir los archivos necesarios para la configuración y el servicio de actividades
require_once("includes/config.php");
//require_once("includes/actividad/actividadAppService.php");

use includes\actividad\actividadAppService;
use includes\application;

// Verificar si se ha recibido un ID válido mediante GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Obtener la instancia del servicio de actividades
        $actividadAppService = actividadAppService::GetSingleton();

        // Intentar eliminar la actividad usando el método del servicio
        $resultado = $actividadAppService->eliminarPorId($id);

        // Guardar el mensaje en la sesión
        $app = application::getInstance();

        // Redirigir con el mensaje correspondiente según el resultado
        if ($resultado) {
            header("Location: vistaActividades.php");
            $mensaje = "¡Actividad eliminada con éxito!";
        } else {
            header("Location: vistaActividades.php");
            $mensaje= "Error al eliminar la actividad";
        }
        $app->putAtributoPeticion('mensaje', $mensaje);

        exit;

    } catch (Exception $e) {
        // Manejo de excepciones: redirigir con mensaje de error específico
        header("Location: vistaActividades.php?mensaje=Error: " . $e->getMessage());
        exit;
    }

} else {
    // Si no se recibe un ID válido, redirigir con un mensaje de error
    header("Location: vistaActividades.php?mensaje=ID inválido");
    exit;
}
?>
