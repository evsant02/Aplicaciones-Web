<?php
require_once("includes/config.php");
require_once("includes/modificarActividad/modificarActividadForm.php");

$tituloPagina = 'Modificar Actividad';

// Obtener el ID de la actividad
$id = $_GET['id'];

if ($id){
    // Obtener la actividad
    $actividadAppService = actividadAppService::GetSingleton();
    $actividad = $actividadAppService->getActividadById($id);

    if (!$actividad) {
        $errorMensaje = "Error: La actividad no existe.";
        header("Location: vistaActividades.php?error=" . urlencode($errorMensaje));
        exit();
    }

    // Crear y mostrar el formulario
    $form = new modificarActividadForm($actividad);
    $htmlFormLogin = $form->Manage();
} else {
    $form = new modificarActividadForm();
    $htmlFormLogin = $form->Manage();
}


$contenidoPrincipal = <<<EOS
<h1>Modificar Actividad</h1>
$htmlFormLogin
EOS;

require("includes/comun/plantilla.php");
?>