<?php
// Incluir los archivos necesarios para la configuración y el servicio de actividades
require_once("includes/config.php");
//require_once("includes/actividad/actividadAppService.php");

use includes\actividadesmensajes\actividadesmensajesAppService;
use includes\application;

// Verificar si se ha recibido un ID válido mediante GET
if (isset($_GET['id_usuario'], $_GET['id_actividad'], $_GET['mensaje'])) {
    $idUsuario = intval($_GET['id_usuario']);
    $idActividad = intval($_GET['id_actividad']);
    $idMensaje = intval($_GET['mensaje']);

    
        // Obtener la instancia del servicio de actividades
        $actividadAppService = actividadesmensajesAppService::GetSingleton();

        // Intentar eliminar la actividad usando el método del servicio
        $resultado = $actividadAppService->eliminarMensaje($idUsuario, $idActividad, $idMensaje);

        // Guardar el mensaje en la sesión
        $app = application::getInstance();

        header("Location: vistaForoNoticias.php");

        $app->putAtributoPeticion('mensaje', $mensaje);

        exit;

} else {
    // Si no se recibe un ID válido, redirigir con un mensaje de error
    header("Location: vistaForoNoticias.php?mensaje=ID inválido");
    exit;
}
?>
