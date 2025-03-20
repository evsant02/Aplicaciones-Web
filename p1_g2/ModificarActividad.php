<?php

// Se incluyen los archivos necesarios para la configuración y el formulario de modificación
require_once("includes/config.php");
require_once("includes/modificarActividad/modificarActividadForm.php");

// Se define el título de la página
$tituloPagina = 'Modificar Actividad';

// Se obtiene el ID de la actividad desde GET o POST
$id = $_GET['id'] ?? null;

// Si no se proporciona un ID, se muestra un error y se detiene la ejecución
if (!$id) {
    die("Error: No se ha especificado una actividad válida.");
}

// Se obtiene la instancia del servicio de actividades
$actividadAppService = actividadAppService::GetSingleton();

// Se busca la actividad en la base de datos usando el ID
$actividad = $actividadAppService->getActividadById($id);

// Si la actividad no existe, se muestra un error y se detiene la ejecución
if (!$actividad) {
    die("Error: La actividad no existe.");
}

// Se crea una instancia del formulario de modificación con los datos de la actividad
$form = new modificarActividadForm($actividad);

// Se genera el formulario en HTML
$htmlFormLogin = $form->Manage();

// Se define el contenido principal de la página
$contenidoPrincipal = <<<EOS
<h1>Modificar Actividad</h1>
$htmlFormLogin
EOS;

// Se carga la plantilla general de la página
require("includes/comun/plantilla.php");

?>
