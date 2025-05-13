<?php
// Incluir los archivos necesarios para la configuración y el servicio de actividades
require_once("includes/config.php");

use includes\usuario\userAppService;
use includes\application;

// Verificar si se ha recibido un ID válido mediante GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

        // Obtener la instancia del servicio de actividades
        $usuarioAppService = userAppService::GetSingleton();

        // Intentar eliminar la actividad usando el método del servicio
        $resultado = $usuarioAppService->borrar($id);

        // Guardar el mensaje en la sesión
        $app = application::getInstance();

        // Redirigir con el mensaje correspondiente según el resultado
        if ($resultado) {
            header("Location: index.php");
            // Elimina todas las variables de sesión
            unset($_SESSION);
            // Destruye la sesión actual
            session_destroy(); 
        } else {
            header("Location: perfil.php");
        }
        exit;

} else {
    // Si no se recibe un ID válido, redirigir con un mensaje de error
    header("Location: perfil.php?mensaje=ID inválido");
    exit;
}
?>
