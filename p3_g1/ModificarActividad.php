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
    $htmlFormModificar = $form->Manage();
} else {
    $form = new modificarActividadForm();
    $htmlFormModificar = $form->Manage();
}


$contenidoPrincipal = <<<EOS
<div class="formulario">
<h1>Modificar actividad</h1>
$htmlFormModificar
</div>
EOS;

require("includes/comun/plantilla.php");
?>