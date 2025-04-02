<?php

require_once("includes/reservarActividad/reservarActividad.php");

$tituloPagina = 'Reserva de Actividad';
$id = $_GET['id'];

// Obtiene la instancia de la aplicación (probablemente un patrón Singleton)
$app = Application::getInstance();

// Recupera un mensaje almacenado en la petición (puede ser un mensaje de error o confirmación)
$mensaje = $app->getAtributoPeticion('mensaje');

$actividadAppService = actividadAppService::GetSingleton();
$actividad = $actividadAppService->getActividadById($id);

$reservarActividad = new reservarActividad($actividad);
$htmlReservarActividad = $reservarActividad->Inicializacion();

$contenidoPrincipal = <<<EOS
<p>$mensaje</p>
<h1>Reserva de Actividad</h1>
$htmlReservarActividad
EOS;

require("includes/comun/plantilla.php");
?>
