
<?php
//require_once("includes/config.php"); ESTA FUNCIONALIDAD NO HACE USO DE LA BBDD TODAVÍA

require_once("includes/reservarActividad/reservarActividad.php");

$tituloPagina = 'Reserva de Actividad';
$form = new reservarActividad();
$htmlForm = $form->Manage();

$contenidoPrincipal = <<<EOS
<h1>Reserva de Actividad</h1>
$htmlForm
EOS;

require("includes/comun/plantilla.php");
?>
