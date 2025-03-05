<?php

require_once("includes/config.php");
//require_once("includes/actividad/actividadAppService.php");
require_once("includes/modificarActividad/modificarActividadForm.php");

$tituloPagina = 'Modificar Actividad';

$id = $_GET['id'] ?? $_POST['id'] ?? null;

if (!$id) {
    die("Error: No se ha especificado una actividad válida.");
}

$actividadAppService = actividadAppService::GetSingleton();
$actividad = $actividadAppService->getActividadById($id); // Obtener la actividad de la BD

if (!$actividad) {
    die("Error: La actividad no existe.");
}

$form = new modificarActividadForm($actividad); // Pasamos la actividad al formulario
$htmlFormLogin = $form->Manage();

$contenidoPrincipal = <<<EOS
<h1>Modificar Actividad</h1>
$htmlFormLogin
EOS;

require("includes/comun/plantilla.php");
?>
