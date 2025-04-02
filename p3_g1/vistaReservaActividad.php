
<?php
require_once("includes/config.php");
require_once("includes/reservarActividad/reservarActividad.php");

$tituloPagina = 'Reserva de Actividad';

$form = new reservarActividad();
$htmlForm = $form->Manage();

$app = application::getInstance();
$actividadAppService = actividadAppService::GetSingleton();
$actividadUsuarioAppService = actividadesusuarioAppService::GetSingleton();
$actividadDTO = $actividadUsuarioAppService->getActividadById($_GET["id"]);

$contenidoPrincipal = <<<EOS
<h1>Reserva de Actividad</h1>
$htmlForm
EOS;

require("includes/comun/plantilla.php");
?>
